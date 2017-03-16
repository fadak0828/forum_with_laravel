<?php $size = isset($size) ? $size : 48; ?>
<div class="media media__item" data-id="{{ $comment->id }}" style="{{ $isReply ? 'margin-bottom:0;' : '' }}">

  <a class="pull-left hidden-xs hidden-sm" href="{{ gravatar_profile_url('john@example.com') }}">
    <img class="media-object img-thumbnail" src="{{ gravatar_url('john@example.com', $size) }}" alt="Unknown User">
  </a>

  <div class="media-body @if (! $isReply) {{"border__item"}} @endif">
    @can('update',$comment)
      @include('comments.partials.control')
    @endcan

    <h4 class="media-heading">
      <a href="#">
        {{ $comment->author->name }}
      </a>
      <small>
        {{ $comment->created_at->diffForHumans() }}
      </small>
    </h4>

    <p>{!! markdown($comment->content) !!}</p>

    @if (Auth::user())
      <div class="text-right">
        <button type="button" class="btn btn-info btn-sm btn__reply">
          {!! icon('reply') !!} {{ trans('common.reply') }}
        </button>
      </div>
    @endif

    @can('update',$comment)
      @include('comments.partials.edit')
    @endcan

    @if(Auth::user())
      @include('comments.partials.create', [
        'parentId' => $comment->id,
        'isReply' => true
      ])
    @endif

    @forelse ($comment->replies as $reply)
      @include('comments.partials.comment', ['comment'  => $reply])
    @empty
    @endforelse
  </div>
</div>
