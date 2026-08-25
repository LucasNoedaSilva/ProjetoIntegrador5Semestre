<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model{
    public $fillable = ["ingredient_name", "category_id","ingredient_quantity","ingredient_due_date","ingredient_price"];

    public function category(){
        return $this->belongsTo(Category::class);}
        
    public function products(){
    return $this->belongsToMany(Product::class, 'ingredient_products')->withPivot('amount');}}

           

