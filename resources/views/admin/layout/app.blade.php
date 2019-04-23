@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
    <div class="col-md-3">
 <h4>Manage</h4>
   <div class="list-group">
  <a href="/admin/dashboard" class="list-group-item list-group-item-action {{ Route::is('admin.dashboard') ? 'active' : '' }}">
    DashBoard
  </a>
  <a href="/admin/channels" class="list-group-item list-group-item-action {{ Route::is('admin.channels') ? 'active' : '' }}">Channels</a>
  
</div>
    </div>
    <div class="col-md-9">
         @yield('administration-content')
    </div>
    </div>
</div>
@endsection