@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
    <div class="col-md-3">
 <h4>Manage</h4>
   <div class="list-group">
  <a href="#" class="list-group-item list-group-item-action active">
    DashBoard
  </a>
  <a href="/channels" class="list-group-item list-group-item-action">Channels</a>
  
</div>
    </div>
    <div class="col-md-9">
        <div class="card">
           <div class="card-header text-center">
               <h3>Dashboard</h3>
           </div>
            <div class="card-body">
                Welcome <b>{{auth()->user()->name}}</b> as an adminstartor
            </div>
        </div>
    </div>
    </div>
</div>
@endsection