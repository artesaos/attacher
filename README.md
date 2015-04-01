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

```php
<?php
# config/app.php

// file START ommited
    'providers' => [
        // other providers ommited
        'Artesaos\Attacher\Providers\AttacherServiceProvider',
    ],
// file END ommited
```

### 3 - Facade
> Optional. You do not need to register the Facade of Attacher, but if you want to have access to some shortcuts feel free to use it.

In order to use the `Attacher` facade, you need to register it on the `config/app.php` file, you can do that the following way:

```php
<?php
# config/app.php

// file START ommited
    'aliases' => [
        // other Facades ommited
        'Attacher'   => 'Artesaos\Attacher\Facades\Attacher',
    ],
// file END ommited
```

#### 3.1 - Facade API

```php
Attacher::process(Model $model);
Attacher::addStyle($name, callable $closure);
Attacher::getStyles();
Attacher::getPath();
Attacher::setPath($path);
Attacher::setBaseURL($url);
Attacher::getProcessor();
Attacher::getInterpolator();
```

### 4 - Configuration

Run in your console `php artisan vendor:publish`, now you have 3 new files, `config/attacher.php`, `config/flysystem.php` and `database/migrations/2015_03_28_000000_create_attacher_images_table.php`

> Attacher need [graham-campbell/flysystem](https://github.com/GrahamCampbell/Laravel-Flysystem)
> Don't worry, Attacher registers the flysystem service automatically for you.


```php
<?php
# config/attacher.php
return [
    'model'    => 'Artesaos\Attacher\AttacherModel', # You can customize the model for your needs.
    'base_url' => '', # The url basis for the representation of images.
    'path'     => '/uploads/images/:id/:style/:filename', # Change the path where the images are stored.

    # Where the magic happens.
    # This is where you record what the "styles" that will apply to your image.
    # Each style takes as the parameter is one \Intervention\Image\Image
    # See more in http://image.intervention.io/
    'styles'   => [
        # Optional
        # If you set the original style all other styles used his return to base
        'original'=> function($image)
        {
            return $image->insert('public/watermark.png');
        },
        # Generate thumb (?x500)
        'thumb'=> function($image)
        {
            $image->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            return $image;
        }
    ]
];

```

## Usage

> WIP
