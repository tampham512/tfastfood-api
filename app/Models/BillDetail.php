<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;
    protected $table ='bills_detail';
    protected $fillale =[
        'id_bill',
        'id_product',
        'quantity',
        'total_price',

    ];

    protected $with = ['product'];

    public Function product()
    {
        return $this->belongsTo(Product::class,'id_product','id');
    }
   

}