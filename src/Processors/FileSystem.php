<?php namespace Artesaos\Attacher\Processors;

use Intervention\Image\Image;

class FileSystem extends AbstractProcessor
{
    protected function save(Image $image, $styleName, $fileName, $path)
    {
        $image->save(public_path('uploads/' . $styleName . '-' . $fileName));
    }
}