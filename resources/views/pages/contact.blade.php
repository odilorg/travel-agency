@extends('layouts.app')

@section('content')
<section class="pt-10 lg:pt-12 pb-2 border border-b-0 border-l-0 border-r-0 border-t-light-grey">
    <div class="container">
        <nav class="font-medium text-grey" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1 mb-2">
                <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-dark-grey">Contact</span></li>
            </ul>
        </nav>
    </div>
</section>

<section class="py-12">
    <div class="container">
        <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-6">Contact Us</h1>
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-300">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-300">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('contact.submit') }}" class="max-w-xl space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Your name" class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none" required>
            <input type="email" name="email" placeholder="Email" class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none" required>
            <input type="tel" name="phone" placeholder="Phone" class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none">
            <textarea name="message" rows="5" placeholder="Message" class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none" required></textarea>
            <button type="submit" class="bg-green-zomp text-white font-semibold py-2 px-6 rounded-[200px]">Send</button>
        </form>
    </div>
</section>
@endsection


