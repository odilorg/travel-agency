<article class="tour-card">
  <div class="tour-card__image">
    @if($tour->getFirstMediaUrl('gallery'))
      <img src="{{ $tour->getFirstMediaUrl('gallery') }}" alt="{{ $tour->title }}" loading="lazy">
    @else
      <div class="tour-card__placeholder">No Image</div>
    @endif
  </div>
  
  <div class="tour-card__content">
    <h3 class="tour-card__title">
      <a href="{{ route('tours.show', $tour->slug) ?? '#' }}">{{ $tour->title }}</a>
    </h3>
    
    @if($tour->excerpt)
      <p class="tour-card__excerpt">{{ Str::limit($tour->excerpt, 120) }}</p>
    @endif
    
    <div class="tour-card__meta">
      @if($tour->city)
        <span class="tour-card__city">📍 {{ $tour->city->name }}</span>
      @endif
      
      @if($tour->duration_days)
        <span class="tour-card__duration">🕐 {{ $tour->duration_days }} days</span>
      @endif
      
      @if($tour->price_from)
        <span class="tour-card__price">💰 From ${{ number_format($tour->price_from, 2) }}</span>
      @endif
    </div>
    
    @if($tour->categories->count() > 0)
      <div class="tour-card__categories">
        @foreach($tour->categories as $category)
          <a href="{{ route('tours.category', $category->slug) }}" class="badge">{{ $category->name }}</a>
        @endforeach
      </div>
    @endif
  </div>
</article>

