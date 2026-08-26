{{--DESKTOP--}}
<header class="w-full h-20 shadow-lg bg-linen-cream hidden lg:flex flex-row items-center text-olive-sage">
    <div class="w-[20%] h-full">
        <img src="{{ asset('images/logo_short.png') }}" alt="logo_short" class="w-25 h-full mx-auto">
    </div>
    <nav class="w-[80%] h-full flex flex-row justify-around items-center text-header-desktop">
        <a href="services" class="flex flex-row items-center p-6 w-[15%] h-[50%] text-center">Services</a>
        <a href="training" class="flex flex-row items-center p-6 w-[15%] h-[50%] text-center">Training</a>
        <a href="about" class="flex flex-row items-center p-6 w-[15%] h-[50%] text-center">About</a>
        <a href="gallery" class="flex flex-row items-center p-6 w-[15%] h-[50%] text-center">Gallery</a>
        <a href="" class="flex flex-row items-center justify-around p-6 w-[15%] h-[50%] text-center rounded-4xl bg-olive-sage text-white"><i class="fab fa-whatsapp text-icon-desktop"></i> Book Now</a>
    </nav>
</header>
{{--DESKTOP--}}

{{--MOBILE--}}
<header class="lg:hidden flex w-full justify-end items-center p-4">
    <button id="menu-toggle" type="button" class="bg-olive-sage p-8 rounded-full">
        <i class="fa fa-bars text-icon-mobile text-white"></i>
    </button>

    <nav id="mobile-menu" class="lg:hidden fixed top-0 left-0 z-50 w-full h-1/5 bg-linen-cream shadow-lg flex flex-col items-center justify-around gap-4 -translate-y-full transition-transform duration-300 text-header-mobile text-olive-sage">
        <button id="menu-close" type="button" class="absolute top-2 right-2 text-3xl">
            <i class="fa fa-times text-icon-mobile text-olive-sage"></i>
        </button>
        <a href="services" class="text-center">Services</a>
        <a href="training" class="text-center">Training</a>
        <a href="about" class="text-center">About</a>
        <a href="gallery" class="text-center">Gallery</a>
        <a href="" class="flex flex-row items-center justify-around gap-2 pt-3 pb-3 pl-6 pr-6 text-center rounded-4xl bg-olive-sage text-white"><i class="fab fa-whatsapp text-icon-mobile"></i>&nbsp; Book Now</a>
    </nav>
</header>
{{--MOBILE--}}
