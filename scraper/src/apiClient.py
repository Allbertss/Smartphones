import requests


class APIClient:
    def __init__(self, base_url, auth_token=None):
        self.base_url = base_url.rstrip("/")
        self.auth_token = auth_token
        self.headers = {
            "Content-Type": "application/json",
        }

        if self.auth_token:
            self.headers["Authorization"] = f"Bearer {self.auth_token}"

    def send_data(self, data_list):
        url = f"{self.base_url}/smartphones"

        success_count = 0
        error_count = 0

        for data in data_list:
            response = requests.post(url, json=data, headers=self.headers, timeout=10)
            
            print(f"Response message: {response.text}")
            print(f"Response status code: {response.status_code}")

            if response.status_code in (200, 201):
                success_count += 1
            else:
                error_count += 1

        return {
            "success_count": success_count,
            "error_count": error_count,
        }
