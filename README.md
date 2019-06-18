# php-cas-validation-client
This tiny project is used to validate CAS authentication with Cassava server
## Installation
```
   composer install
```
Copy config.php.sample to config.php, then edit and set good values.
## Testing
Open a cli on your computer, then start php web server:
```
php -S 127.0.0.1:8080 client.php
```
Open your favorite web browser, then authentify yourself on the CAS server.
On Success, you should have:

```
Successfull Authentication!

Current script
    client.php
session_name():
    PHPSESSID
session_id():
    5ee4de9978ba05de428b6972dbde8b67ddfbb860afb7f06b3f5ec22e490c155c

the user's login is eheindrich9@xample.com.

phpCAS version is 1.3.7.
User Attributes

    user: eheindrich9@xample.com
    attributes:
        longTermAuthenticationRequestTokenUsed: false
        isFromNewLogin: true
        userAttributes:
            name: eheindrich9@xample.com
            wpid: 14
            email: eheindrich9@xample.com
            profiles: ["MyProfile"]

```
