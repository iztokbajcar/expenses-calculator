FROM alpine:3.15.0 AS base

RUN apk upgrade --update-cache --available && \
    apk add openssl && \
    rm -rf /var/cache/apk/
WORKDIR /ssl
RUN ["touch", "calc.crt"]
RUN ["touch", "calc.key"]
RUN ["touch", "pma.crt"]
RUN ["touch", "pma.key"]
RUN ["openssl", "req", "-x509", "-nodes", "-days", "365", "-newkey", "rsa:2048", "-keyout", "calc.key", "-out", "calc.crt", "-subj", "/C=SL/ST=Ljubljana/L=Ljubljana/O=/OU=/CN="],
RUN ["openssl", "req", "-x509", "-nodes", "-days", "365", "-newkey", "rsa:2048", "-keyout", "pma.key", "-out", "pma.crt", "-subj", "/C=SL/ST=Ljubljana/L=Ljubljana/O=/OU=/CN="],

FROM nginx:1.21.5

COPY --from=base /ssl /etc/ssl/certs/nginx/
COPY ./default.conf /etc/nginx/conf.d/default.conf
COPY ./includes/ /etc/nginx/includes/
