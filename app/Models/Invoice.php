<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "invoices";
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function getStatusAttribute()
    {
       return $this->get_status();
    }
    public function invoiceItemsfirstSlice()
    {
        return $this->invoiceItems->where("slice" ,1)->first();
    }
    public function invoiceItemsSecondSlice()
    {
        return $this->invoiceItems->where("slice" ,2)->first();
    }
    public  function get_status(){
        $status = new stdClass();
        $total = ($this->total * $this->taxe /100) + $this->total;
        $sum_total_paied = $this->invoiceItems->where("status" ,"paid")->sum('amount');
        if($sum_total_paied  >=  $total){
            $status->name = 'paid' ;
            $status->class = 'success' ;
        }elseif ($sum_total_paied > 0 &&  $sum_total_paied  < $total ) {
            $status->name = 'part_paid' ;
            $status->class = 'warning' ;
        }else{
            $status->name = 'not_paid';
            $status->class = 'danger';
        }
        return $status;
    }
}
