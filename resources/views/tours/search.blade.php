@extends('layouts.app')

@section('content')
<section class="page-hero">
  <div class="container">
    <h1>Search Tours</h1>
    <form class="search-form" method="get" action="{{ route('tours.search') }}">
      <input type="text" name="q" value="{{ $q }}" placeholder="Search tours..." />
      <button type="submit">Search</button>
    </form>
  </div>
</section>

<section class="tours-grid">
  <div class="container">
    <p class="results-count">Results: {{ $tours->total() }}</p>
    <div class="grid">
      @forelse($tours as $tour)
        @include('components.tour-card', ['tour'=>$tour])
      @empty
        <p>No matches for "{{ $q }}".</p>
      @endforelse
    </div>

    <div class="pagination">
      {{ $tours->appends(request()->query())->links() }}
    </div>
  </div>
</section>

@push('head')
{{-- rel=prev/next for SEO pagination --}}
@if($tours->previousPageUrl())
  <link rel="prev" href="{{ $tours->previousPageUrl() }}">
@endif
@if($tours->nextPageUrl())
  <link rel="next" href="{{ $tours->nextPageUrl() }}">
@endif
@endpush

@push('scripts')
<script type="application/ld+json">
{!! json_encode($collectionSchema ?? [], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
@endsection

