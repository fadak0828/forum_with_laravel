<div class="dropdown pull-right hidden-xs hidden-sm">
  <span class="dropdown-toggle btn btn-default btn-xs" type="button" data-toggle="dropdown">
    {!! icon('dropdown') !!}
  </span>
  <ul class="dropdown-menu" role="menu">
    <li role="presentation">
      <a role="menuitem" tabindex="-1" alt="edit" class="btn__edit">
        {!! icon('update') !!} {{trans('forum.edit_comment')}}
      </a>
    </li>
    <li role="presentation">
      <a role="menuitem" tabindex="-1" alt="delete" class="btn__delete">
        {!! icon('delete') !!} {{trans('forum.delete_comment')}}
      </a>
    </li>
  </ul>
</div>
