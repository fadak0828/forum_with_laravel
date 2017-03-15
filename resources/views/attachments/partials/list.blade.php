@if ($attachments->count())
  <ul class="tags__forum">
    @foreach ($attachments as $attachment)
      <li class="label label-default">
        {!! icon('download') !!}
        <a href="/attachments/{{ $attachment->name }}">{{ $attachment->name }}</a>
        @can ('update',$article)
          <form action="{{ route('files.destroy', $attachment->id) }}" method="post" style="display: inline;">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <button type="submit">x</button>
          </form>
        @endcan
      </li>
    @endforeach
  </ul>
@endif
