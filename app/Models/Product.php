<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'branch_id', 'category_id', 'code', 'name', 'stock', 'min_stock',
        'purchase_price', 'selling_price', 'unit',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockMutations()
    {
        return $this->hasMany(StockMutation::class);
    }
}
