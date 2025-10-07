@extends('layouts.app')

@section('content')
<section class="page-hero">
  <div class="container">
    <h1>
      @isset($category) {{ $category->name }} @endisset
      @isset($tag) Tours — {{ $tag->name }} @endisset
      @empty($category) @empty($tag) Tours @endempty @endempty
    </h1>
    @isset($category)
      @if($category->description)<p class="lead">{{ $category->description }}</p>@endif
    @endisset
  </div>
</section>

@include('tours._filters')

<section class="tours-grid">
  <div class="container">
    <div class="grid">
      @forelse($tours as $tour)
        @include('components.tour-card', ['tour' => $tour])
      @empty
        <p>No tours found.</p>
      @endforelse
    </div>

    <div class="pagination">
      {{ $tours->appends(request()->query())->links() }}
    </div>
  </div>
</section>

@push('scripts')
<script type="application/ld+json">
{!! json_encode($collectionSchema ?? [], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
@endsection

