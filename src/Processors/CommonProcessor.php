<?php namespace Artesaos\Attacher\Processors;

use Intervention\Image\Image;

class CommonProcessor extends AbstractProcessor
{
    /**
     * @param Image  $image
     * @param string $styleName
     * @param string $fileName
     * @param string $path
     *
     * @return bool
     */
    protected function save(Image $image, $path)
    {
        return $this->output->save($image, $path);
    }
}