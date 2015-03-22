<?php namespace Artesaos\Attacher\Contracts;

interface ImageProcessor
{
    /**
     * Process model
     *
     * @param ModelContract $model
     * @param array         $styles
     * @param               $path
     */
    public function process(ModelContract &$model, array $styles, $path);
}