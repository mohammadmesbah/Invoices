<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_attachment extends Model
{
    use HasFactory;
    protected $fillable= [
        'invoice_number',
        'file_name',
        'invoice_id',
        'created_by'
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
