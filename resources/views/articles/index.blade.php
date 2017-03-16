@extends('layouts.app')

@section('content')

  <div class="row container__forum">

    <div class="col-md-8 col-md-offset-2">
      <hr class="divider"/>
      <article>
        @forelse($articles as $article)
          @include('articles.partial.article', ['article' => $article])
        @empty
          <p class="text-center text-danger">{{ trans('errors.not_found_description') }}</p>
        @endforelse

        <div class="text-center">
          {!! $articles->appends(Request::except('page'))->render() !!}
        </div>
      </article>
      <hr class="divider"/>
      <a class="btn btn-primary pull-right" href="{{ route('articles.create') }}">
        {!! icon('forum') !!} {{ trans('forum.create') }}
      </a>
    </div>

  </div>


@stop
