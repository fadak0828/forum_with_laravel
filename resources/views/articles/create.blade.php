@extends('layouts.app')

@section('content')
  <div class="page-header">
    ...
  </div>

  <div class="container__forum">
    <form action="{{ route('articles.store') }}" method="POST" role="form" class="form__forum">
      {!! csrf_field() !!}

      @include('articles.partial.form')

      <div class="form-group">
        <p class="text-center">
          <a href="{{ route('articles.create') }}" class="btn btn-default">
            {!! icon('reset') !!} {{trans('forum.reset')}}
          </a>
          <button type="submit" class="btn btn-primary my-submit">
            {!! icon('plane') !!} {{trans('forum.post')}}
          </button>
        </p>
      </div>
    </form>
  </div>
@stop
