<h2 style="margin:0 0 12px 0; font-family:Arial, sans-serif;">{{ ucfirst($payload['type'] ?? 'Contact') }}</h2>

@if(!empty($payload['tour_title']))
<p style="margin:0 0 8px 0; font-family:Arial, sans-serif;">Tour: <strong>{{ $payload['tour_title'] }}</strong> ({{ $payload['tour_slug'] ?? '' }})</p>
@endif

<p style="margin:0 0 8px 0; font-family:Arial, sans-serif;">
Name: {{ $payload['name'] ?? ($payload['first_name'] ?? '') . ' ' . ($payload['last_name'] ?? '') }}<br>
Email: {{ $payload['email'] ?? '' }}<br>
@if(!empty($payload['phone'])) Phone: {{ $payload['phone'] }}<br>@endif
@if(!empty($payload['check_in'])) Check-in: {{ $payload['check_in'] }}<br>@endif
</p>

@if(!empty($payload['message']))
<p style="margin:0 0 8px 0; font-family:Arial, sans-serif; white-space:pre-wrap;">{{ $payload['message'] }}</p>
@endif

@if(!empty($payload['pax']))
<p style="margin:0 0 8px 0; font-family:Arial, sans-serif;">Pax breakdown:</p>
<ul>
    @foreach($payload['pax'] as $optionId => $qty)
        @if($qty > 0)
            <li>#{{ $optionId }} — {{ $qty }}</li>
        @endif
    @endforeach
@endif

@if(!empty($payload['extras']))
<p style="margin:0 0 8px 0; font-family:Arial, sans-serif;">Extras: {{ implode(', ', (array) $payload['extras']) }}</p>
@endif

<p style="margin:12px 0 0 0; font-family:Arial, sans-serif; color:#888;">This email was sent from {{ config('app.name') }}.</p>


