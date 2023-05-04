@foreach($categoryItems as $item)
ID: {{ $item->id }}<br>
название: {{ $item->title }}<br>
категория: {{ $item->category_id }}<br>
описание: {{ $item->description }}<br>
информация: {{ $item->info }}<br>
цена: {{ $item->price }}<br>
вес: {{ $item->weight }}
<hr>
@endforeach
