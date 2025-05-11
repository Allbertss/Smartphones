import os
from dotenv import load_dotenv
from apiClient import APIClient
from BreezyScraper import BreezyScraper


def main():
    load_dotenv()

    base_url = os.getenv("API_BASE_URL")
    auth_token = os.getenv("API_AUTH_TOKEN")
    brezzy_url = os.getenv("BREZZY_URL")

    scraper = BreezyScraper(url=brezzy_url)

    api_client = APIClient(base_url=base_url, auth_token=auth_token)

    total_success = 0
    total_error = 0

    try:
        for page_data in scraper.scrape():
            if page_data:
                result = api_client.send_data(page_data)

                total_success += result["success_count"]
                total_error += result["error_count"]

    finally:
        print(f"\nDone scraping.")
        print(f"Stored in a database: {total_success}")
        print(f"Failed to store: {total_error}")


if __name__ == "__main__":
    main()
