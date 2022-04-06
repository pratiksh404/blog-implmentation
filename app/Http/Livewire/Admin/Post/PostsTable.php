<?php

namespace App\Http\Livewire\Admin\Post;

use App\Models\Admin\Category;
use App\Models\Admin\Post;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class PostsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $filter_type = null;

    public $startDate;

    public $endDate;

    public $user_id;

    protected $listeners = ['date_range_filter' => 'dateRangeFilter'];

    public function mount()
    {
        $this->resetPage();
        $this->filter_type = 1;
        $this->emit('initialize_posts_table');
    }

    protected $updatesQueryString = ['posts'];

    public function allPosts()
    {
        $this->resetPage();
        $this->filter_type = 1;
        $this->emit('initialize_posts_table');
    }

    // Filter
    public function todayPosts()
    {
        $this->resetPage();
        $this->filter_type = 2;
        $this->emit('initialize_posts_table');
    }

    public function weekPosts()
    {
        $this->resetPage();
        $this->filter_type = 3;
        $this->emit('initialize_posts_table');
    }

    public function monthPosts()
    {
        $this->resetPage();
        $this->filter_type = 4;
        $this->emit('initialize_posts_table');
    }

    public function yearPosts()
    {
        $this->resetPage();
        $this->filter_type = 5;
        $this->emit('initialize_posts_table');
    }

    public function dateRangeFilter($startDate, $endDate)
    {
        $this->resetPage();
        $this->filter_type = 6;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->emit('initialize_posts_table');
    }


    public function publishedPosts()
    {
        $this->resetPage();
        $this->filter_type = 8;
        $this->emit('initialize_posts_table');
    }

    public function pendingPosts()
    {
        $this->resetPage();
        $this->filter_type = 9;
        $this->emit('initialize_posts_table');
    }

    public function featuredPosts()
    {
        $this->resetPage();
        $this->filter_type = 10;
        $this->emit('initialize_posts_table');
    }

    public function authorPosts(User $user)
    {
        $this->resetPage();
        $this->filter_type = 11;
        $this->user_id = $user->id;
        $this->emit('initialize_posts_table');
    }

    public function orderByPriority()
    {
        $this->resetPage();
        $this->filter_type = 12;
        $this->emit('initialize_posts_table');
    }

    public function updatedSearch()
    {
        $this->filter_type = 14;
        $this->emit('initialize_posts_table');
    }

    public function render()
    {
        $posts = $this->initializePosts();
        $authors = User::has('posts', '>', 0)->with('posts')->get();

        return view('livewire.admin.post.posts-table', compact('authors', 'posts'));
    }

    protected function initializePosts()
    {
        $filter = $this->filter_type;
        if ($filter == 1) {
            return Post::tenent()->with('author')->latest()->paginate(10);
        } elseif ($filter == 2) {
            return Post::tenent()->with('author')->today()->paginate(10);
        } elseif ($filter == 3) {
            return  Post::tenent()->with('author')->week()->paginate(10);
        } elseif ($filter == 4) {
            return Post::tenent()->with('author')->month()->paginate(10);
        } elseif ($filter == 5) {
            return Post::tenent()->with('author')->year()->paginate(10);
        } elseif ($filter == 6) {
            $start = Carbon::create($this->startDate);
            $end = Carbon::create($this->endDate);

            return Post::tenent()->with('author')->whereBetween('updated_at', [$start->toDateString(), $end->toDateString()])->paginate(10);
        } elseif ($filter == 8) {
            return Post::tenent()->published()->with('author')->latest()->paginate(10);
        } elseif ($filter == 9) {
            return Post::tenent()->pending()->with('author')->latest()->paginate(10);
        } elseif ($filter == 10) {
            return Post::tenent()->featured()->with('author')->latest()->paginate(10);
        } elseif ($filter == 11) {
            return Post::tenent()->where('author_id', $this->user_id)->paginate(10);
        } elseif ($filter == 12) {
            return  Post::tenent()->with('author')->orderBy('priority', 'desc')->paginate(10);
        } elseif ($filter == 13) {
            return Post::tenent()->with('author')->where('category_id', $this->categoryid)->latest()->paginate(10);
        } elseif ($filter == 14) {
            return $this->searchQuery()->tenent()->with('author')->latest()->paginate(10);
        } else {
            return Post::tenent()->with('author')->latest()->paginate(10)->paginate(10);
        }
    }

    protected function searchQuery()
    {
        $search = $this->search ?? null;
        if ($search != '') {
            return Post::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('excerpt', 'LIKE', '%' . $search . '%')
                    ->orWhere('meta_title', 'LIKE', '%' . $search . '%')
                    ->orWhere('meta_description', 'LIKE', '%' . $search . '%');
            });
        } else {
            return Post::latest();
        }
    }
}
