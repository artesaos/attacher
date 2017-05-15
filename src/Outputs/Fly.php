<?php namespace Artesaos\Attacher\Outputs;

use Artesaos\Attacher\Contracts\OutputContract;
use Intervention\Image\Image;
use GrahamCampbell\Flysystem\FlysystemManager;

class Fly implements OutputContract
{
    /**
     * @var \GrahamCampbell\Flysystem\FlysystemManager
     */
    protected $flysystem;

    public function __construct(FlysystemManager $flysystemManager)
    {
        $this->flysystem = $flysystemManager;
    }

    /**
     * @param Image  $image
     * @param string $path
     *
     * @return bool
     */
    public function save(Image $image, $path)
    {
        return $this->flysystem->put($path, (string) $image->encode(null, config('attacher.image_quality')));
    }
}