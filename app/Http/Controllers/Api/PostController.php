<?php
namespace App\Http\Controllers\Api;


use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\Api\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request): JsonResponse
    {
        if($request?->type=='my-post'){
            $posts = Post::latest()->myPost()->get();
        }else{
            $posts = Post::latest()->limit(10)->get();
        }
        return $this->sendResponse(__('message.fetch.success',['name' => 'Posts']),PostResource::collection($posts));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(PostRequest $request): JsonResponse
    {
        try {
            $post = Post::create($request->validated());
            if($post){
                return $this->sendResponse(__('message.insert.success',['name' => 'Post']),PostResource::make($post));
            }else{
                return $this->sendError(__('message.insert.failure',['name'=>'Post']));
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * 
     */
    public function show($id): JsonResponse
    {
        $post = Post::find($id);
        return $this->sendResponse(__('message.fetch.success',['name' => 'Post']),PostResource::make($post));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * 
     */
    public function edit($id): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * 
     */
    public function update(PostRequest $request, $id)
    {
        try {
            $post = Post::find($id);
            if(blank($post)){
                return $this->sendError(__('message.fetch.not_found',['name' => 'Post']));
            }elseif($post){
                $post->update($request->validated());
                return $this->sendResponse(__('message.insert.success',['name' => 'Post']),PostResource::make($post));
            }else{
                return $this->sendError(__('message.insert.failure',['name'=>'Post']));
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * 
     */
    public function destroy($id): JsonResponse
    {
        try {
            $post = Post::find($id);
            if(!blank($post)){
                $post->delete();
                return $this->sendResponse(__('message.delete.success',['name' => 'Post']),[]);
            }else{
                return $this->sendError(__('message.delete.failure',['name'=>'Post']));
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }
}
