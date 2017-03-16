KOLARED
===============================

Kolared is based on the [Yii 2](http://www.yiiframework.com/) Advanced Project Template. It is shining which it use the Purple theme via 
Material-Bootstrap-Theme. 

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)]() - join chat and get free support

## Features

### Friendly SEO

Configurable routes and URLs system allows search engines to build correct site structure in their index.



## Minimal system requirements:

- PHP 5.5 or higher
- ngnix-based server
- MySQL 5.5+

Needed PHP modules:
- gd
- json
- pdo, pdo-mysql
- memcached(for memcache cache only)
- curl
- intl(optional but recommended)

Perfectly runs on $10 VPS from [DigitalOcean](https://www.digitalocean.com/?refcode=16218608bff6)


DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
