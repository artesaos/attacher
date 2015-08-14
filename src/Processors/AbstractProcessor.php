<?php namespace Artesaos\Attacher\Processors;

use Artesaos\Attacher\AttacherModel;
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
     * Performs image processing
     *
     * @param ModelContract $model
     * @param array         $styleGuides
     * @param string        $path
     */
    public function process(ModelContract &$model, array $styleGuides, $path)
    {
        // load styles
        $styles          = $this->getStyles($model, $styleGuides);
        $originalClosure = array_get($styles, 'original', null);

        // get Image object
        $image = $this->imageManager->make($model->getSourceFile()->getFileInfo());

        // apply original style
        $original = $this->processStyle($model, $image, 'original', $originalClosure);

        array_forget($styles, 'original');

        // apply styles
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
     * @param AttacherModel $model
     * @param array         $styleGuides
     *
     * @return array
     */
    protected function getStyles(AttacherModel $model, array $styleGuides)
    {
        return array_get($styleGuides, $model->getStyleGuideName(), []);
    }

    /**
     * @param Image  $image
     * @param string $fileName
     *
     * @return bool
     */
    abstract protected function save(Image $image, $fileName);

}