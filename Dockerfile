FROM dokken/ubuntu-18.04


WORKDIR /www/app
COPY  . .

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    rm -rf /var/lib/apt/lists/*

RUN add-apt-repository ppa:ondrej/php  -y &&\
    apt update && sudo apt dist-upgrade -y &&\
    apt install php8.1 -y



