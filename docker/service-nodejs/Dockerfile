FROM node:10.14
WORKDIR "/var/www"

RUN npm install -g laravel-echo-server \
    && cd /var/www

COPY conf/laravel-echo-server.json /var/www/laravel-echo-server.json

EXPOSE 6001

CMD ["node"]