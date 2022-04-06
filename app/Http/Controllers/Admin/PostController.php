<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\PostRepositoryInterface;
use App\Http\Requests\PostRequest;
use App\Models\Admin\Post;
use App\Services\PostStatistic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepositoryInterface;

    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface = $postRepositoryInterface;
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.post.index', $this->postRepositoryInterface->indexPost());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->postRepositoryInterface->storePost($request);

        return redirect(adminRedirectRoute('post'))->withSuccess('Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show', $this->postRepositoryInterface->showPost($post));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit', $this->postRepositoryInterface->editPost($post));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->postRepositoryInterface->updatePost($request, $post);

        return redirect(adminRedirectRoute('post'))->withInfo('Post Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->postRepositoryInterface->destroyPost($post);

        return redirect(adminRedirectRoute('post'))->withFail('Post Deleted Successfully.');
    }

    /**
     * Import Contacts.
     */
    public function import()
    {
        Excel::import(new PostsImport, request()->file('posts'));

        return redirect(adminRedirectRoute('post'))->withSuccess('Posts Imported.');
    }

    /**
     * Export Contacts.
     */
    public function export()
    {
        return Excel::download(new PostsExport, 'posts.xlsx');
    }
}
