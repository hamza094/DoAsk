<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Channel;

class ChannelController extends Controller
{
    
      public function __construct(){
        $this->middleware('auth');

    }
    
    public function index(Channel $channel){
     return view('channels.index'); 
    }
    public function show(){
        return Channel::latest()->paginate(5);
       
        
    }
    
     public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|string',
        ]);
        
       $channel=Channel::create([
           'name'=>request('name'),
           ]);
    }
    
  public function destroy($channel){
      $channel=Channel::findOrFail($channel);
      $channel->delete();
  }
    
    public function update(Request $request,$channel){
        $channel=Channel::findOrFail($channel);
         $this->validate($request,[
            'name'=>'required|string',
        ]);
        
        $channel->update(request(['name']));
    }    
    
}
