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
        // TODO: Implement url() method.
    }

    /**
     * Setup image file
     *
     * @param UploadedFile
     */
    public function setupFile(UploadedFile $file)
    {
        $this->_source = $file;
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
}