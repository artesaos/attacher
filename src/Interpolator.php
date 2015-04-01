<?php namespace Artesaos\Attacher;

use Artesaos\Attacher\Contracts\InterpolatorContract;
use Artesaos\Attacher\Contracts\ModelContract;

class Interpolator implements InterpolatorContract
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $base_url;

    protected $interpolations = [
        ':filename' => 'file_name',
        ':id'       => 'id',
    ];

    public function __construct($path, $base_url)
    {
        $this->path     = $path;
        $this->base_url = $base_url;
    }

    /**
     * @param ModelContract $model
     * @param string        $style
     *
     * @return string
     */
    public function parsePath(ModelContract $model, $style)
    {
        return $this->doParsePath($model, $style);
    }

    /**
     * @param ModelContract $model
     * @param string        $style
     *
     * @return string
     */
    public function parseUrl(ModelContract $model, $style)
    {
        $url = $this->base_url . $this->doParsePath($model, $style);
        $url = preg_replace('~(^|[^:])//+~', '\\1/', $url);

        return url($url);
    }

    /**
     * @param ModelContract $model
     * @param string        $style
     *
     * @return string
     */
    protected function doParsePath(ModelContract $model, $style)
    {
        $string = preg_replace("/:style\b/", $style, $this->path);

        foreach ($this->getInterpolations() as $key => $value):

            if (strpos($string, $key) !== false):
                $string = preg_replace("/$key\b/", $model->getAttribute($value), $string);
            endif;
        endforeach;

        return $string;
    }

    /**
     * @return array
     */
    protected function getInterpolations()
    {
        return $this->interpolations;
    }

    /**
     * @param string $url
     *
     * @return void
     */
    public function setBaseUrl($url)
    {
        $this->base_url = $url;
    }

    /**
     * @param string $path
     *
     * @return void
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }
}