@extends('layouts.app')

@section('header')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Thread</div>

                <div class="card-body">
                <form action="/threads" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <select name="channel_id" id="channel_id" class="form-control" required>
                       @foreach($channels as $channel)
                        <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>{{$channel->name}}</option>
                        @endforeach
                    </select>
                </div>
              <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text" name="title" class="form-control" id="title" value="{{old('title')}}" required>
              </div>
               <div class="form-group">
                   <label for="body">Body:</label>
                   <wysiwyg name="body"></wysiwyg>
                  <!-- <textarea name="body" id="body" rows="8" class="form-control" required>{{old('body')}}</textarea>-->
               </div>
               <div class="g-recaptcha" data-sitekey="6LfBCJsUAAAAAAER-kmyZlsXrAdK6RKgU6VGmLJG"></div>
               <br>
               <div class="form-group">
               <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                    </form>
                         @if($errors->count()>0)
           <ul class="alert alert-danger">
             @foreach($errors->all() as $error)
            <li>{{$error}}</li>
             @endforeach
          </ul>
    
    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection