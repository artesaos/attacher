<?php

namespace Artesaos\Attacher\Traits;

use Artesaos\Attacher\AttacherModel;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait HasImages
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(config('attacher.model'), 'subject');
    }

    /**
     * @param UploadedFile $image
     * @param string|array $styleGuide
     * @param string $type
     *
     * @return AttacherModel
     */
    public function addImage(UploadedFile $image, $styleGuide = null, $type = null)
    {
        $instance = $this->createImageModel();
        $instance->setupFile($image, $styleGuide, $type);

        $this->images()->save($instance);

        return $instance;
    }

    /**
     * @return AttacherModel
     */
    protected function createImageModel()
    {
        return $this->images()->getRelated()->newInstance();
    }
}