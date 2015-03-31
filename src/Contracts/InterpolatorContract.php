<?php namespace Artesaos\Attacher\Contracts;

interface InterpolatorContract
{

    public function __construct($path, $base_url);

    /**
     * @param ModelContract $model
     * @param string        $style
     *
     * @return string
     */
    public function parsePath(ModelContract $model, $style);

    /**
     * @param ModelContract $model
     * @param string        $style
     *
     * @return string
     */
    public function parseUrl(ModelContract $model, $style);

    /**
     * @param string $url
     *
     * @return void
     */
    public function setBaseUrl($url);

    /**
     * @param string $path
     *
     * @return void
     */
    public function setPath($path);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getBaseUrl();
}