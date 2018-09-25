@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <a href="#">{{ $thread->creator->name }}</a> posted: 

                    {{ $thread->title }}
                    
                </div>

                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($thread->replies as $reply)

                @include('threads.reply')

            @endforeach
        </div>
    </div>

    @if(auth()->check())


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ $thread->path() . '/replies' }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" rows="5" class="form-control" placeholder="Have somthing to say?">
                    </textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-default" type="submit">Post</button>
                </div>

            </form>
        </div>
    </div>

    @else

    <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a> to participate in this discussion.</p>

    @endif


</div>
@endsection
