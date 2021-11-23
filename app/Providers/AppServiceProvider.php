<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Core\Adapters\Theme;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        $this->app_config();
        $this->theme();
        
        view()->composer('*', function ($view) {
            $_SESSION["mode"]=  Auth::check() ?  auth()->user()->theme_mode : "default";
        });
    }



    private function theme()
    {
        $theme = theme();
        // Share theme adapter class
        View::share('theme', $theme);
        // Set demo globally
        $theme->setDemo('demo1');
        $theme->initConfig();
        bootstrap()->run();
        if (isRTL()) {
            Theme::addHtmlAttribute('html', 'dir', 'rtl');
            Theme::addHtmlAttribute('html', 'direction', 'rtl');
            Theme::addHtmlAttribute('html', 'style', 'direction:rtl;');
        }
    }
   
    private function app_config()
    {
        $lang = "fr";
        App::setLocale($lang);
        Carbon::setLocale($lang);
    }
}
