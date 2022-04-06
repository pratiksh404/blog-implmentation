<li>@foreach(range(0, $parent_loop_index) as $loop_index)--@endforeach > <span class="text-muted">{{ $child->name
        }} <a href="{{adminEditRoute('category',$child->id)}}">...<i class="fa fa-edit"></i></a></span></li>
@if($child->categories)
<ul>
    @foreach ($child->categories->sortBy('position') as $childCategory)
    @php
    $child_loop_index = $parent_loop_index + 1
    @endphp
    @include('admin.layouts.modules.category.tree_child_category',
    ['child'
    =>
    $childCategory,'parent_loop_index'
    => $child_loop_index])
    @endforeach
</ul>
@endif