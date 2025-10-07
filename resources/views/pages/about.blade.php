@extends('layouts.app')

@section('content')
<section class="pt-10 lg:pt-12 pb-2 border border-b-0 border-l-0 border-r-0 border-t-light-grey">
    <div class="container">
        <nav class="font-medium text-grey" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1 mb-2">
                <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-dark-grey">About Us</span></li>
            </ul>
        </nav>
    </div>
</section>

<section class="py-12">
    <div class="container">
        <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-4">About Us</h1>
        <p class="text-dark-grey">Static About page placeholder. We will port the template sections (mission, team, etc.) in the next iteration.</p>
    </div>
</section>
@endsection


