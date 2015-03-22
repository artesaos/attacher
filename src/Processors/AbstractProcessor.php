<?php namespace Artesaos\Attacher\Processors;

use Artesaos\Attacher\Contracts\ImageProcessor;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Artesaos\Attacher\Contracts\ModelContract;

abstract class AbstractProcessor implements ImageProcessor
{
    /**
     * @var ImageManager
     */
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager();
    }

    /**
     * @param ModelContract $model
     *
     * @return string
     */
    public function process(ModelContract &$model, array $styles, $path)
    {
        $file = $model->getSourceFile();

        $image = $this->imageManager->make($file->getFileInfo());

        foreach ($styles as $styleName => $style):
            $processed = $this->applyStyle($image, $style);

            $this->save($processed, $styleName, $file->getClientOriginalName(), $path);
        endforeach;
    }

    /**
     * @param Image    $image
     * @param callable $style
     *
     * @return Image
     */
    protected function applyStyle(Image $image, Callable $style)
    {
        $im = clone $image;

        $processed = $style($image);

        return (is_null($processed)) ? $im : $processed;
    }

    /**
     * @param Image $image
     * @param       $styleName
     * @param       $fileName
     * @param       $path
     */
    abstract protected function save(Image $image, $styleName, $fileName, $path);
}