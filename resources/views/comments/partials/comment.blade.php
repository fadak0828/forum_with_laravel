<div class="media media__item" data-id="{{ $comment->id }}">

  <div class="media-body">
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
      <p class="text-right">
        <button type="button" class="btn btn-info btn-sm btn__reply">
          {!! icon('reply') !!} {{ trans('common.reply') }}
        </button>
      </p>
    @endif

    @can('update',$comment)
      @include('comments.partials.edit')
    @endcan

    @if(Auth::user())
      @include('comments.partials.create', ['parentId' => $comment->id])
    @endif

    @forelse ($comment->replies as $reply)
      @include('comments.partials.comment', ['comment'  => $reply])
    @empty
    @endforelse
  </div>
</div>
