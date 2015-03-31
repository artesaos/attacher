<?php namespace Artesaos\Attacher\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ModelContract
{
    /**
     * Setup image file
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setupFile(UploadedFile $file);

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
}