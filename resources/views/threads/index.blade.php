@extends('layouts.app')

@section('content')
@include('threads.breadcrumbs')
@include('threads._list')
{{$threads->render()}}
@endsection