<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // In Category.php model
protected $fillable = [
    'name', 'description', 'image_url'
];


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    

    
}
