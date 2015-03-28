<?php namespace Artesaos\Attacher\Processors;

use Intervention\Image\Image;

class FlyProcessor extends AbstractProcessor
{
    /**
     * @param Image  $image
     * @param string $styleName
     * @param string $fileName
     * @param string $path
     *
     * @return bool
     */
    protected function save(Image $image, $styleName, $fileName, $path)
    {
        return $this->output->save($image, '/teste/' . $styleName . $fileName);
    }
}