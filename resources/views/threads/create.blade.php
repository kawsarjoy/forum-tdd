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
                            <label for="title" class="form-control">Title:</label>
                            <textarea name="title" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="body" class="form-control">Body:</label>
                            <textarea name="body" rows="8" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
