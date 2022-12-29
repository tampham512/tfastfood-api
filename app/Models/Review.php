<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table ='review';
    protected $fillable = [
    
        'id_user',
        'id_product',
        'content',
        'rate_star',

    ];

    protected $with = ['user'];


    public Function user()
    {
        return $this->belongsTo(User::class,'id_user','id');
    }


}