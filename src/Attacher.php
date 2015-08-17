<?php namespace Artesaos\Attacher;

use Artesaos\Attacher\Contracts\ModelContract as Model;

class Attacher
{
    /**
     * @var array
     */
    protected $style_guides;

    /**
     * @var string;
     */
    protected $path;

    public function __construct()
    {
        $config = app('config');

        $this->style_guides = $config->get('attacher.style_guides', []);
        $this->path         = $config->get('attacher.path');
    }

    /**
     * @param Model $model
     */
    public function process(Model $model)
    {
        $path   = $this->getPath();
        $styles = $this->getStyleGuides();

        $this->getProcessor()->process($model, $styles, $path);
    }

    /**
     * @param string   $name
     * @param callable $closure
     */
    public function addStyle($name, callable $closure)
    {
        $this->style_guides[$name] = $closure;
    }

    /**
     * @return array
     */
    public function getStyleGuides()
    {
        return $this->style_guides;
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
