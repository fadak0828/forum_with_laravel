@extends('layouts.app')

@section('content')
  <div class="row container__forum">
    <div class="col-md-9">
      <article>
        @include('articles.partial.article', ['article' => $article])
        @include('attachments.partials.list', ['attachments' => $article->attachments])
        <p>
          {!! markdown($article->content) !!}
        </p>
        @can('update',$article)
        <div class="text-center">
          <form action="{{ route('articles.destroy', $article->id) }}" method="post">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <button type="submit" class="btn btn-danger">
              {!! icon('delete') !!} {{trans('forum.delete')}}
            </button>
            <a href="{{route('articles.edit', $article->id)}}" class="btn btn-info">
              {!! icon('pencil') !!} {{trans('forum.edit')}}
            </a>
          </form>
        </div>
        @endcan
      </article>
      ...
      <article>
        Comment here
      </article>
    </div>
  </div>
@stop
