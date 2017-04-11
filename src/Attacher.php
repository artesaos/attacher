<?php

namespace Artesaos\Attacher;

use Artesaos\Attacher\Contracts\ModelContract as Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use SplFileInfo;

class Attacher
{
    /**
     * @var array
     */
    protected $styleGuides;

    /**
     * @var string;
     */
    protected $path;

    public function __construct()
    {
        $config = app('config');

        $this->styleGuides = $config->get('attacher.styleGuides', []);
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
     * @param string $styleGuide
     *
     * @return array
     */
    public function getStyleGuide($styleGuide)
    {
        return array_get($this->styleGuides, $styleGuide, []);
    }

    /**
     * @return array
     */
    public function getStyleGuides()
    {
        return $this->styleGuides;
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

    /**
     * @param string $file
     *
     * @return UploadedFile
     */
    public function makeUploadObject($file)
    {
        $info = new SplFileInfo($file);

        return new UploadedFile($file, $info->getFilename(), mime_content_type($file), $info->getSize());
    }
}
