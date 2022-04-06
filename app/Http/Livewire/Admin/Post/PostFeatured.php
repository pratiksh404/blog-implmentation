<?php

namespace App\Http\Livewire\Admin\Post;

use App\Models\Admin\Post;
use Livewire\Component;

class PostFeatured extends Component
{
    public $post;

    protected $listeners = ['featured_changed' => 'featuredChanged'];

    public function featuredChanged(Post $post)
    {
        $post->update([
            'featured' => !$post->featured,
        ]);

        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.admin.post.post-featured');
    }
}
