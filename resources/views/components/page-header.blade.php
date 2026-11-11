@props(['eyebrow' => null, 'title', 'description' => null])
<header class="page-heading">
    <div>@if($eyebrow)<p class="eyebrow">{{ $eyebrow }}</p>@endif<h1>{{ $title }}</h1>@if($description)<p class="page-description">{{ $description }}</p>@endif</div>
    @isset($action)<div class="heading-action">{{ $action }}</div>@endisset
</header>
