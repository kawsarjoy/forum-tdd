@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <a href="#">{{ $thread->creator->name }}</a> posted: 

                    {{ $thread->title }}
                    
                </div>

                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
            
            @foreach($replies as $reply)

                @include('threads.reply')

            @endforeach

            {{ $replies->links() }}

            @if(auth()->check())

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

            @else

            <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a> to participate in this discussion.</p>

            @endif
            
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">

                <div class="panel-body">
                   <p>
                    This thread was published at {{ $thread->created_at->diffForHumans() }} by
                    <a href="#">{{ $thread->creator->name }}</a>, and currently has 
                    {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                   </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
