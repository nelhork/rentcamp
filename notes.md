```
// Версия Docker Compose
version: "3.1"

// Сервис PostgreSQL
// Запускает PostgreSQL в контейнере
// Создает БД rentcamp с пользователем user
// Сохраняет даные в /opt/rentcamp_postgres_data:/var/lib/postgresql/data
// чтобы не терять после перезапуска
// Открывает порт 5432 чтобы можно было подключаться
services:
  db:
    image: postgres:latest
    container_name: rentcamp-postgres
    environment:
      POSTGRES_USER: user
      POSTGRES_PASSWORD: secret
      POSTGRES_DB: rentcamp
    ports:
      - "5432:5432"
    volumes:
      - /opt/rentcamp_postgres_data:/var/lib/postgresql/data
      
  // Запусккает Nginx с легкой версией alpine
  // Монтирует файлы проекта в контейнер
  // Берет настройки Nginx из файла /rentcamp/nginx/nginx.conf
  // Открывает порты: 80 для веб-сайта, 443 для HTTPS
  // Запускается только после PHP-FPM
  webserver:
    image: nginx:alpine
    container_name: rentcamp-webserver
    working_dir: /application
    volumes:
      - .:/application
      - ./docker/nginx/nginx.conf:/etc/nginx/conf.d/default.conf
    ports:
      - "80:80"
      - "8000:8000"
      - "443:443"
    depends_on:
      - php-fpm
  // Собирает PHP-FPM из docker/php-fpm/Dockerfile    
  php-fpm:
    build: docker/php-fpm
    container_name: rentcamp-php-fpm
    working_dir: /application
    volumes:
      - .:/application
      - ./docker/php-fpm/php-ini-overrides.ini:/usr/local/etc/php/conf.d/99-overrides.ini
```