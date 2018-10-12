@extends('layouts.app')

@section('content')

<thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div class="level">
                        
                            <span class="flex">
                                
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted: 

                                {{ $thread->title }}
                            </span>

                            @can('update', $thread)
                                <form method="POST" action="{{ $thread->path() }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-link">Delete Thread</button>
                                </form>
                            @endcan
                        </div>

                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>

                <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

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
                        <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                    </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</thread-view>
@endsection
