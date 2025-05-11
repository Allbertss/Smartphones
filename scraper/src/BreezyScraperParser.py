import re


class BreezyScraperParser:
    def __init__(self):
        pass

    def get_grade(self, title):
        match = re.search(r"\b([A-D]{1,2}) ?grade\b", title, re.IGNORECASE)

        if match:
            return match.group(1).upper()

        match = re.search(r"\bgrade ?([A-D]{1,2})\b", title, re.IGNORECASE)

        if match:
            return match.group(1).upper()

        return None

    def get_condition(self, title):
        match = re.search(r"\b(used|new|refurbished)\b", title, re.IGNORECASE)

        if match:
            return match.group(1).capitalize()

        return None

    def parse_title(self, title):
        """
        Known possible title formats:
            Smartphone APPLE iPhone 12 128GB Black, D grade, Used
            iPhone 12 Pro 256GB MIX, Model A2407, USED, AB Grade
        """

        cleaned_title = title.replace("Smartphone", "").strip()

        parts = [part.strip() for part in cleaned_title.split(",")]

        first_part = parts[0]

        known_brands = [
            "APPLE",
            "SAMSUNG",
            "GOOGLE",
            "XIAOMI",
            "HUAWEI",
            "OPPO",
            "ONEPLUS",
            "REALME",
            "NOKIA",
            "SONY",
            "MOTOROLA",
            "LG",
            "VIVO",
        ]
        words = first_part.split()
        brand = None
        model = None

        if words[0].upper() in known_brands:
            brand = words[0].upper()
            model = " ".join(words[1:])
        else:
            brand = None
            model = " ".join(words)

        grade = self.get_grade(title)
        condition = self.get_condition(title)

        return {
            "brand": brand if brand else "",
            "model": model if model else "",
            "grade": grade if grade else "",
            "condition": condition if condition else "",
        }
