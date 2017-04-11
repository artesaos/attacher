# Attacher - Pictures attachment tool for Laravel
**Upload** for S3, Copy, Local, Anything, **Manipulate** and **Attach Images in your Models**

> Current Build Status

[![Code Climate](https://codeclimate.com/github/artesaos/attacher/badges/gpa.svg)](https://codeclimate.com/github/artesaos/attacher)
[![Codacy Badge](https://www.codacy.com/project/badge/fc8dd3f83be843fe8c9fdcf0d4725bc8)](https://www.codacy.com/app/luiz-vinicius73/attacher)
[![PullReview stats](https://www.pullreview.com/github/artesaos/attacher/badges/master.svg?)](https://www.pullreview.com/github/artesaos/attacher/reviews/master)

> Statistics

[![Latest Stable Version](https://poser.pugx.org/artesaos/attacher/v/stable.svg)](https://packagist.org/packages/artesaos/attacher)
[![Total Downloads](https://poser.pugx.org/artesaos/attacher/downloads.svg)](https://packagist.org/packages/artesaos/attacher)
[![Latest Unstable Version](https://poser.pugx.org/artesaos/attacher/v/unstable.svg)](https://packagist.org/packages/artesaos/attacher)
[![License](https://poser.pugx.org/artesaos/attacher/license.svg)](https://packagist.org/packages/artesaos/attacher)


[![Inssues](https://img.shields.io/github/issues/artesaos/attacher.svg)](https://github.com/artesaos/attacher/issues)
[![Inssues](https://img.shields.io/github/forks/artesaos/attacher.svg)](https://github.com/artesaos/attacher/network)
[![Stars](https://img.shields.io/github/stars/artesaos/attacher.svg)](https://github.com/artesaos/attacher/stargazers)

> Tips

<a href="http://zenhub.io" target="_blank"><img src="https://raw.githubusercontent.com/ZenHubIO/support/master/zenhub-badge.png" height="18px" alt="Powered by ZenHub"/></a>

## Installation
### 1 - Dependency
The first step is using composer to install the package and automatically update your `composer.json` file, you can do this by running:
```shell
composer require artesaos/attacher
```

or manually update your `composer.json` file

```json
{
    "require": {
        "artesaos/attacher": "~0.6"
    }
}
```

### 2 - Provider
You need to update your application configuration in order to register the package so it can be loaded by Laravel, just update your `config/app.php` file adding the following code at the end of your `'providers'` section:

```php

// file START ommited
    'providers' => [
        // other providers ommited
        \Artesaos\Attacher\Providers\AttacherServiceProvider::class,
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
        'Attacher'   => \Artesaos\Attacher\Facades\Attacher::class,
    ],
// file END ommited
```

#### 3.1 - Facade API

```php
Attacher::process(Model $model);
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

In the `config/app.php` file, you can configure the destination path and the styles guides to manipulate the images.
```php
return [
    'model'    => 'Artesaos\Attacher\AttacherModel', # You can customize the model for your needs.
    'base_url' => '', # The url basis for the representation of images.
    'path'     => '/uploads/images/:id/:style/:filename', # Change the path where the images are stored.

    'style_guides'   => [
        'default' => [
            # If you set the original style all other styles used his return to base
            'original'=> function($image)
            {
                return $image->insert('public/watermark.png');
            },

            # Generate thumb (?x500)
            'thumb' => function ($image) {
                $image->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                return $image;
            },
        ],
        'custom_style_guide' => [
            # Generate thumb (?x500)
            'custom_style' => function ($image) {
                $image->fit(460, 120);

                return $image;
            }
        ],
    ]
];

```

## Usage

The usage is very simple.
The image destination information are in flysystem configuration file `config/flysystem.php` there you define which provider to use for uploading.

### 1 - Basic

```php
$upload = Input::file('image');

$image = new \Artesaos\Attacher\AttacherModel();
$image->setupFile($upload); # attach image
$image->save(); # now attacher process file (generate styles and save in your provider configured in flysystem)

echo $image->url('original');
echo $image->url('thumb'); // your style
```

#### 1.1 - Using Styles Guide
Using a specific guide style to manipulate the images:
```php
$upload = Input::file('image');

$image = new \Artesaos\Attacher\AttacherModel();
$image->setupFile($upload, 'custom_style_guide'); # attach image using the "custom_style_guide"
$image->save();

echo $image->url('custom_style'); // The "custom_style" setted in "custom_style_guide"
```

It is possible to change the style by passing an array keyed by the **style guide** and the **style** that you wish to change. The array values should be Closure instances which receive the \Intervention\Image\Image:
```php
$upload = Input::file('image');

$image = new \Artesaos\Attacher\AttacherModel();
$image->setupFile($upload, [
    'custom_style_guide' => [
        'custom_style' => function ($image) {
            $image->fit(30, 30);

            return $image;
        }
    ]
]); # attach image using the "custom_style" changed
$image->save();

echo $image->url('custom_style'); // Now, the "custom_style" generates a resized image of 30 by 30 pixels
```

Or use dot notation to change style:
```php
$upload = Input::file('image');

$image = new \Artesaos\Attacher\AttacherModel();
$image->setupFile($upload, [
    'custom_style_guide.custom_style' => function ($image) {
        $image->fit(30, 30);

        return $image;
    }
]); # attach image using the "custom_style" changed
$image->save();

echo $image->url('custom_style'); // Now, the "custom_style" generates a resized image of 30 by 30 pixels
```

### 2 - Traits

Attacher provides you two traits to facilitate the creation of galleries/collections of images linked to other objects using the technique `morphMany` and `morphOne`

#### 2.1 - HasImages

Bond with many images

```php
#app/Project.php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Artesaos\Attacher\Traits\HasImage;

class Projects extends Model
{
    use HasImages;

    protected $table = 'projects';
}

////

$upload = Input::file('image');

$project = Projects::find(73);

$image = $project->addImage($upload); # Create a new image, save model and save image file with your styles

echo $image->url('thumbnail');

////

$project = Projects::find(73);

# Collection of images
$images = $project->images;

```
> The method addImage() has the same attributes of the method setupFile() of the AttachModel:
```php
$model->addImage(UploadedFile $image, $styleGuide = null, $type = null);
```

#### 2.2 - HasImage [WIP]

Link to an image

```php

#app/People.php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Artesaos\Attacher\Traits\HasImage;

class People extends Model
{
    use HasImage;

    protected $table = 'people';
}

////

$upload = Input::file('image');

$people = People::find(73);

$image = $people->addImage($upload); # Create a new image, save model and save image file with your styles

echo $image->url('thumbnail');

////

$people = People::find(73);

echo $people->image->url('original');

```
> The method addImage() has the same attributes of the method setupFile() of the AttachModel:
```php
$model->addImage(UploadedFile $image, $styleGuide = null, $type = null);
```
## 3 - Setting a Image Model Type
Sometimes you may need to specify a type of image model. For example, when a product there are images for listing and images for gallery.
To do so, just pass additional third argument to the method:
```php
$people = People::find(73);

$upload = Input::file('image');
$people->addImage($upload, 'default', 'listing'); # attach image using the "listing" custom guide style

$upload2 = Input::file('image2');
$people->addImage($upload2, 'default', 'gallery'); # attach image using the "gallery" custom guide style

$listingImages = $people->images->ofType('listing'); // Get images of the listing
$galleryImages = $people->images->ofType('gallery'); // Get images of the gallery
```

## Author
[Vinicius Reis](https://github.com/vinicius73)
