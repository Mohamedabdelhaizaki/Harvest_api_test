<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\Api\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = (int)($request->per_page ?? config("globals.per_page"));
        $posts = Post::where('user_id', auth()->id())->paginate($perPage);

        return (new API)
            ->isOk('Posts')
            ->setData(PostResource::collection($posts)->response()->getData(true))
            ->build();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Post $post)
    {

        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $file->storeAs('public/images/' . date('Y') . '/' . date('m') . '/', $filename);
            $data['image'] =  date('Y') . '/' . date('m') . '/' . $filename;
        }

        $post->fill($request->safe()->only(['title', 'text']) + $data)->save();

        return (new API)
            ->isOk(__('Post'))
            ->setData(PostResource::make($post))
            ->build();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return (new API)
            ->isOk(__('Post'))
            ->setData(PostResource::make($post->load('user')))
            ->build();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = [];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $file->storeAs('public/images/' . date('Y') . '/' . date('m') . '/', $filename);
            $data['image'] =  date('Y') . '/' . date('m') . '/' . $filename;

            if (Storage::exists('public/images/' . $post->image)) {
                Storage::delete('public/images/' . $post->image);
            }
        }

        $post->fill($request->safe()->only(['title', 'text']) + $data)->save();

        return (new API)
            ->isOk(__('Post'))
            ->setData(PostResource::make($post))
            ->build();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return (new API)
            ->isOk('Successful Deleted')
            ->build();
    }
}
