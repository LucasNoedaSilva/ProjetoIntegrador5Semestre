<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model{
   public $fillable = ["customer_id", "status","total_price","notes","order_date"];
        
   protected $casts = [
        'order_date' => 'datetime',
    ];
    
    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    
    public function products() {
    return $this->belongsToMany(Product::class, 'order_products')
                ->withPivot('quantity', 'price_at_purchase')
                ->withTimestamps();}
}
