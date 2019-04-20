<?php

namespace App;

class Reputation{
    
const Thread_Has_Published=10;
const Reply_Has_Made=5;
const Reply_Marked_As_Best=25;
const Reply_Has_Favorited=15;

public static function award($user,$points){
    $user->increment('reputation',$points);
}
    
public static function reduce($user,$points){
    $user->decrement('reputation',$points);
}    

}

?>
