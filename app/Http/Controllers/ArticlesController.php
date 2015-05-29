<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Article;
use App\Category;
use App\Section;
use Auth;
use Request;
use Input;
use Editor;

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
	    $input = Input::get(Editor::input());
	    $content = Editor::content($input);
	    $article->body=$content;
	    $article->save();
	    return redirect('articles');
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
		//
		//$article = new Article;
		$article=Article::find($id);
	    $article->subject=Request::get('subject');
	    $article->body=Request::get('body');
	    #$article->category_id=1;
	    $article->user_id=1;
	    $isshow=Request::get('isshow');
	    if($isshow==null){

	    	$valueOfisshow=1;
	    }else{

	    	$valueOfisshow=0;
	    }
	    $article->isshow=$valueOfisshow;

	    $catId=Request::get('category');
	   # $category=Category::where('name',$catName);
	    #$catId=$category->id;
	    $article->category_id=$catId;
	    $article->save();
	    return redirect('articles');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		Article::find($id)->delete();
   		#return redirect('articles');

	}
	public function autocomplete(){
		$term = Input::get('term');
		
		$results = array();
		
		$queries = DB::table('articles')
			->where('subject', 'LIKE', '%'.$term.'%')
			->take(5)->get();
		
		foreach ($queries as $query)
		{
		    $results[] = [ 'id' => $query->id, 'value' => $query->subject.' '];
		}
		return Response::json($results);
    }



}
