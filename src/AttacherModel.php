<?php namespace Artesaos\Attacher;

use Illuminate\Database\Eloquent\Model;
use Artesaos\Attacher\Contracts\ModelContract;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AttacherModel extends Model implements ModelContract
{
    protected $table = 'attacher_images';

    /**
     * @var UploadedFile
     */
    protected $_source;

    /**
     * @var
     */
    protected $_file;

    /**
     * @param string $style
     *
     * @return string
     */
    public function url($style = 'original')
    {
        return app('attacher.interpolator')->parseUrl($this, $style);
    }

    /**
     * @param string $style
     *
     * @return string
     */
    public function getPath($style)
    {
        return app('attacher.interpolator')->parsePath($this, $style);
    }

    /**
     * Setup image file
     *
     * @param UploadedFile
     */
    public function setupFile(UploadedFile $file)
    {
        $this->_source = $file;

        $this->setFileExtension($file->getExtension());
        $this->setFileNameAttribute($file->getClientOriginalName());
        $this->setMimeTypeAttribute($file->getClientMimeType());
        $this->setFileSizeAttribute($file->getSize());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * @return UploadedFile
     */
    public function getSourceFile()
    {
        return $this->_source;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->getFileNameAttribute();
    }

    /**
     * @return string
     */
    public function getFileNameAttribute()
    {
        return $this->attributes['file_name'];
    }

    /**
     * @param string $name
     */
    public function setFileNameAttribute($name)
    {
        $file_name = str_slug(pathinfo($name, PATHINFO_FILENAME)) . '.' . pathinfo($name, PATHINFO_EXTENSION);

        $this->attributes['file_name'] = $file_name;
    }

    /**
     * @param string $extension
     */
    public function setFileExtension($extension)
    {
        $this->attributes['file_extension'] = $extension;
    }

    /**
     * @param int $size
     */
    public function setFileSizeAttribute($size)
    {
        $this->attributes['file_size'] = $size;
    }

    /**
     * @param string $type
     */
    public function setMimeTypeAttribute($type)
    {
        $this->attributes['mime_type'] = $type;
    }
}