FROM php:8.1.1-fpm

ARG user=user_fc
ARG uid=1000

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

USER $user
