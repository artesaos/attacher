<?php namespace Artesaos\Attacher\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ModelContract
{
    /**
     * Setup image file
     *
     * @param UploadedFile $file
     * @param string       $styleGuide
     */
    public function setupFile(UploadedFile $file, $styleGuide = null);

    /**
     * @return UploadedFile
     */
    public function getSourceFile();

    /**
     * Get URL of image
     *
     * @param string $style
     *
     * @return string
     */
    public function url($style);

    /**
     * @param string $style
     *
     * @return string
     */
    public function getPath($style);

    /**
     * @return string
     */
    public function getFileName();

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * @return string|array
     */
    public function getStyleGuide();

    /**
     * @param string|array $name
     */
    public function setStyleGuide($name);
}