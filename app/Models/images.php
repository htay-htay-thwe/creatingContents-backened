<?php
namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');

    }
}
