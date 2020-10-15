<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorCommentsResource;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['comments' , 'author' , 'category'])->paginate( 10);
        return new PostsResource( $posts );
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'category_id'=>'required'
        ]);
        $user = $request->user();
        $post = new Post();
        $post->title=$request->get('title');
        $post->content = $request->get('content');
        if(intval($request->get('category_id')) !=0){
            $post->category_id=intval($request->get('category_id'));
        }
        $post->user_id = $user->id;

        $post->votes_up =0;
        $post->votes_down=0;
        $post->date_written = Carbon::now()->format('Y.m.d H:i:s');
        /**
         * TODO:hopa exep in image
         */
        if( $request->hasFile('featured_image') ){
            $featuredImage = $request->file( 'featured_image' );
            $filename = time().$featuredImage->getClientOriginalName();
            Storage::disk('images')->put(
                $filename,
                $featuredImage,
                $filename
            );
            $post->featured_image = url('/') . '/images/' .$filename;
        }


        $post->save();
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with( ['comments' , 'author' , 'category'] )->where( 'id' , $id )->get();
        return new PostResource( $post );

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
    public function comments($id){
        $post = Post::find($id);
        $comment = $post->comments()->paginate();
        return new AuthorCommentsResource($comment);

    }
        public function votes( Request $request , $id ){
            $request->validate( [
                'vote'  => 'required'
            ] );
            $post = Post::find( $id );
            if( $request->get( 'vote' ) == 'up' ){
                $voters_up = json_decode( $post->voters_up );
                if( $voters_up == null ){
                    $voters_up = [];
                }
                if( ! in_array( $request->user()->id , $voters_up ) ){
                    $post->votes_up += 1;
                    array_push( $voters_up , $request->user()->id );
                    $post->voters_up = json_encode( $voters_up );
                    $post->save();
                }
            }
    
            if( $request->get( 'vote' ) == 'down' ){
                $voters_down = json_decode( $post->voters_down );
                if( $voters_down == null ){
                    $voters_down = [];
                }
                if( ! in_array( $request->user()->id , $voters_down ) ){
                    $post->votes_down += 1;
                    array_push( $voters_down , $request->user()->id );
                    $post->voters_down = json_encode( $voters_down );
                    $post->save();
                }
            }
            return new PostResource( $post );
        }
    }
    

    
