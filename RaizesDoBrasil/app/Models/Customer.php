<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'cep', 'street', 'number', 'complement', 'neighborhood', 'city', 'state'];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
