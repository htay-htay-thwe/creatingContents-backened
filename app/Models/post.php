<?php

namespace App\Models;

use App\Models\images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class post extends Model
{
    use softDeletes;
    protected $fillable = [
        'userId',
        'genre',
        'title',
        'content',

    ];
    public function images()
    {
        return $this->hasMany(images::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'userId');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'post_id');
    }
}
