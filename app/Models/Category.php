<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'thumbnail'
    ];

    protected $casts = [
        'category_id'  =>  'integer',
        'status'    =>  'boolean'
    ];

    public function products()  {
        return $this->hasMany(Product::class);
    }
}
