<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    //

    /*
    ! $request->hasFile('file') 부분에서 'file' 필드가 있는 지 확인한다.
    없으면, response()->json() 메소드로 파일이 없다는 메시지를 JSON 으로 응답한다.

    있다면, $request->file('file') 로 Symfony\Component\HttpFoundation\File\UploadedFile 인스턴스를 얻어 온다.
    이 인스턴스에서 move(), getClientOriginalName(), getClientMimeType(), getClientOriginalExtension() 등의
    메소드를 사용할 수 있다.
    파일 이름 중복을 피하기 위해 time() php 내장 함수를 파일명 앞에서 붙여 주었다.
    move() 메소드로 'public/attachments' 디렉토리에 파일을 저장하였다.
    Attachment 모델을 만들고, JSON 응답에 'id', 'name', 'type', 'url' 등의 필드 값을 포함하였다.
    */
    public function store(Request $request){
      if(! $request->hasFile('file')){
        return response()->json('File not passed !',422);
      }

      $file = $request->file('file');
      $name = time().'_'.str_replace(' ','_',$file->getClientOriginalName());
      $file->move(attachment_path(),$name);

      $articleId = $request->input('articleId');

      $attachment = $articleId
        ? \App\Article::findOrFail($articleId)->attachments()->create(['name' => $name])
        : \App\Attachment::create(['name' => $name]);


      return response()->json([
        'id'    =>  $attachment->id,
        'name'  =>  $name,
        'type'  =>  $file->getClientMimeType(),
        'url'   =>  sprintf("/attachments/%s",$name)
      ]);
    }

    public function destroy($id)
    {
      $attachment = \App\Attachment::findOrFail($id);

      $path = attachment_path($attachment->name);
      if (\File::exists($path)) {
          \File::delete($path);
      }

      $attachment->delete();

      if (\Request::ajax()) {
          return response()->json(['status' => 'ok']);
      }

      flash()->success(trans('forum.deleted'));

      return back();
    }
}
