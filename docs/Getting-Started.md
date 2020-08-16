# Setup Environment

## Docker

- Install Docker

- Configure

Edit `.docker/conf.d/default.conf` for nginx

Edit `.docker/local.ini` for php

- Local DNS

Edit `.docker/dnsmasq.conf` to map custom domain like this

`address=/.test/127.0.0.1`

and for every new TLD you need to tell local network to query local DNS

```
sudo mkdir -p /etc/resolver
echo 'nameserver 127.0.0.1' | sudo tee /etc/resolver/test
```

- Start 
launch docker by running

`docker-compose up -d`

# Local SSL
For facebook login etc...

`brew install mkcert`

then 

`cp .docker/rootCA* "$(mkcert -CAROOT)" && mkcert -install`

## New SSL Domains

To generate new certs for a new domain execute following in `.docker/`

`mkcert turk.test "*.turk.test" localhost 127.0.0.1 ::1`

then map the certificate files in `docker-compose.yml` for nginx or nginx-proxy like this:
```
    volumes:
      - .docker/turk.test.pem:/etc/ssl/nginx.crt
      - .docker/turk.test-key.pem:/etc/ssl/nginx.key
```
