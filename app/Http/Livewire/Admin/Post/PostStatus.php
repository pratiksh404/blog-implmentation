<?php

namespace App\Http\Livewire\Admin\Post;

use App\Models\Admin\Post;
use Livewire\Component;

class PostStatus extends Component
{
    public $post;

    protected $listeners = ['status_changed' => 'statusChanged'];

    public function statusChanged($status, Post $post)
    {
        $post->update([
            'status' => $status,
        ]);

        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.admin.post.post-status');
    }
}
