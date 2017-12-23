FROM nginx:1.13

RUN rm -f /etc/nginx/nginx.conf /etc/nginx/conf.d/*

ADD ./nginx.conf /etc/nginx/nginx.conf
ADD ./upstream.conf /etc/nginx/conf.d/upstream.conf
ADD ./app.conf /etc/nginx/conf.d/app.conf