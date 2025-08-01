<?php
namespace App\Models;

use App\Models\Image;
use App\Models\Save;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    #good
    use SoftDeletes;
    protected $fillable = [
        'userId',
        'genre',
        'title',
        'content',

    ];
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
