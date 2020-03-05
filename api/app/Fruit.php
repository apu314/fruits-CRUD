<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fruit extends Model {

    protected $table = 'fruits';

    protected $fillable = [
        'name'
    ];

    public function fruitDetails() {
        return $this->hasMany('App\FruitDetails', 'fruit_id', 'id');
    }
}
