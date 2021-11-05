<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "invoice_items";
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
