<?php

namespace App\Http\Livewire\Admin\Category;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Admin\Category;

class QuickCategory extends Component
{
    public $category_id;
    public $name;
    public $categoryid;

    protected $rules = [
        'code' => 'required|max:255|unique:categories,code',
    ];

    public function mount($category_id = null)
    {
        $this->category_id = $category_id;
    }

    public function submit()
    {
        $parent_id = $this->categoryid ? ($this->categoryid != '' ? $this->categoryid : null) : null;
        $category = Category::create([
            'code' => rand(100000, 999999),
            'name' => $this->name,
            'parent_id' => $parent_id,
            'main_category_id' => $this->getMainCategory($parent_id),
            'slug' => Str::slug($this->name),
        ]);

        $this->category_id = $category->id;

        $this->emit('quick_category_created');
    }
    public function render()
    {
        $parentcategories = Category::whereNull('parent_id')->with('childrenCategories')->get();
        return view('livewire.admin.category.quick-category', compact('parentcategories'));
    }

    public function getMainCategory($parent_id = null)
    {
        $parent_id = $parent_id ?? null;
        if (!is_null($parent_id)) {
            $category = Category::find($parent_id);
            if (isset($category)) {
                while (true) {
                    if (isset($category->parent_id)) {
                        $category = Category::find($category->parent_id);
                    } else {
                        break;
                    }
                }
                return $category->id;
            }
        }
        return null;
    }
}
