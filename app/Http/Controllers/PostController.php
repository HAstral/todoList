<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //customer create page
    public function create(){
        $posts=Post::orderBy('created_at','desc')->paginate(3);
        // $posts=Post::orderBy('created_at','desc')->get();
        // dd($posts);
        // $posts=Post::get()->last();//can also use random()
        // $posts=Post::where('id','<','6')->pluck('title');
        // $posts=Post::where('id','<','40')->where('address','bago')->get();//will do 'and' operation
        // $posts=Post::orwhere('id','<','40')->orwhere('address','bago')->get();//will perform 'or' operation
        // $posts=Post::whereBetween('price',[2000,5000])->get();
        // $posts=Post::select('id','address','price')->whereBetween('price',[2000,5000])->orderBy('price','desc')->get();
        // $posts=Post::select('id as ID','address as post_title')->get();
        // $posts=Post::select('address',DB::raw('COUNT(address) as add_cou'),DB::raw('SUM(price) as pri_toa'))->groupBy('address')->get();
        // $posts=Post::get();//can also use all();
        // dd($posts->toArray());

        //map each through
        // $posts=Post::get()->each(function($p){ ///can also use map
        //     $p->title=strtoupper($p->title);
        //     $p->description=strtoupper($p->description);
        //     $p->price=$p->price*2;
        //     return $p;
        // });
        // $posts=Post::paginate(5)->through(function($p){ ///can also use map
        //     $p->title=strtoupper($p->title);
        //     $p->description=strtoupper($p->description);
        //     $p->price=$p->price*2;
        //     return $p;
        // });
        // dd($posts->toArray());

        //how to search things by using keywords
            // $searchKey = $_REQUEST['key'];
            // $posts=Post::where('title','like','%'.$searchKey.'%')->get()->toArray();
            // $posts=Post::when(request('key'),function($p){ //more useful way than above
            //     $searchKey=request('key');
            //     $p->where('title','like','%'.$searchKey.'%');
            // })->get();

            // dd($posts->toArray());
            // request('searchKey');
            $posts=Post::when(request('searchKey'),function($q){
                $key=request('searchKey');
                $q->orwhere('title','like','%'.$key.'%')
                  ->orwhere('description','like','%'.$key.'%');
            })
            ->orderBy('created_at','desc')
            ->paginate(4);
        return view('create',compact('posts'));
    }
    //post create Page
    public function postCreate(Request $request){
    //    $data=[
    //     'title'=> $request->postTitle,
    //     'description'=> $request->postDescript
    //    ];
    // $validationMessage=[
    //         'postTitle.required' =>'You forget the title ,bruh',
    //         'postDescript.required' => 'You forget the description ,bruh'
    //     ];
    // Validator::make($request->all(),[
    //     'postTitle' => 'required|min:5|unique:posts,title' ,
    //     'postDescript' =>'required|min:5'
    // ],$validationMessage)->validate();//same as below
    // $validator = Validator::make($request->all(), [
    //     'postTitle' => 'required',
    //     'postDescript' => 'required',
    // ]);

    // if ($validator->fails()) {
    //     return back()
    //                 ->withErrors($validator)
    //                 ->withInput();
    // }
    // dd($request->file('postPhoto')->path());//can use extension to see file type or getClientOriginName to get photo's name
    // dd($request->hasFile('postPhoto') ? 'yes' : 'no');//show yes if you insert a photo
    $this->postValidationCheck($request);
    $response=$this->getPostData($request);
        if($request->hasFile('postPhoto')){
            // $request->file('postPhoto')->store('myPhotos');
            $fileName=uniqid() .'_hlyanGyi_'. $request->file('postPhoto')->getClientOriginalName();//unique helps you not to be overwrited even if you entered two same photos to the same file
            // $request->file('postPhoto')->storeAs('myPhotos',$fileName);
            $request->file('postPhoto')->storeAs('public',$fileName);
            $response['photo']=$fileName;
            // dd("store success");
        }

        // dd('no photo');


    Post::create($response);
    // return view('create');
    // return back();  //same as above
    return redirect()->route('post#createPage')->with(['insertSuccess'=>'Post Create success!']);
    // dd($response);
    //    dd($data);
    }
    //delete post
    public function postDelete($id){
        //first way
        // Post::where('id',$id)->delete();
        // return redirect()->route('post#createPage');//can also use return back();
        //second way
        Post::find($id)->delete();
        return back();
    }
    //direct update Page
    public function updatePage($id){

       $post= Post::where('id',$id)->first();
    //    dd($post->toArray());
        return view('update',compact('post'));
    }
    //edit Page
    public function editPage($id){
        $post= Post::where('id',$id)->first()->toArray();
        return view('edit',compact('post'));

    }

    //update Post
    public function update(Request $request){
        // dd($request->all());
        $this->postValidationCheck($request);
        $updateData=$this->getPostData($request);

        $id=$request->postId;
        if($request->hasFile('postPhoto')){
            //delete part
            $oldPhoto=Post::select('photo')->where('id',$request->postId)->first()->toArray();
            $oldPhoto= $oldPhoto['photo'];
            if($oldPhoto!=null){
            Storage::delete('public/'.$oldPhoto);}
            // $request->file('postPhoto')->store('myPhotos');
            $fileName=uniqid() .'_hlyanGyi_'. $request->file('postPhoto')->getClientOriginalName();//unique helps you not to be overwrited even if you entered two same photos to the same file
            // $request->file('postPhoto')->storeAs('myPhotos',$fileName);
            $request->file('postPhoto')->storeAs('public',$fileName);
            $updateData['photo']=$fileName;
            // dd("store success");
        }
        Post::where('id',$id)->update($updateData);
        return redirect()->route('post#createPage')->with(['updateSuccess'=>'Post Update success!']);
    }
    //get update data
    //post validation check
    private function postValidationCheck($request){

            $validationRules=[
                'postTitle' => 'required|min:5|unique:posts,title,'.$request->postId ,
                'postDescript' =>'required|min:5',
                // 'postFee' =>'required',
                // 'postAddress' =>'required',
                // 'postRating' =>'required',
                'postPhoto' => 'mimes:jpg,jpeg,png | file'

            ];


        $validationMessage=[
            'postTitle.required' =>'You forget the title ,bruh',
            'postDescript.required' => 'You forget the description ,bruh',
            'postFee.required' => 'You forget the fee ,bruh',
            'postAddress.required' => 'You forget the address ,bruh',
            'postRating.required' => 'You forget the rating ,bruh',
            'postPhoto.mimes' => 'You have to put the Photo ,bruh'

        ];
    Validator::make($request->all(), $validationRules,$validationMessage)->validate();
    }
    //get post data
    private function getPostData($request){
        $data=[
            'title'=> $request->postTitle,
        'description'=> $request->postDescript,
        ];

        $data['price']= $request->postFee == null ? 2000 : $request->postFee;
        $data['address']= $request->postAddress == null ? 'MyaukOo' : $request->postAddress;
        $data['rating']= $request->postRating == null ? 2 : $request->postRating;
       return $data;



    }
}
