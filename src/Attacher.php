<?php namespace Artesaos\Attacher;

use Artesaos\Attacher\Contracts\ModelContract as Model;

class Attacher
{
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

    /**
     * @param Model $model
     */
    public function process(Model $model)
    {
        $path   = $this->getPath();
        $styles = $this->getStyles();

        $this->getProcessor()->process($model, $styles, $path);
    }

    /**
     * @param string   $name
     * @param callable $closure
     */
    public function addStyle($name, callable $closure)
    {
        $this->styles[$name] = $closure;
    }

    /**
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getInterpolator()->getPath();
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->getInterpolator()->setPath($path);
    }

    /**
     * @param string $url
     */
    public function setBaseURL($url)
    {
        $this->getInterpolator()->setBaseUrl($url);
    }

    /**
     * @return \Artesaos\Attacher\Contracts\ImageProcessor
     */
    public function getProcessor()
    {
        return app('attacher.processor');
    }

    /**
     * @return \Artesaos\Attacher\Contracts\InterpolatorContract;
     */
    public function getInterpolator()
    {
        return app('attacher.interpolator');
    }
}
