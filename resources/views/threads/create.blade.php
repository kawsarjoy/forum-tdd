@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a New Threads</div>

                <div class="panel-body">
                    <form method="POST" action="/threads">
                        {{ csrf_field() }}
                    
                        <div class="form-group">
                            <label for="channel_id" class="form-label">Choose a channel:</label>
                            <select name="channel_id" class="form-control" required>

                                <option value="">Choose one...</option>
                                @foreach($channels as $channel)

                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="body" class="form-label">Body:</label>
                            <textarea name="body" rows="8" class="form-control" required>{{ old('body') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                        <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                        @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
