<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
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
use DB;

//for csv
use Response;

class ArticlesController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Authorize user to view article
	 * @param  integer $user_id
	 * @return Response
	 */
	private function articleAuth( $article )
	{		

		//article exists
		if (empty($article)){
			return false;
		}
		//article shown to tech only or all users
		if (Auth::User()->type =="regular" && $article->isshow == 0 ){
			return false;
		}
		return true;
	}

	/*
	 * Headers used to export files to CSV
	 */
	private function getCSVHeaders(){

		return array('Pragma' =>  'public',
			'Expires' =>  '0' , 
			'Cache-Control' =>  'must-revalidate, post-check=0, pre-check=0' , 
			'Content-Description' =>  'File Transfer' , 
			'Content-Type' =>  'text/csv' , 
			'Content-Disposition' => 'attachment; filename=export.csv;' , 
			'Content-Transfer-Encoding' =>  'binary' ,

		);

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
		
		//authenticate admin
		if (!$this->adminAuth()){
			return view('errors.404');
		}
		$categories=Category::all();
		$sections=Section::all();
		$articles=Article::paginate(5);

		//set default path
		$articles->setPath('/articles/search/');

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
		
		//authenticate admin
		if (!$this->adminAuth()){
			return view('errors.404');
		}
		$categories=Category::all();
		$sections=Section::all();
		return view('articles.create',compact('categories','sections'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		

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
		
		$article=Article::find($id);

		//authorize user to view article
		if (!$this->articleAuth($article) ){
			return view('errors.404');
		}
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
			return view('errors.404');
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
        if($category_id !=0 && $tag_id !=0){
	
	        $articles = Article::where('category_id','=',$category_id)->join('article_tags','article_tags.article_id','=','articles.id')
	            ->select('articles.*')
	            ->where('article_tags.tag_id', '=' , $tag_id )->paginate(5);

	    }elseif($category_id ==0 && $tag_id ==0){ //both not set
	    	$articles = Article::paginate(5);
	    }elseif ($category_id==0 ){   //tags only case
	            $articles = Article::join('article_tags','article_tags.article_id','=','articles.id')
	            ->select('articles.*')
	            ->where('article_tags.tag_id', '=' , $tag_id )->paginate(5);
		
	    }elseif ($tag_id==0){        //category only case

	    	$articles=Article::where('category_id','=',$category_id)->paginate(5);

	    }

		
	        return view('articles.search',compact('articles'));

	}


	public function home(){


		$categories = Category::all();
		$sections=Section::all();
		$articles=Article::all();

		return view('articles.home',compact('categories','sections','articles'));
	}
    
    public function csvArticleReport(){


    	$articles=Article::all();

    	$output = chr(0xEF) . chr(0xBB) . chr(0xBF) ;
    	$output .= implode(",", array('Subject', 'Category','How can See It!?','Owner','Created_at','Updated_at'))."\n";
    	foreach ($articles as $article) {
		// iterate over each tweet and add it to the csv
			if ($article->isshow==1){
                    $show="Technicals only";
            }else{
                    $show="Technicals and Users"; 
            } 	
		    $output .= implode(",", array($article->subject , $article->category->name , $show , $article->user->fname ,  $article->created_at ,$article->updated_at)); // append each row
			$output .="\n";

		}

    	// headers used to make the file "downloadable", we set them manually
		// since we can't use Laravel's Response::download() function
		$headers = $this->getCSVHeaders();

		// our response, this will be equivalent to your download() but
		// without using a local file
		return Response::make(rtrim($output, "\n"), 200, $headers);
    }


}
