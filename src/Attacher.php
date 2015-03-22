<?php namespace Artesaos\Attacher;

use Artesaos\Attacher\Contracts\ModelContract as Model;
use Artesaos\Attacher\Processors\FileSystem;
use Artesaos\Attacher\Contracts\ImageProcessor;

class Attacher
{
    /**
     * @var ImageProcessor
     */
    protected $processor;

    /**
     * @var array
     */
    protected $styles;

    /**
     * @var string;
     */
    protected $path;

    public function __construct()
    {
        $config = app('config');

        $this->styles = $config->get('attacher.styles', []);
        $this->path   = $config->get('attacher.path');
    }

    public function process(Model $model)
    {
        $path   = $this->getPath();
        $styles = $this->getStyles();

        $this->getProcessor()->process($model, $styles, $path);
    }

    /**
     * @return array
     */
    protected function getStyles()
    {
        return $this->styles;
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return $this->path;
    }

    /**
     * @return ImageProcessor
     */
    protected function getProcessor()
    {
        if (!$this->processor):
            $this->processor = new FileSystem();
        endif;

        return $this->processor;
    }
}
