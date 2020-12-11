@foreach($items['content'] as $item)
    <meta name="{!! $item['name'] !!}" content="{!! $item['value'] !!}">
@endforeach
<title>{{ $items['title'] }}</title>
