<?php

namespace App\Models;

use App\Models\Post;
use App\Models\delete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class images extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');

    }
}
