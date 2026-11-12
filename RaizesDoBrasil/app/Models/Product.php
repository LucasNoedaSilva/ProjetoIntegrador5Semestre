<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model{ 
    public $fillable = ["product_name", "product_describe", "category_id","product_price"];
  
    public function category(){
    return $this->belongsTo(Category::class);}

  public function ingredients(){
    return $this->belongsToMany(Ingredient::class, 'ingredient_products')->withPivot('amount');}
    }
    

