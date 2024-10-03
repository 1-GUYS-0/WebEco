<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'parent_category'];

    // Định nghĩa quan hệ với danh mục cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category');
    }

    // Định nghĩa quan hệ với các danh mục con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category');
    }
    // Định nghĩa quan hệ với bảng products
    public function products()
    {
        return $this->hasMany(Product::class, 'categories_id');
    }
}
