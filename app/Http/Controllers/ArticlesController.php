<?php

namespace App\Http\Controllers;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Request\ArticlesRequest;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = Article::with('comments','author')->latest()->paginate(10);
        return view('articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $article = new Article;
        $article->title='';
        $article->content='';
        return view('articles.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $article = Article::create([
          'author_id'=>\Auth::user()->id,
          'title'=>$request->input('title'),
          'content'=>$request->input('content')
        ]);
        flash()->success(trans('forum.created'));

        if ($request->has('attachments')) {
          $attachments = \App\Attachment::whereIn('id', $request->input('attachments'))->get();
          $attachments->each(function($attachment) use($article) {
            $attachment->article()->associate($article);
            $attachment->save();
          });
        }

        return redirect(route('articles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $article = Article::with('comments', 'author')->findOrFail($id);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $article = Article::findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $article = Article::findOrFail($id);

        $this->authorize('update', $article);

        $article->update($request->except('_token', '_method'));
        flash()->success(trans('forum.updated'));

        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $article = Article::with('attachments')->findOrFail($id);

        foreach($article->attachments as $attachment) {
            \File::delete(attachment_path($attachment->name));
            $attachment->delete();
        }

        $article->delete();

        flash()->success(trans('forum.deleted'));

        return redirect(route('articles.index'));
    }
}
