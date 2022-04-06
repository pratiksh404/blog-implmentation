<?php

namespace App\Http\Livewire\Admin\Post;

use App\Models\Admin\Post;
use Livewire\Component;

class PostPriority extends Component
{
    public $post;

    public $priority;

    protected $listeners = ['priority_changed' => 'priorityChanged'];

    public function mount($post)
    {
        $this->post = $post;
        $this->priority = isset($post) ? $post->priority : 1;
    }

    public function priorityChanged(Post $post)
    {
        $post->update([
            'priority' => $this->priority ?? 1,
        ]);
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.admin.post.post-priority');
    }
}
