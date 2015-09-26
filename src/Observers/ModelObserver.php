<?php namespace Artesaos\Attacher\Observers;

use Artesaos\Attacher\Contracts\ModelContract;

class ModelObserver
{
    public function created(ModelContract $model)
    {
        app('attacher')->process($model);
    }
}
