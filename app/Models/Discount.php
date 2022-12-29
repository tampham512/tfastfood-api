<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table ='discounts';
    protected $fillale =[
        "idDiscount",
        'value',
        'unit',
        'time_start',
        'time_end',
        'quatity',
        'quatity_used',
 
 

    ];


}