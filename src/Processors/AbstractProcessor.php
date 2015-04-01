<?php namespace Artesaos\Attacher\Processors;

use Artesaos\Attacher\Contracts\ImageProcessor;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Artesaos\Attacher\Contracts\ModelContract;
use Artesaos\Attacher\Contracts\OutputContract as Output;

abstract class AbstractProcessor implements ImageProcessor
{
    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * @var Output
     */
    protected $output;

    public function __construct(Output $output, ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
        $this->output       = $output;
    }

    /**
     * @param ModelContract $model
     *
     * @return string
     */
    public function process(ModelContract &$model, array $styles, $path)
    {
        $image = $this->imageManager->make($model->getSourceFile()->getFileInfo());

        $originalClosure = array_get($styles, 'original', null);

        $original = $this->processStyle($model, $image, 'original', $originalClosure);

        array_forget($styles, 'original');

        foreach ($styles as $styleName => $closure):
            $this->processStyle($model, $original, $styleName, $closure);
        endforeach;
    }

    /**
     * @param ModelContract $model
     * @param Image         $image
     * @param string        $styleName
     * @param \Closure      $closure
     *
     * @return Image
     */
    protected function processStyle(ModelContract $model, $image, $styleName, $closure)
    {
        if (is_null($closure)):
            $this->save($image, $model->getPath($styleName));

            return $image;
        endif;

        $processed = $this->applyStyle($image, $closure);

        $this->save($processed, $model->getPath($styleName));

        return $processed;
    }

    /**
     * @param Image    $image
     * @param callable $style
     *
     * @return Image
     */
    protected function applyStyle(Image $image, Callable $style)
    {
        $clone = clone $image;

        $processed = $style($clone);

        return (is_null($processed)) ? $clone : $processed;
    }

    /**
     * @param Image  $image
     * @param string $fileName
     *
     * @return bool
     */
    abstract protected function save(Image $image, $fileName);

}