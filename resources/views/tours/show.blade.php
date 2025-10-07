@extends('layouts.app')

@section('content')
<section class="tour-detail">
  <div class="container">
    <h1>{{ $tour->title }}</h1>
    
    @if($tour->excerpt)
      <p class="lead">{{ $tour->excerpt }}</p>
    @endif
    
    <div class="tour-info">
      @if($tour->city)
        <p><strong>Location:</strong> {{ $tour->city->name }}</p>
      @endif
      
      @if($tour->duration_days)
        <p><strong>Duration:</strong> {{ $tour->duration_days }} days
          @if($tour->duration_nights), {{ $tour->duration_nights }} nights @endif
        </p>
      @endif
      
      @if($tour->price_from)
        <p><strong>Price from:</strong> ${{ number_format($tour->price_from, 2) }} {{ $tour->currency }}</p>
      @endif
      
      @if($tour->difficulty)
        <p><strong>Difficulty:</strong> {{ ucfirst($tour->difficulty) }}</p>
      @endif
    </div>
    
    @if($tour->description_html)
      <div class="tour-description">
        {!! $tour->description_html !!}
      </div>
    @endif
    
    @if($tour->categories->count() > 0)
      <div class="tour-categories">
        <strong>Categories:</strong>
        @foreach($tour->categories as $category)
          <a href="{{ route('tours.category', $category->slug) }}" class="badge">{{ $category->name }}</a>
        @endforeach
      </div>
    @endif
    
    @if($tour->tags->count() > 0)
      <div class="tour-tags">
        <strong>Tags:</strong>
        @foreach($tour->tags as $tag)
          <a href="{{ route('tours.tag', $tag->slug) }}" class="badge badge-secondary">{{ $tag->name }}</a>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection

