@foreach($subcategories as $subcategory)
 <ul>
    <li>
        <a href="{{ route("category", ['category' => $subcategory->id])  }}">{{ $subcategory->name }}</a>
        @if(count($subcategory->items))
            ({{ $subcategory->items->count() }})
        @endif
    </li>

  @if(count($subcategory->subcategory))
    @include('product.subCategoryList',['subcategories' => $subcategory->subcategory])
  @endif
 </ul>
@endforeach
