<?php namespace Artesaos\Attacher\Providers;

use Artesaos\Attacher\Attacher;
use Illuminate\Support\ServiceProvider;

class AttacherServiceProvider extends ServiceProvider
{
    /**
     *
     * @return void
     */
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

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('attacher', function () {
            return new Attacher();
        });
    }

    private function registerObserver()
    {
        $model = config('attacher.model');
        forward_static_call([$model, 'observe'], 'Artesaos\Attacher\Observers\ModelObserver');
    }

}