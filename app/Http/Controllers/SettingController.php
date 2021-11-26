<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class SettingController extends Controller
{
    public function index()
    {
        return view("settings.index");
    }
    public function notification_form(Request $request)
    {
        return view("settings.notification");
    }
    public function save_sett_notification(Request $request)
    {
        $settings = ["sender_mail", "sender_name","mail_password"];
        if ($request->test_email) {
            $this->send_mail_test($request);
        }
        foreach ($settings as $key) {
            Setting::_save($key, $request->input($key));
        }
        die(json_encode(["success" => true, "message" => trans("lang.success_record")]));
    }
    public function general_form(Request $request)
    {
        return view("settings.general");
    }
    public function save_sett_general(Request $request)
    {
        $settings = ["app_name" ,"currency_symbole","currency" ,"separator_decimal" ,"separtor_thousands" ,"nexmo_sender" ,"file_extension"];
        foreach ($settings as $key) {
            if ($request->input($key)) {
                Setting::_save($key, $request->input($key));
            }
        }
        die(json_encode(["success" => true, "message" => trans("lang.success_record")]));
    }
    public function payment_method_form(Request $request)
    {
        return view("settings.payment-method");
    }
    public function save_sett_payment_method(Request $request)
    {
        $settings = ["STRIPE_SECRET" ,"STRIPE_KEY"];
        foreach ($settings as $key) {
            Setting::_save($key, $request->input($key));
        }
        die(json_encode(["success" => true, "message" => trans("lang.success_record")]));
    }
    private function send_mail_test(Request $request)
    {
        try {
            Mail::send("settings.email-test", [], function ($message) use ($request) {
                $message->to($request->test_to)->subject('Test envoi mail');
                $message->from(app_setting("sender_mail"),app_setting("app_name"));
            });
            if( count(Mail::failures()) ) {
                die(json_encode(["success" => false, "type" => "test" , "message" => "Erreur! verifier bien les email ou le mot de passe ou faire une configuration dans l'email donnée"]));
            } else {
                 die(json_encode(["success" => true, "type" => "test" , "message" => "Test email bien envoyé"]));
             }
        } catch (Exception $e) {
            die(json_encode(["success" => false, "type" => "test"  ,"message" => $e->getMessage()]));
        }
    }
}
