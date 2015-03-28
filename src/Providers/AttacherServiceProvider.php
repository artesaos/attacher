<?php namespace Artesaos\Attacher\Providers;

use Artesaos\Attacher\Attacher;
use Illuminate\Support\ServiceProvider;

class AttacherServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $base      = __DIR__ . '/../../resources/';
        $migration = '2015_03_15_000000_create_attacher_images_table';

        $this->publishes([
            $base . 'config/attacher.php'               => config_path('attacher.php'),
            $base . 'migrations/' . $migration . '.php' => base_path('database/migrations/' . $migration . '.php')
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../../resources/config/attacher.php', 'attacher'
        );

        $this->registerObserver();
    }

    public function register()
    {
        $this->app->singleton('attacher', function () {
            return new Attacher();
        });

        $this->app->register('GrahamCampbell\Flysystem\FlysystemServiceProvider');

        $this->app->singleton('attacher.fly', 'Artesaos\Attacher\Outputs\Fly');
        $this->app->singleton('attacher.processor', 'Artesaos\Attacher\Processors\FlyProcessor');

        $this->app->bind('Artesaos\Attacher\Contracts\OutputContract', 'attacher.fly');
        $this->app->bind('Artesaos\Attacher\Contracts\ImageProcessor', 'attacher.processor');
    }

    private function registerObserver()
    {
        $model = config('attacher.model');

        forward_static_call([$model, 'observe'], 'Artesaos\Attacher\Observers\ModelObserver');
    }

}