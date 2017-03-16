<div class="media">

  <div class="media-body">
    <h4 class="media-heading">
      <a href="{{ route('articles.show', $article->id) }}">
        {{ $article->title }}

        @if ($commentCount = $article->comments->count())
          <span class="badge pull-right">
            {!! icon('comments') !!} {{ $commentCount }}
          </span>
        @endif

        @if ($article->solution_id)
          <span class="badge pull-right">
            {!! icon('check') !!} {{ trans('forum.solved') }}
          </span>
        @endif
      </a>
    </h4>

    <p class="text-muted">
      <a href="#" style="margin-right: 1rem;">
        {!! icon('user') !!} {{ $article->author->name }}
      </a>
      {!! icon('clock') !!} {{ $article->created_at->diffForHumans() }}
    </p>

  </div>
</div>
