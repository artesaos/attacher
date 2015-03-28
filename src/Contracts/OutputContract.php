<?php namespace Artesaos\Attacher\Contracts;

use Intervention\Image\Image;

interface OutputContract
{
    /**
     * @param Image  $image
     * @param string $path
     *
     * @return bool
     */
    public function save(Image $image, $path);
}