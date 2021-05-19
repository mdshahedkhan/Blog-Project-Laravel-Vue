<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['create_by', 'category_id', 'title', 'slug', 'sub_title', 'status', 'image', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'create_by')->select('id', 'name');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->select('id', 'name');
    }


}
