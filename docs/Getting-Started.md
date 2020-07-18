# Setup Environment

## Docker

Install Docker

Edit `.docker/conf.d/default.conf` for nginx

Edit `.docker/dnsmasq.conf` to setup custom domain like 
```address=/.test/127.0.0.1```
and
```sudo mkdir -p /etc/resolver
echo 'nameserver 127.0.0.1' | sudo tee /etc/resolver/test```

Start docker by running
`docker-compose up -d`

For local SSL
`brew install mkcert`

then 
`mkcert -install`
and execute following in `.docker/`
`mkcert turk.test "*.turk.test" localhost 127.0.0.1 ::1`
then map the certificate files in `docker-compose.yml` for nginx or nginx-proxy like this:
```
    volumes:
      - .docker/turk.host.pem:/etc/ssl/nginx.crt
      - .docker/turk.host-key.pem:/etc/ssl/nginx.key
```
