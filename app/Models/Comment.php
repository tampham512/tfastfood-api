<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table ='comments';
    protected $fillable = [
        'id',
        'id_user',
        'id_product',
        'content',
      
    ];

    protected $with = ['user',"reply_comments"];


    public Function user()
    {
        return $this->belongsTo(User::class,'id_user','id');
    }
    public Function reply_comments()
    {
        return $this->hasMany(ReplyComment::class,'id_comment','id');
    }
}