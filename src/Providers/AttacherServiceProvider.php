<?php namespace Artesaos\Attacher\Providers;

use Artesaos\Attacher\Attacher;
use Artesaos\Attacher\Interpolator;
use Illuminate\Support\ServiceProvider;

class AttacherServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $base      = __DIR__ . '/../../resources/';
        $migration = '2015_03_28_000000_create_attacher_images_table.php';

        $this->publishes([
            $base . 'config/attacher.php'    => config_path('attacher.php'),
            $base . 'database/' . $migration => base_path('database/migrations/' . $migration)
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

        $this->app->singleton('attacher.interpolator', function () {
            $config = config('attacher');

            return new Interpolator($config['path'], $config['base_url']);
        });

        $this->app->register('GrahamCampbell\Flysystem\FlysystemServiceProvider');

        $this->app->singleton('attacher.outputs.fly', 'Artesaos\Attacher\Outputs\Fly');
        $this->app->singleton('attacher.processor', 'Artesaos\Attacher\Processors\CommonProcessor');

        $this->app->bind('Artesaos\Attacher\Contracts\OutputContract', 'attacher.outputs.fly');
        $this->app->bind('Artesaos\Attacher\Contracts\ImageProcessor', 'attacher.processor');
        $this->app->bind('Artesaos\Attacher\Contracts\InterpolatorContract', 'attacher.interpolator');
    }

    private function registerObserver()
    {
        $model = config('attacher.model');

        forward_static_call([$model, 'observe'], 'Artesaos\Attacher\Observers\ModelObserver');
    }

}