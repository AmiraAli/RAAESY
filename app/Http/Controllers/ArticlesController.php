<?php namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Article;

//use App\Tag;
use App\ArticleTag;

use App\Log;

use App\Category;
use App\Section;
use Auth;
use Request;
use Input;
use Editor;
use Validator;
use App\Tag;

//for csv
use Response;

class ArticlesController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
	}



	/**
	 * Authorize admin
	 * @param  integer $user_id
	 * @return Response
	 */
	private function adminAuth()
	{		
		if (Auth::User()->type !="admin"){
			return false;
		}
		return true;
	}

	

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		//authenticate admin
		if (!$this->adminAuth()){
			return view('errors.authorization');
		}
		$categories=Category::all();
		$sections=Section::all();
		$articles=Article::all();
		$tags=Tag::all();
		return view('articles.index',compact('articles','categories','sections','tags'));
	}


	/**
	 * Notify when user is spam/delete (called by AJAX).
	 *
	 * @param  object  $model_obj , string action
	 * @return Response
	 */


	private function addnotification($action , $type , $model_obj ){

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
		//authenticate admin
		if (!$this->adminAuth()){
			return view('errors.authorization');
		}
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
        ]);
        $subject=Request::get('subject');

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors())
	        						 ->withInput();
	    }else{
		
	    $article = new Article;
	    $article->subject=Request::get('subject');
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

	    $tags=Request::get('tagValues');
			if( $tags != ""){
				$tags_array=explode(",",$tags);
				for($i=0;$i<count($tags_array);$i++){
					$tag=Tag::where('name',$tags_array[$i])->first();
					$articleTag=new ArticleTag;
					$articleTag->tag_id=$tag->id;
					$articleTag->article_id=$article->id;
					$articleTag->save();
				}
			}

	    
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
	    $articletags=ArticleTag::all();
		$articles = Article::all();
		$tags=Tag::all();
		$tagOfArts=ArticleTag::select('tag_id')->where('article_id','like',"%".$id.'%')->get();
		return view('articles.show',compact('article','articletags','tags','tagOfArts','articles'));
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
		//authenticate admin
		if (!$this->adminAuth()){
			return view('errors.authorization');
		}
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

		    $tags=Request::get('tagValues');
			if( $tags != ""){
				$tags_array=explode(",",$tags);
				for($i=0;$i<count($tags_array);$i++){
					$tag=Tag::where('name',$tags_array[$i])->first();
					$articleTag=new ArticleTag;
					$articleTag->tag_id=$tag->id;
					$articleTag->article_id=$article->id;
					$articleTag->save();
				}
			}
		    
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

	public function getTags()
	{
		// Getting post data
		if(Request::ajax()) {
			// $data = Input::all();
			$data = Request::input('q');
			$tags=Tag::select('name')->where('name','like',"%".$data.'%')->get();
			// file_put_contents("/home/amira/test.html", $tags);
			echo json_encode($tags);
		}
	}

	public function search()
	{

		$category_id = Request::get('dataCat');
		$tag_id = Request::get('dataTag');
		//var_dump($category_id);
		//var_dump($tag_id); exit();
        if($category_id !=0 && $tag_id !=0){
        	//echo "inside if"; exit();
			$articles=Article::where('category_id','=',$category_id)->get();
	        $articleTags= ArticleTag::where('tag_id','=',$tag_id)->get();			
		    return view('articles.searchCategoryTag',compact('articles','articleTags'));

	    }elseif ($category_id==0){
           // echo "inside elseif 1"; exit();
	    	$articleTags= ArticleTag::where('tag_id','=',$tag_id)->get();
	    	$articles= Article::all();
	    	//var_dump($articleTags); exit();
	    	return view('articles.searchTag',compact('articleTags','articles'));

	    }elseif ($tag_id==0){

	    	$articles=Article::where('category_id','=',$category_id)->get();
	    	return view('articles.searchCategory',compact('articles'));

	    }

		

	}


	public function home(){


		$categories = Category::all();
		$sections=Section::all();
		$articles=Article::all();

		return view('articles.home',compact('categories','sections','articles'));
	}
    
    public function csvArticleReport(){


    	$articles=Article::all();
    	$output = implode(",", array('Subject', 'Category','How can See It!?','Owner','Created_at','Updated_at'))."\n";
    	foreach ($articles as $article) {
		// iterate over each tweet and add it to the csv
			if ($article->isshow==1){
                    $show="Technicals only";
            }else{
                    $show="Technicals and Users"; 
            } 	
		    $output .= implode(",", array($article->subject , $article->category->name , $show , $article->user->fname , $article->isshow , $article->created_at ,$article->updated_at)); // append each row
			$output .="\n";

		}

    	// headers used to make the file "downloadable", we set them manually
		// since we can't use Laravel's Response::download() function
		$headers = array(
		'Content-Type' => 'text/csv',
		'Content-Disposition' => 'attachment; filename="ArticleReport.csv"',
		);

		// our response, this will be equivalent to your download() but
		// without using a local file
		return Response::make(rtrim($output, "\n"), 200, $headers);
    }


}
