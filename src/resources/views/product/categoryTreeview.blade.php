@foreach($parentCategories as $category)
    <a href="{{ route("category", ['category' => $category->id])  }}">{{ $category->name }}</a>
    @if(count($category->items))
        ({{ $category->items->count() }})
    @endif
  @if(count($category->subcategory))
    @include('product.subCategoryList',['subcategories' => $category->subcategory])
  @endif

@endforeach
