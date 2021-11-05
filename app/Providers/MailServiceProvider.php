<?php

namespace App\Providers;
use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
        $config = array(
            'transport'  => $this->_get_setting("transport") ?? "smtp",
            'host'       => $this->_get_setting("mail_host")   ?? "smtp.gmail.com",
            'port'       => $this->_get_setting("mail_port") ?? 587,
            'from'       => $this->_get_setting("app_name"),
            'encryption' => $this->_get_setting("mail_encryption") ?? "tls",
            'username'   => $this->_get_setting("sender_mail") ,
            'password'   => $this->_get_setting("mail_password"),
        );
        Config::set('mail.mailers.smtp', $config);
    }

    private function _get_setting($key)
    {
        $res = DB::table('settings')->where("key",$key)->first();
        return $res ? $res->value : null ;
    } 
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
