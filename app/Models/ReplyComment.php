<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table ='reply_comments';
    protected $fillable = [
        'id',
        'id_user',
        'id_comment',
        'content',
      
    ];

    protected $with = ['user'];

    public Function user()
    {
        return $this->belongsTo(User::class,'id_user','id');
    }
}