FROM nginx:alpine
WORKDIR "/var/www"

COPY admin.myproject.ll.conf /etc/nginx/conf.d/admin.myproject.ll.conf
COPY myproject.ll.conf /etc/nginx/conf.d/myproject.ll.conf
COPY auth/htpasswd /etc/nginx/auth/htpasswd