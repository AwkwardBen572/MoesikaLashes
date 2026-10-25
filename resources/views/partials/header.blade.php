<div class="sticky top-0 z-40">
@if (config('moesika.notice'))
    <div role="status" class="w-full bg-olive-sage text-white text-center detail font-normal tracking-wide px-4 py-2.5">
        <i class="far fa-calendar-check mr-2"></i>{{ config('moesika.notice') }}
    </div>
@endif

{{--DESKTOP--}}
<header class="w-full h-20 shadow-sm bg-linen-cream/95 backdrop-blur hidden lg:flex flex-row items-center text-olive-sage">
    <a href="#home" class="w-1/5 h-full flex justify-center items-center">
        <img src="{{ asset('images/logo_short.png') }}" alt="Moesika Lashes" class="h-full w-auto">
    </a>
    <nav class="w-4/5 h-full flex flex-row justify-end items-center gap-8 xl:gap-12 pr-16 text-header-desktop font-normal tracking-wide">
        <a href="#services" class="hover:text-olive-deep transition-colors">Services</a>
        <a href="#training" class="hover:text-olive-deep transition-colors">Training</a>
        <a href="#about" class="hover:text-olive-deep transition-colors">About</a>
        <a href="#gallery" class="hover:text-olive-deep transition-colors">Gallery</a>
        <a href="#reviews" class="hover:text-olive-deep transition-colors">Reviews</a>
        <a href="{{ $bookingUrl }}" target="{{ str_starts_with($bookingUrl, 'http') ? '_blank' : '_self' }}" rel="noopener" class="btn btn-primary"><i class="fab fa-whatsapp text-icon-desktop"></i> Book Now</a>
    </nav>
</header>
{{--DESKTOP--}}

{{--MOBILE--}}
<header class="lg:hidden flex justify-end items-center p-4 absolute top-full right-0 z-20">
    <button id="menu-toggle" type="button" aria-label="Open menu" class="bg-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center">
        <i class="fa fa-bars text-icon-mobile text-olive-sage"></i>
    </button>

    <nav id="mobile-menu" class="lg:hidden fixed top-0 left-0 z-50 w-full py-16 bg-linen-cream shadow-lg flex flex-col items-center justify-around gap-6 -translate-y-full transition-transform duration-300 text-header-mobile font-normal text-olive-sage">
        <button id="menu-close" type="button" aria-label="Close menu" class="absolute top-5 right-6">
            <i class="fa fa-times text-icon-mobile text-olive-sage"></i>
        </button>
        <img src="{{ asset('images/logo_short.png') }}" alt="Moesika Lashes" class="w-20 -mt-6">
        <a href="#services" class="text-center">Services</a>
        <a href="#training" class="text-center">Training</a>
        <a href="#about" class="text-center">About</a>
        <a href="#gallery" class="text-center">Gallery</a>
        <a href="#reviews" class="text-center">Reviews</a>
        <a href="{{ $bookingUrl }}" target="{{ str_starts_with($bookingUrl, 'http') ? '_blank' : '_self' }}" rel="noopener" class="btn btn-primary mt-2"><i class="fab fa-whatsapp"></i> Book Now</a>
    </nav>
</header>
{{--MOBILE--}}
</div>
