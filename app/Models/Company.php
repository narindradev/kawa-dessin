<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = "company";
    protected $guarded = [];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
