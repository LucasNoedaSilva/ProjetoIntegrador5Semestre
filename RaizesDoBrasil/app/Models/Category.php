<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
     public $fillable = ["category_name","category_describe"];
     
   public function products(){
      return $this->hasMany(Product::class);}
        
   public function ingredients(){
      return $this->hasMany(Ingredient::class);}}
        

