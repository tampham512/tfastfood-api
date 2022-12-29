<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table ='bills';
    protected $fillale =[
        "id",
        'id_user',
        'full_name',
        'andress',
        'phone_number',
        'total_price',

        'payment_methods',
        'status'

    ];

    protected $with = ['billDetail'];

    public Function billDetail()
    {
        return $this->hasMany(BillDetail::class, 'id_bill', 'id');
    }

   
}