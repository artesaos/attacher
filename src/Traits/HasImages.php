<?php namespace Artesaos\Attacher\Traits;

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
     * @param string       $style_guide
     *
     * @return AttacherModel
     */
    public function addImage(UploadedFile $image, $style_guide = null)
    {
        $instance = $this->createImageModel();
        $instance->setupFile($image, $style_guide);

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