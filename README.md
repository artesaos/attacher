# Attacher - Pictures attachment tool for Laravel
Upload for S3, Copy, Local, Anything and attach images in your Models

> Current Build Status

> Statistics

> Tips

<a href="http://zenhub.io" target="_blank"><img src="https://raw.githubusercontent.com/ZenHubIO/support/master/zenhub-badge.png" height="18px" alt="Powered by ZenHub"/></a>

## Installation
### 1 - Dependency
The first step is using composer to install the package and automatically update your `composer.json` file, you can do this by running:
```shell
composer require artesaos/attacher
```

### 2 - Provider
You need to update your application configuration in order to register the package so it can be loaded by Laravel, just update your `config/app.php` file adding the following code at the end of your `'providers'` section:

> `config/app.php`
```php
// file START ommited
    'providers' => [
        // other providers ommited
        'Artesaos\Attacher\Providers\AttacherServiceProvider',
    ],
// file END ommited
```

### 3 - Facade [WIP]
In order to use the `Attacher` facade, you need to register it on the `config/app.php` file, you can do that the following way:

```php
// file START ommited
    'aliases' => [
        // other Facades ommited
        'Attacher'   => 'Artesaos\Attacher\Facades\Attacher',
    ],
// file END ommited
```
## 4 - Usage

> WIP
