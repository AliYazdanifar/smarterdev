@if (! empty($page['breadcrumbs']))
@php
    $trail = array_merge([['خانه', 'home']], $page['breadcrumbs']);
@endphp
<nav class="crumbs" aria-label="مسیر صفحه">
  <ol>
    @foreach ($trail as $i => $crumb)
      @php $last = $i === count($trail) - 1; @endphp
      @if ($last || empty($crumb[1]))
        <li><span aria-current="page">{{ $crumb[0] }}</span></li>
      @else
        <li><a href="{{ route($crumb[1], $crumb[2] ?? []) }}">{{ $crumb[0] }}</a></li>
      @endif
    @endforeach
  </ol>
</nav>
@endif
