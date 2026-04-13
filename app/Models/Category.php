<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
