@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2 class="title-show">
                {{ $ticket->title }}
                @include('tickets/partials/estado', compact('ticket'))
            </h2>

            <p class="date-t">
                <span class="glyphicon glyphicon-time"></span>
                {{ $ticket->created_at->format('d/m/Y h:ia') }} - {{  $ticket->author->full_name }}
            </p>

            <h4 class="label label-info news">
                {{ count($ticket->voters) }} votos
            </h4>

            <p class="vote-users">
                @foreach($ticket->voters as $user)
                    <span class="label label-info">{{ $user->full_name }}</span>
                @endforeach
            </p>

            @if(! auth()->user()->hasVoted($ticket))
                {!! Form::open(['route' => ['votes.submit', $ticket->id], 'method' => 'POST']) !!}
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-thumbs-up"></span> {{ trans('tickets.form.details.button_votes') }}
                    </button>
                {!! Form::close() !!}
            @else
                {!! Form::open(['route' => ['votes.destroy', $ticket->id], 'method' => 'DELETE']) !!}
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-thumbs-down"></span> {{ trans('tickets.form.details.button_noVotes') }}
                </button>
                {!! Form::close() !!}
            @endif

            <h3>{{ trans('tickets.form.details.title_newComment') }}</h3>

            {!! Form::open(['route' => ['comments.submit', $ticket->id], 'method' => 'POST']) !!}
                <div class="form-group">
                    {!! Form::label('comment', trans('tickets.form.details.comments')) !!}
                    {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 4, 'cols' => '50']) !!}
                    <!-- <textarea rows="4" class="form-control" name="comment" cols="50" id="comment"></textarea> -->
                </div>
                <div class="form-group">
                    {!! Form::label('link', trans('tickets.form.details.links')) !!}
                    {!! Form::text('link', null, ['class' => 'form-control']) !!}
                    <!-- <input class="form-control" name="link" type="text" id="link"> -->
                </div>
                {!! Form::submit(trans('tickets.form.details.submit'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

            <h3>Comentarios ({{ count($ticket->comments) }})</h3>

            @foreach($ticket->comments as $comment)
            <div class="well well-sm">
                <p><strong>{{ $comment->user->full_name }}</strong></p>
                <p>{{ $comment->comment }}</p>
                <p class="date-t">
                    <span class="glyphicon glyphicon-time"></span>
                    {{ $comment->created_at->format('d/m/Y h:ia') }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection