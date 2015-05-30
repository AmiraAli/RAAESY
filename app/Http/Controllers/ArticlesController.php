<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Article;
use App\Log;
use App\Category;
use App\Section;
use Auth;
use Request;
use Input;
use Editor;
use Validator;

class ArticlesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$articles=Article::all();
		return view('articles.index',compact('articles'));
	}


	/**
	 * Notify when user is spam/delete (called by AJAX).
	 *
	 * @param  object  $model_obj , string action
	 * @return Response
	 */


	public function addnotification($action , $type , $model_obj ){

		$notification = new Log();
		$notification->type = $type ;
		$notification->action = $action;
		$notification->name = $model_obj->subject;
		$notification->type_id = $model_obj->id;
		$notification->user_id = Auth::user()->id;
		$notification->save();

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$categories=Category::all();
		$sections=Section::all();
		return view('articles.x',compact('categories','sections'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//

		$v = Validator::make(Request::all(), [
        'subject' => 'required|max:255|unique:articles',
        'body' => 'required',
        #'isshow' => 'required',
        #'category' => 'required',
        ]);
        $subject=Request::get('subject');

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors())
	        						 ->withInput();
	    }else{
		
	    $article = new Article;
	    $article->subject=Request::get('subject');
	    #$article->category_id=1;
	    $userId=Auth::user()->id;
	    $article->user_id=$userId;
	    $isshow=Request::get('isshow');
	    if($isshow==null){

	    	$valueOfisshow=1;
	    }else{

	    	$valueOfisshow=0;
	    }
	    $article->isshow=$valueOfisshow;

	    $catId=Request::get('category');
	    $article->category_id=$catId;
	    $article->body= Request::get('body');

	    $article->save();
	    return redirect('articles');
	  }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$article=Article::find($id);
		return view('articles.show',compact('article'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$sections=Section::all();
		$categories=Category::all();
		$article=Article::find($id);
		return view('articles.edit',compact('article','categories','sections'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	    $v = Validator::make(Request::all(), [
        'subject' => 'required|max:255',
        'body' => 'required',
        #'isshow' => 'required',
        #'category' => 'required',
        ]);
        $subject=Request::get('subject');

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors())
	        						 ->withInput();
	    }else{
		
			$article=Article::find($id);
		    $article->subject=Request::get('subject');
		    $article->body=Request::get('body');
		    $isshow=Request::get('isshow');
		    if($isshow==null){

		    	$valueOfisshow=1;
		    }else{

		    	$valueOfisshow=0;
		    }
		    $article->isshow=$valueOfisshow;

		    $catId=Request::get('category');
		    $article->category_id=$catId;
		    $article->save();
		    return redirect('articles');
    	}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
		$article = Article::find($id);
		
		//add notification wher article deleted
		$this->addnotification("delete"  , "article" , $article );
		$article->delete();
	}
	

    public function autocomplete()
	{

		$data = Request::get('data');
		$articles  = Article::select('id', 'subject')->where('subject', 'LIKE', "%$data%")->get();
		
		return json_encode($articles);


	}



}
