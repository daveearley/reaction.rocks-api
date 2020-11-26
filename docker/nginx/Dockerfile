FROM nginx:latest

RUN rm /etc/nginx/nginx.conf && echo 'Deleting default nginx.conf'
RUN rm /etc/nginx/conf.d/default.conf && echo 'Deleting default default.conf'

ADD nginx.conf /etc/nginx/nginx.conf
ADD default.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]

EXPOSE 80 443