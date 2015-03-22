<?php namespace Artesaos\Attacher\Observers;

use Artesaos\Attacher\Contracts\ModelContract;

class ModelObserver
{
    public function saving(ModelContract $model)
    {
        app('attacher')->process($model);
    }
}