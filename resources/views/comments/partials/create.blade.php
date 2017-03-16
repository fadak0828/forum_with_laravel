<div class="media media__create">

  <div class="media-body">
    <form action="{{ route('comments.store') }}" method="POST" role="form" class="form-horizontal form-create-comment">
      {!! csrf_field() !!}
      <input type="hidden" name="commentable_type" value="{{ $commentableType }}">
      <input type="hidden" name="commentable_id" value="{{ $commentableId }}">
      @if(isset($parentId))
        <input type="hidden" name="parent_id" value="{{ $parentId }}">
      @endif

      <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}" style="width:100%; margin: auto;">
        <textarea name="content" class="form-control forum__content">{{ old('content') }}</textarea>
        {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
      </div>

      <p class="text-right" style="margin:0;">
        <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
          {!! icon('plane') !!} {{ trans('forum.post') }}
        </button>
      </p>
    </form>
  </div>
</div>
