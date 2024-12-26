# از یک تصویر پایه PHP استفاده می‌کنیم
FROM php:7.4-apache

# نصب composer برای مدیریت وابستگی‌ها
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# تنظیم پوشه کاری
WORKDIR /var/www/html

# کپی کردن کد منبع به داخل کانتینر
COPY . .

# نصب وابستگی‌ها با استفاده از Composer
RUN composer install

# پورت مورد نظر برای سرویس
EXPOSE 80

# شروع کردن سرور Apache
CMD ["apache2-foreground"]
