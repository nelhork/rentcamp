# Используется официальный образ PHP 8.4 с поддержкой FPM
# образ нужен для работы с Nginx, который взаимодействует с PHP-FPM
FROM php:8.1-fpm

WORKDIR "/application"

# Обновляет список доступных пакетов в системе
RUN apt-get update \
#    make - инструмент сборки кода \
#    curl - для скачивания файлов по HTTP/HTTPS \
#    libz-dev, zlib1g-dev - библиотеки для работы с ZIP-архивами \
#    libssl-dev, openssl, gnupg - библиотеки для шифрования и работы с SSL \
#    libzip-dev - поддержка ZIP-архивов \
#    php-pgsql - драйвер для работы PHP с PostgreSQL
    && apt-get install -y \
     make \
     curl \
     libz-dev \
     sshpass \
     unzip \
     zlib1g-dev \
     libssl-dev \
     openssl \
     gnupg \
     libzip-dev \
     libpq-dev \
#    Скачивает Composer (менеджер зависимостей PHP) \
#    Устанавливает его в /usr/local/bin как composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
#    Очистка ненужных файлов для уменьшения размера контейнера \
#    apt-get clean - очищает кеш APT \
#    rm -rf - удаляет временные файлы и документацию
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Устанавливает встроенные расширения PHP для PostgreSQL, pdo_pgsql - расширение для PDO и PostgreSQL
# позволяющее работать с БД через ORM
RUN docker-php-ext-install pdo_pgsql
