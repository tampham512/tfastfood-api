<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class infoshop extends Model
{
    use HasFactory;
    protected $table ='infoshop';
    protected $fillale =[
        "logo",
        'mobile_phone',
        'andress',
        'email',
        'header_sale',
        'coppyright',
        'link_fb',
        'link_gg_plus',
        'link_pinterest',
        'link_instagram',

      


    ];

}