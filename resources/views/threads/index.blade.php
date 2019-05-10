@extends('layouts.app')

@section('content')

@include('threads._list')
{{$threads->render()}}


@endsection