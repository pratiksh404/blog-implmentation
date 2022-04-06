<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-lg">
            <div class="card-body p-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="name">Post Title</label>
                            <div class="input-group">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $post->name ?? old('name') }}" placeholder="Post Title">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="excerpt">Post Excerpt</label>
                            <div class="input-group">
                                <textarea name="excerpt" id="excerpt"
                                    class="excerpt form-control">@isset($post->excerpt){{ $post->excerpt }}@endisset</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <textarea name="body" id="heavytexteditor" class="body form-control">
                                   @isset($post->body)
                                    {!! $post->body !!}        
                                   @endisset
                                   </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <x-adminetic-edit-add-button :model="$post ?? null" name="Post" />
        </div>
    </div>
    <div class="col-lg-4" style="height:80vh;overflow-y:auto">
        <div class="card shadow-lg">
            <div class="card-body p-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="author">Author</label>
                            <div class="input-group">
                                <input type="hidden" name="author_id"
                                    value="{{ $post->author_id ?? auth()->user()->id }}">
                                <input type="text" name="author" id="author" class="form-control"
                                    value="{{ $post->author->name ?? auth()->user()->name }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body shadow-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="categories">Categories</label>
                        <div class="form-control">
                            <select name="categories[]" id="categories" class="select2" multiple>
                                @isset($categories)
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{isset($post->categories) ?
                                    (in_array($category->id,$post->categories->pluck('id')->toArray()) ? 'selected' :
                                    '') : ''}}>{{$category->name}}</option>
                                @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card shadow-lg">
            <div class="card-body p-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="image">Post Video</label> <br>
                                    <input type="text" name="video" id="video" class="form-control"
                                        value="{{ $post->video ?? old('video') }}" placeholder="Video URL">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="image">Post Image</label> <br>
                                    <input type="file" name="image" id="image" accept="image/*"
                                        onchange="readURL(this);">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 d-flex justify-content-center">
                                    @if (isset($post->image))
                                    <br>
                                    <img src="{{ $post->image }}" alt="{{ $post->name ?? '' }}" class="img-fluid"
                                        id="post_image">
                                    @endif
                                    <img src="" id="post_image_plcaeholder" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card shadow-lg">
            <div class="card-body p-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="status">Status</label>
                            <div class="input-group">
                                <select name="status" id="status" class="select2 form-control">
                                    <option selected disabled>Select Status ..</option>
                                    <option value="1" {{ isset($post) ? ($post->status == 'Draft' ? 'selected' : '') :
                                        '' }}>
                                        Draft
                                    </option>
                                    <option value="2" {{ isset($post) ? ($post->status == 'Pending' ? 'selected' : '') :
                                        'selected' }}>
                                        Pending</option>
                                    @hasRole('admin|moderator')
                                    <option value="3" {{ isset($post) ? ($post->status == 'Published' ? 'selected' : '')
                                        : '' }}>
                                        Published</option>
                                    @endhasRole
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="priority">Priority ?</label> <br>
                            <input type="number" name="priority" id="priority" class="touchspin"
                                value="{{ $post->priority ?? (old('priority') ?? 1) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card shadow-lg">
            <div class="card-body p-3">
                <div class="card-body">
                    <div class="row">
                        <b>SEO</b>
                        <div class="col-lg-12">
                            <label for="meta_title">SEO Title</label>
                            <div class="input-group">
                                <input type="text" name="meta_title" id="meta_title" class="form-control"
                                    value="{{ $post->meta_title ?? old('meta_title') }}" placeholder="SEO Title">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="meta_description">Meta Description</label>
                            <div class="input-group">
                                <textarea name="meta_description" id="meta_description"
                                    style="width:100%">@isset($post->meta_description){{ $post->meta_description }}@endisset</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="meta_keywords">Meta Keywords</label>
                            <div class="input-group">
                                <select name="meta_keywords[]" id="meta_keywords" class="tags form-control" multiple>
                                    @isset($post->meta_keywords)
                                    @foreach ($post->meta_keywords as $meta_keyword)
                                    <option value="{{ $meta_keyword }}" selected>{{ $meta_keyword }}
                                    </option>
                                    @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>