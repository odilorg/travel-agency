<!-- Filter Bar -->
<section class="filters-section">
  <form class="filters" method="get" action="">
    <div class="container">
      <input type="text" name="q" placeholder="Search…" value="{{ request('q') }}"/>
      <input type="number" name="min_price" placeholder="Min price" value="{{ request('min_price') }}"/>
      <input type="number" name="max_price" placeholder="Max price" value="{{ request('max_price') }}"/>
      <input type="number" name="min_days" placeholder="Min days" value="{{ request('min_days') }}"/>
      <input type="number" name="max_days" placeholder="Max days" value="{{ request('max_days') }}"/>
      <button type="submit">Apply</button>
      <a href="{{ url()->current() }}" class="btn-reset">Reset</a>
    </div>
  </form>
</section>

