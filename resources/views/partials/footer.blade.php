<footer id="contact" class="w-full text-olive-deep" style="background-image: linear-gradient(rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.2)), url('{{ asset('images/cream_bg.jpeg') }}'); background-size: cover; background-position: center">
    <div class="max-w-6xl mx-auto lg:px-24 px-6 lg:py-24 py-16 text-center reveal">
        <h2>Ready for your lashes?</h2>
        <p class="lg:w-2/3 mx-auto mt-5 text-ink">
            Send a message on WhatsApp to book your appointment or ask any questions. Tania will get back to you as soon as she can.
        </p>
        <a href="{{ $bookingUrl }}" target="{{ str_starts_with($bookingUrl, 'http') ? '_blank' : '_self' }}" rel="noopener" class="btn btn-primary mt-10"><i class="fab fa-whatsapp"></i> Book on WhatsApp</a>
    </div>

    <div class="border-t border-olive-sage/20">
        <div class="detail max-w-6xl mx-auto lg:px-24 px-6 py-14 grid lg:grid-cols-3 grid-cols-1 gap-10 lg:text-left text-center">
            <div class="flex flex-col lg:items-start items-center">
                <img src="{{ asset('images/logo_short.png') }}" alt="Moesika Lashes" class="w-20 mix-blend-multiply">
                <span class="tagline mt-3">Moesika Lashes by Tania</span>
            </div>

            <div>
                <span class="eyebrow text-olive-sage mb-4">Studio</span>
                <span class="block"><i class="fas fa-map-marker-alt mr-2 text-olive-sage"></i>{{ config('moesika.location') }}</span>
                <ul class="mt-3 flex flex-col gap-1">
                    @foreach (config('moesika.hours') as $days => $time)
                        <li>{{ $days }} <span class="text-olive-sage">·</span> {{ $time }}</li>
                    @endforeach
                </ul>
            </div>

            <div>
                <span class="eyebrow text-olive-sage mb-4">Connect</span>
                <ul class="flex flex-col gap-2">
                    @if (config('moesika.phone'))
                        <li><a href="tel:+{{ config('moesika.whatsapp') }}" class="hover:text-olive-sage transition-colors"><i class="fas fa-phone-alt mr-2"></i>{{ config('moesika.phone') }}</a></li>
                    @endif
                    @if (config('moesika.whatsapp'))
                        <li><a href="{{ $bookingUrl }}" target="_blank" rel="noopener" class="hover:text-olive-sage transition-colors"><i class="fab fa-whatsapp mr-2"></i>WhatsApp</a></li>
                    @endif
                    @foreach (config('moesika.instagram') as $handle)
                        <li><a href="https://www.instagram.com/{{ $handle }}/" target="_blank" rel="noopener" class="hover:text-olive-sage transition-colors"><i class="fab fa-instagram mr-2"></i>&#64;{{ $handle }}</a></li>
                    @endforeach
                    @if (config('moesika.facebook'))
                        <li><a href="{{ config('moesika.facebook') }}" target="_blank" rel="noopener" class="hover:text-olive-sage transition-colors"><i class="fab fa-facebook-f mr-2"></i>Facebook</a></li>
                    @endif
                    @if (config('moesika.email'))
                        <li><a href="mailto:{{ config('moesika.email') }}" class="hover:text-olive-sage transition-colors"><i class="far fa-envelope mr-2"></i>{{ config('moesika.email') }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="detail py-6 text-center text-olive-deep/70 border-t border-olive-sage/20">
        &copy; {{ date('Y') }} Moesika Lashes. All rights reserved.
    </div>
</footer>
