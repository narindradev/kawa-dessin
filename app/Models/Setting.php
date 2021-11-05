<?php

namespace App\Models;

use Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    static  function _save($key = "" ,$value = null)
    {
        if ($key) {
            Cache::forget("app_setting_$key");
            self::updateOrCreate(['key'=>$key ],['value'=> $value]);
        }
    }
    static  function _get($key = "" )
    {
        return self::where(['key'=>$key ])->first()->value ?? null;
    }
}
