import random
import re
from playwright.sync_api import sync_playwright
from BreezyScraperConfig import BreezyScraperConfig
from BreezyScraperParser import BreezyScraperParser


class BreezyScraper:
    def __init__(self, url):
        self.url = url
        self.parser = BreezyScraperParser()

    def get_unique_identifier(self, card):
        a_tag_element = card.query_selector("a.product-card-info__title")

        if not a_tag_element:
            return None

        href = a_tag_element.get_attribute("href")

        return href.split("/")[-1] if href else None

    def get_title(self, card):
        title_element = card.query_selector(".product-card-info__title")

        if not title_element:
            return None

        title = title_element.inner_text().strip()

        if not title:
            return None

        return title

    def get_price(self, card):
        price_element = card.query_selector(".price-text__value")

        if not price_element:
            return None

        price_text = price_element.text_content().strip()

        if not price_text:
            return None

        price_text = price_text.replace(",", ".")
        price_text = re.sub(r"\s+", "", price_text)
        price_text = re.sub(r"[^\d.]", "", price_text)

        if not price_text:
            return None

        try:
            price_float = float(price_text)
        except ValueError:
            return None

        price_cents = int(round(price_float * 100))

        return price_cents

    def get_page_cards(self, page):
        data = []

        cards = page.query_selector_all("div.subcategory-content li")

        for card in cards:
            unique_identifier = self.get_unique_identifier(card)

            if not unique_identifier:
                continue

            title = self.get_title(card)

            if not title:
                continue

            price = self.get_price(card)

            if not price:
                continue

            data.append(
                {
                    **self.parser.parse_title(title),
                    "uniqueIdentifier": unique_identifier,
                    "category": BreezyScraperConfig.DEFAULT_CATEGORY,
                    "price": int(price),
                }
            )

        return data

    def scrape(self):
        try:
            with sync_playwright() as playwright:
                try:
                    browser = playwright.chromium.launch(
                        headless=BreezyScraperConfig.HEADLESS_BROWSER
                    )

                    context = browser.new_context()

                    page = context.new_page()
                except Exception as e:
                    print(f"Error launching browser or creating context: {e}")

                    return

                try:
                    page.goto(self.url)
                except Exception as e:
                    print(f"Failed to navigate to URL {self.url}: {e}")

                    browser.close()

                    return

                next_button_selector = ".v-pagination__next button"

                current_page = 1

                while True:
                    print(f"Scraping page {current_page}")

                    try:
                        page.wait_for_timeout(
                            random.randint(
                                max(
                                    BreezyScraperConfig.TIMEOUT_BETWEEN_PAGES_LOWER, 250
                                ),
                                BreezyScraperConfig.TIMEOUT_BETWEEN_PAGES_UPPER,
                            )
                        )

                        page_data = self.get_page_cards(page)

                        print(page_data)

                        yield page_data
                    except Exception as e:
                        print(f"Error scraping page {current_page}: {e}")

                        break

                    try:
                        page.locator(next_button_selector).wait_for(timeout=5000)

                        is_next_button_disabled = (
                            page.locator(next_button_selector).get_attribute("disabled")
                            is not None
                        )
                    except Exception as e:
                        print(f"Error checking next button status: {e}")

                        break

                    if is_next_button_disabled:
                        break

                    current_page += 1

                    if current_page > BreezyScraperConfig.MAX_PAGES_TO_SCRAPE:
                        break

                    try:
                        page.goto(f"{self.url}?page={current_page}")
                    except Exception as e:
                        print(f"Failed to go to page {current_page}: {e}")

                        break

                browser.close()

        except Exception as e:
            print(f"Playwright failed to initialize: {e}")
