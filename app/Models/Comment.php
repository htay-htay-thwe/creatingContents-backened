<?php

namespace App\Models;

use App\Models\post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['userId',
                            'post_id',
                            'parent_id',
                            'comment'
                          ];

                          public function user(){
                            return $this->belongsTo(User::class,'userId');
                          }

                          public function post(){
                            return $this->belongsTo(post::class,'post_id');
                          }

                          public function replies(){
                            return $this->hasMany(Comment::class,'parent_id');
                          }
}
