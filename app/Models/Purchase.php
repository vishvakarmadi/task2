<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['product_id', 'quantity', 'total', 'date'];
    protected $casts = ['date' => 'date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
