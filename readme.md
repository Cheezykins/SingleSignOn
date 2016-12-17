# Single Sign On Site

A site to provide access control to sites and services through Nginx, Built on [Laravel](https://laravel.com/).

Nginx requires the [auth_request](http://nginx.org/en/docs/http/ngx_http_auth_request_module.html) module.

## Nginx Setup for protected hosts

Nginx acts as a reverse proxy to the protected sites. For each request, Nginx makes an internal request to the single sign on site to validate that a user is allowed access.

For these examples I am assuming that your single sign on site is hosted at https://auth.example.com/ and your protected content is at https://subdomain.example.com/

To achieve this, in your reverse proxy site config add the following to ensure that failed authentication is directed to the single sign on site.

```nginx
error_page 401 = @error401;
location @error401 {
    return 302 https://auth.example.com;
}
```

Then initiate the auth_request module and tell it authorization requests go to /auth

``` auth_request /auth/;```

Now finally set up the /auth location to reverse proxy to the authentication site with appropriate tokens.

```nginx
location /auth {
    internal;
    proxy_pass https://auth.example.com;

    proxy_pass_request_body off;
    proxy_set_header Content-Length "";
    proxy_set_header X-Original-URI $request_uri;
    proxy_set_header Host "auth.example.com";
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Origin-Host $http_host;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    if ($http_cookie ~* "cheezyssotoken=([^;]+)(?:;|$)") {
        set $token "$1";
    }
    proxy_set_header X-Cheezy-Sso-Token $token;
}
```

What this does is direct all requests to this site to ```/auth```. This then fires an internal request off to ```https://auth.example.com/auth``` setting the value of the header ```X-Cheezy-Sso-Token``` to the value of the user's ```cheezyssotoken``` cookie.
 
The SSO site then returns a ```200 OK``` or ```401 Forbidden``` if it can verify the user has permission or not, and Nginx continues the request as normal.

You can then add in other proxy_pass directives as needed to your protected content.

```nginx
location /protected {
    proxy_pass http://192.168.0.1:8989;
}

location /otherprotected {
    proxy_pass http://192.168.0.1:5050;
}
```

Here's a full config using [HTTP2](https://en.wikipedia.org/wiki/HTTP/2) and [Let's Encrypt](https://letsencrypt.org/) SSL certificates:

```nginx
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name subdomain.example.com;
    
    ssl_certificate /etc/letsencrypt/live/subdomain.example.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/subdomain.example.com/privkey.pem;
    
    error_page 401 = @error401;
    location @error401 {
        return 302 https://auth.example.com;
    }
    
    auth_request /auth/;
    
    location /auth {
        internal;
        proxy_pass https://auth.example.com;
        proxy_pass_request_body off;
        proxy_set_header Content-Length: 0;
        proxy_set_header X-Original-URI $request_uri;
        proxy_set_header Host "auth.example.com";
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Origin-Host $http_host;
        
        if ($http_cookie ~* "cheezyssotoken=([^;]+)(?:;|$)") {
            set $token "$1";
        }
        proxy_set_header X-Cheezy-Sso-Token $token;
    }
    
    location /protected {
        proxy_pass http://192.168.0.1:8989;
    }
    
    location /otherprotected {
        proxy_pass http://192.168.0.1:5050;
    }
}
```

## Nginx setup for the SSO Site

The actual auth site can be set up in Nginx as any other Laravel site. You need to serve content out of the public directory.

Here's a full example using HTTP2 and Letsencrypt SSL certificates.

```nginx
server {
    listn 443 ssl http2;
    listen [::]:443 ssl http2;
    
    server_name auth.example.com;
    
    ssl_certificate /etc/letsencrypt/live/auth.example.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/auth.example.com/privkey.pem;
    
    root /var/www/auth.example.com/public;
    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php7.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```