@extends('admin.layout.app')

@section('administration-content')
    <div class="card">
        <div class="card-header text-center">
            <h3>Dashboard</h3>
        </div>
        <div class="card-body">
            Welcome <b>{{auth()->user()->name}}</b> to an adminstrator area 
        </div>
    </div>
@endsection