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
        $file = $model->getSourceFile();

        $image = $this->imageManager->make($file->getFileInfo());

        if (isset($style['original'])):
            $image = $this->applyStyle($image, $style['original']);
        else:
            $image = $this->applyStyle($image, function () {});
        endif;

        $this->save($image, $model->getPath('original'));

        foreach ($styles as $styleName => $style):
            $processed = $this->applyStyle($image, $style);

            $this->save($processed, $model->getPath($styleName));
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
        $clone = clone $image;

        $processed = $style($clone);

        return (is_null($processed)) ? $clone : $processed;
    }

    /**
     * @param Image  $image
     * @param string $styleName
     * @param string $fileName
     * @param string $path
     */
    abstract protected function save(Image $image, $fileName);
}