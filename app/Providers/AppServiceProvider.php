<?php

namespace App\Providers;

use App\Core\Adapters\Theme;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
       /* if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->lang();
        $this->app_config();
        $this->theme();
    }
    private function theme()
    {
        $theme = theme();
        // Share theme adapter class
        View::share('theme', $theme);
        // Set demo globally
        // $theme->setDemo(request()->input('demo', 'demo1'));
         $theme->setDemo('demo1');
        $theme->initConfig();
        bootstrap()->run();
        if (isRTL()) {
            // RTL html attributes
            Theme::addHtmlAttribute('html', 'dir', 'rtl');
            Theme::addHtmlAttribute('html', 'direction', 'rtl');
            Theme::addHtmlAttribute('html', 'style', 'direction:rtl;');
        }
    }
    private function lang($lang = "fr")
    {
        $langs = ['en', 'es', 'fr'];
        App::setLocale($lang);
    }
    private function app_config()
    {
        Config::set("app_name" ,"Kawa Dessin");
    }
    
}
