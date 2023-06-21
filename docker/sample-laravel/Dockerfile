FROM debian:latest

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=Europe/Warsaw

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt update && apt upgrade -y
RUN apt install -y unzip curl wget bash git mc zip lsb-release ca-certificates apt-transport-https \
    software-properties-common gnupg2 p7zip-full gnupg gosu supervisor sqlite3 libcap2-bin libpng-dev \
    python3 python3-pip iproute2 default-mysql-client postgresql-client netcat-openbsd

RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list
RUN wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add -
RUN apt update && apt upgrade -y

RUN apt install -y php8.2 php8.2-fpm php8.2-grpc php8.2-gd php8.2-imap php8.2-intl php8.2-xdebug php8.2-redis \
    php8.2-zip php8.2-xsl php8.2-mysql php8.2-protobuf php8.2-sqlite3 php8.2-pgsql php8.2-curl php8.2-mbstring \
    php8.2-xml php8.2-bcmath php8.2-soap php8.2-readline php8.2-ldap php8.2-msgpack php8.2-igbinary php8.2-memcached \
    php8.2-pcov

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - && apt install -y nodejs

RUN apt -y autoremove && apt clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.2

RUN groupadd --force -g 1000 sail
RUN useradd -ms /bin/bash --no-user-group -g 1000 -u 1337 sail

COPY start-container /usr/local/bin/start-container
COPY wait-for /usr/local/bin/wait-for
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.2/cli/conf.d/99-sample.ini

RUN chmod +x /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/wait-for

EXPOSE 8000

ENTRYPOINT ["start-container"]
