<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experince extends Model
{
   protected $guarded = [];
    
    
    public function users(){
        return $this->belongsTo(User::class);
    }
    
    public function awardExperince($points){
        $this->increment('points',$points);
        return $this;
    }
}

