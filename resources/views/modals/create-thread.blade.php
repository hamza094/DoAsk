<modal name="create-thread" height="auto" :scrollable="true">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                <form action="/threads" method="post">
                {{csrf_field()}}
                   <div class="form-group">
                                <label for="channel_id">Choose a Channel:</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose One...</option>

                                    @foreach ($allchannels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
              <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text" name="title" class="form-control" id="title" value="{{old('title')}}" required>
              </div>
               <div class="form-group">
                   <label for="body">Body:</label>
                   <thread-wysiwg name="body"></thread-wysiwg>
                  <!-- <textarea name="body" id="body" rows="8" class="form-control" required>{{old('body')}}</textarea>-->
               </div>
               <recaptcha ref="recaptcha" sitekey="{{ config('forum.recaptcha.key') }}"></recaptcha>
               <br>
               <div class="form-group">
               <button class="btn btn-success" type="submit">Submit</button>
                <button class="btn btn-primary" @click="$modal.hide('create-thread')">Close</button>   
                    </div>
                    </form>
                         @if($errors->count()>0)
           <ul class="alert alert-danger">
             @foreach($errors->all() as $error)
            <li>{{$error}}</li>
             @endforeach
          </ul>
    
    @endif

</modal>