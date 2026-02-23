<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['product_id', 'quantity', 'discount', 'vat', 'total', 'paid', 'due', 'date'];
    protected $casts = ['date' => 'date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
