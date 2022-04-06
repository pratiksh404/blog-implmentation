<?php

namespace App\Http\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Admin\Category;

class ReorderParentCategory extends Component
{
    public function updateParentCategories($lists)
    {
        foreach ($lists as $list) {
            Category::find($list['value'])->update(['position' => $list['order']]);
        }
        $this->emit('reorderingComplete');
    }
    public function updateGroupCategories($lists)
    {
        foreach ($lists as $list) {
            $parent_order = $list['order'] ?? 0;
            if (count($list['items']) > 0) {
                foreach ($list['items'] as $item) {
                    Category::find($item['value'])->update(['position' => $parent_order + $item['order']]);
                }
            }
        }
        $this->emit('reorderingComplete');
    }

    public function render()
    {
        $parentCategories = Category::whereNull('parent_id')->with('childrenCategories')->orderBy('position')->get();
        return view('livewire.admin.category.reorder-parent-category', compact('parentCategories'));
    }
}
