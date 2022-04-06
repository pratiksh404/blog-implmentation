<?php

namespace App\Http\Controllers\Admin\API\Client;

use App\Models\Admin\Post;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostClientAPIController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PostCollection(Post::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Admin\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }
}
