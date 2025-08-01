<?php
namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Save extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'userId',
        'save',

    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');

    }

}
