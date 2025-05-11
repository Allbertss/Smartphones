import pytest
from BreezyScraperParser import BreezyScraperParser


@pytest.mark.parametrize(
    "title,expected",
    [
        (
            "Smartphone APPLE iPhone 12 128GB Black, D grade, Used",
            {
                "brand": "APPLE",
                "model": "iPhone 12 128GB Black",
                "grade": "D",
                "condition": "Used",
            },
        ),
        (
            "iPhone 12 Pro 256GB MIX, Model A2407, USED, AB Grade",
            {
                "brand": "",
                "model": "iPhone 12 Pro 256GB MIX",
                "condition": "Used",
                "grade": "AB",
            },
        ),
        (
            "Smartphone APPLE iPhone 12 128GB Green, Grade A, Used",
            {
                "brand": "APPLE",
                "model": "iPhone 12 128GB Green",
                "grade": "A",
                "condition": "Used",
            },
        ),
    ],
)
def test_parse_title(title, expected):
    parser = BreezyScraperParser()

    result = parser.parse_title(title)

    assert result == expected
