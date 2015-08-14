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
     * @var string
     */
    protected $_file;

    /**
     * @var string
     */
    protected $_style_guide = 'default';

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
     * @param UploadedFile $file
     * @param string       $style_guide
     */
    public function setupFile(UploadedFile $file, $style_guide = null)
    {
        $this->_source = $file;

        $this->setFileExtension($file->getClientOriginalExtension());
        $this->setFileNameAttribute($file->getClientOriginalName());
        $this->setMimeTypeAttribute($file->getClientMimeType());
        $this->setFileSizeAttribute($file->getSize());

        if (!empty($style_guide)) {
            $this->setStyleGuideName($style_guide);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getStyleGuideName()
    {
        return (empty($this->_style_guide)) ? 'default' : $this->_style_guide;
    }

    /**
     * @param string $name
     */
    public function setStyleGuideName($name)
    {
        $this->_style_guide = $name;
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