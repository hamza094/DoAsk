<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reply;
use App\Favourite;

class FavoritesController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified'); 
    }
    
    public function store(Reply $reply){
        
        $reply->favorite();
        
        return back();
      
    }
    
     public function destroy(Reply $reply){
        
        $reply->unfavorite();
        
        
      
    }
    
}
