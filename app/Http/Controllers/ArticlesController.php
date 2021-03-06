<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Article;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;
//use Session;



class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //inside model: article 

   /** public function __construct()
    {
        $this->middleware('auth:admin');

        return view('articles',compact('articles'));
    }

    */



    //use this to check all the routes with the corresponding functions inside the cmd> php artisan route:list
    public function index()
    {
       // $articles = article::all();
      //  return view('articles', compact('articles'));
        $articles = article::all();
        return view('articles.home',compact('articles'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response

   $table->increments('id');
            $table->string('title');
            $table->string('link');
            $table->string('text');
            $table->string('section');
            $table->integer('likes');
            $table->string('slug');
            $table->timestamps();


     */
            //inserting Articles into database table
            //the validate required unqiue method wont allow duplicate titles
    public function store(Request $request)
    {
        
        $article = new Article;
        $this->validate($request, ['title'=>'required|unique:articles']);
        $article->title = $request->title;
        $article->link = $request->link;
        $article->text = $request->text;
        $article->section = $request->section;
        $article->likes = $request->likes;
        $article->slug = $request->slug;

        
        //save image the database will point this image to the right folder/file
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            //this function will create an image object and it will save the image to public/images folder
            Image::make($image)->resize(400, 300)->save($location);

            $article->image = $filename;

        }



        //$article->timestamp = $request->input();
         $article->save();

        // Session::flash('succes', 'The article post was succesfully saved!');

         return redirect('articles');
        
        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   // function($query) use($id) {
    public function show($id)
    {
        //$articles = article::find($id)->all();
       // $articles = article::find($id);
        $articles = article::find($id);

        return view('articles.show', compact('articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articles = article::find($id);
        

        return view('articles.edit', compact('articles'));
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
        $articles = articles::find($id);
        $this->validate($request, ['title'=>'required']);
        $article->title = $request->title;
        $article->link = $request->link;
        $article->text = $request->text;
        $article->section = $request->section;
        $article->likes = $request->likes;
        $article->slug = $request->slug;
        
         $article->save();
         return redirect('articles');
        
        
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
    }
}


