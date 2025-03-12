# Используем официальный образ Nginx
FROM nginx:latest

# Указываем директорию для содержимого сайта
# (директория будет передана через volume при запуске контейнера)
# Путь по умолчанию в образе Nginx: /usr/share/nginx/html
WORKDIR /usr/share/nginx/html

# Настроим конфигурацию Nginx (если нужно)
COPY ./nginx.conf /etc/nginx/nginx.conf

# Порты, которые будет слушать Nginx
EXPOSE 80
