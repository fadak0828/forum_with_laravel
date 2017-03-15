<div class="form-group">
  <label for="title">{{ trans('forum.title') }}</label>
  <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}"/>
  {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group">
  <label for="content">{{ trans('forum.content') }}</label>
  <textarea id="content" name="content" class="form-control" rows="10">{{ old('content', $article->content) }}</textarea>
  {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group">
  <label for="my-dropzone">Files</label>
  <div id="my-dropzone" class="dropzone"></div>
</div>

@section ('script')
  <script>
    Dropzone.autoDiscover = false;

    var form = $("form.form__forum").first()

    var myDropzone = new Dropzone("div#my-dropzone",{
      url:"/files",
      params:{
        _token: "{{ csrf_token() }}",
        articleId: "{{ $article->id }}"
      }
    });

    var insertImage = function(objId, imgUrl) {
      var caretPos = document.getElementById(objId).selectionStart;
      var textAreaTxt = $("#" + objId).val();
      var txtToAdd = "![](" + imgUrl + ")";
      $("#" + objId).val(
        textAreaTxt.substring(0, caretPos) +
        txtToAdd +
        textAreaTxt.substring(caretPos)
      );
    };

    myDropzone.on("success", function(file, data){
      $("<input>", {
        type: "hidden",
        name: "attachments[]",
        class: "attachments",
        value: data.id
      }).appendTo(form);

      if (/^image/.test(data.type)) {
        insertImage('content', data.url);
      }
    });

    myDropzone.on("removedfile", function(file) {
      $.ajax({
        type: "POST",
        url: "/files/" + file._id,
        data: {
          _method: "DELETE",
          _token: $('meta[name="csrf-token"]').attr('content')
        }
      }).success(function(data) {
        console.log(data);
      })
    });
  </script>
@stop
