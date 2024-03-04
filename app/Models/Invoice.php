<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable= [
        'invoice_number',
        'invoice_Date',
        'due_date',
        'product',
        'section_id',
        'discount',
        'amount_collection',
        'amount_commission',
        'rate_vat',
        'value_vat',
        'total',
        'status',
        'value_status',
        'note',
        'user'
    ];
     
    public function section(){
        return $this->belongsTo(new Section);
    }
}
