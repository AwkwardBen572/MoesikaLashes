<section id="home" class="w-full lg:min-h-[min(calc(100vh-7.5rem),52rem)] min-h-[min(100svh,48rem)] lg:px-20 px-6 py-28 flex justify-center items-center flex-col bg-cover bg-center text-white" style="background-image: linear-gradient(rgba(40, 46, 34, 0.25), rgba(40, 46, 34, 0.35)), url('{{ asset('images/green_bg.jpeg') }}')">
    <span class="eyebrow text-linen-cream mb-6">Moesika Lashes</span>
    <h1 class="lg:w-[70%] w-full text-center">Your destination for professional lash extensions</h1>
    <span class="tagline mt-4 text-linen-cream">by Tania</span>

    <p class="lg:w-1/2 w-full lg:px-10 py-8 text-center text-linen-light/90">
        Every set is
        individually designed to complement your eyes, your lifestyle, and your desired look.
        Completely customised, never cookie-cutter.
    </p>

    <div class="flex lg:flex-row flex-col items-center gap-4 mt-2">
        <a href="{{ $bookingUrl }}" target="{{ str_starts_with($bookingUrl, 'http') ? '_blank' : '_self' }}" rel="noopener" class="btn btn-light"><i class="fab fa-whatsapp"></i> Book an appointment</a>
        <a href="#services" class="btn btn-outline">View services</a>
    </div>
</section>
