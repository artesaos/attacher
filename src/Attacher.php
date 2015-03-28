<?php namespace Artesaos\Attacher;

use Artesaos\Attacher\Contracts\ModelContract as Model;

class Attacher
{
    /**
     * @var \Artesaos\Attacher\Contracts\ImageProcessor
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
     * @return \Artesaos\Attacher\Contracts\ImageProcessor
     */
    protected function getProcessor()
    {
        if (!$this->processor):
            $this->processor = app('attacher.processor');
        endif;

        return $this->processor;
    }
}
