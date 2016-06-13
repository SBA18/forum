@extends('layouts.app')

@section('title', 'Edit topic')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="general-title small">Edit topic</div>
            <div class="box">
                <form action="{{ route('forum.topic.edit', ['id' => $topic->id]) }}" method="post" autocomplete="off">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Title</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Hello, world!" value="{{ $topic->name }}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body" rows="20">{{ $topic->body }}</textarea>
                        @if ($errors->has('body'))
                            <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update topic</button>
                        @role (['moderator', 'admin', 'owner'])
                        <a class="btn btn-danger pull-right" href="{{ route('forum.topic.destroy', ['id' => $topic->id]) }}">Delete</a>
                        @endrole
                        {!! csrf_field() !!}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
