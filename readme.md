# Smartphones

## 📁 Project Structure

- **[api](./api)**:
- **[scraper](./scraper)**:
- **[frontend](./frontend)**: 
- **`docker-compose.yml`**:

## 🚀 Running the Project

To start the project locally using Docker, run the following command:

```bash
docker-compose up
```

## 🔧 API Setup

```bash
docker compose exec api composer install
docker compose exec api php bin/console doctrine:migrations:migrate
```

To start scraper

```bash
docker compose run scraper python src/main.py
```

## 🌐 Access Points

- **Frontend**: [http://localhost:3000](http://localhost:3000)
- **API**: [http://localhost:8000/api](http://localhost:8000/api)
