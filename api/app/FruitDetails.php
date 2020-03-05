<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FruitDetails extends Model {

    protected $table = 'fruit_details';

    protected $fillable = [
        'size',
        'color'
    ];

    public function fruit() {
        return $this->belongsTo('App\Fruit', 'fruit_id');
    }

}
