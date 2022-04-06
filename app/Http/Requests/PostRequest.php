<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use App\Models\Admin\Category;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'code' => $this->post->code ?? rand(100000, 999999),
            'slug' => Str::slug($this->name),
            'author_id' => auth()->user()->id,
            'main_category_id' => isset($this->category_id) || isset($this->property->category_id) ? ($this->getMainCategory($this->category_id ?? $this->property->category_id)) : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->post->id ?? '';

        return [
            'slug' => 'required|max:255|unique:posts,slug,' . $id,
            'code' => 'required|max:255|unique:posts,code,' . $id,
            'author_id' => 'required|numeric',
            'name' => 'required|max:255',
            'category_id' => 'required|numeric',
            'main_category_id' => 'nullable|numeric',
            'excerpt' => 'required|max:255',
            'body' => 'sometimes|max:65535',
            'image' => 'sometimes|file|image:max:3000',
            'status' => 'required',
            'featured' => 'sometimes|boolean',
            'priority' => 'nullable|numeric',
            'video' => 'nullable|max:255',
            'meta_title' => 'sometimes|max:255',
            'meta_description' => 'sometimes|max:255',
            'meta_keywords' => 'sometimes',
        ];
    }

    // Get Main Category
    public function getMainCategory($given_category_id)
    {
        $category = Category::find($given_category_id);
        return $category->main_category_id ?? $category->id;
    }
}
