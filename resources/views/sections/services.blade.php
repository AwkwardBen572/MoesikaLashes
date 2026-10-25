<section id="services" class="w-full bg-linen-light lg:px-24 px-6 lg:py-28 py-20">
    <div class="max-w-6xl mx-auto">
        <div class="text-center reveal">
            <h2 class="text-olive-deep mt-3">Services</h2>
            <div class="flourish mt-6"><i class="fas fa-leaf text-xs"></i></div>
            <p class="lg:w-2/3 mx-auto mt-6">
                Every appointment begins with a consultation, so your look is designed around your eye shape, natural lashes and lifestyle.
            </p>
        </div>

        @foreach (config('moesika.services') as $group)
            <div class="mt-16">
                <div class="reveal">
                    <h3 class="text-olive-deep text-center">{{ $group['category'] }}</h3>
                    <div class="w-10 h-px bg-olive-sage mx-auto mt-4 mb-10"></div>
                </div>

                <div class="grid lg:grid-cols-3 grid-cols-1 gap-8">
                    @foreach ($group['items'] as $service)
                        <div class="flex flex-col bg-white/70 border border-linen-cream rounded-3xl lg:p-10 p-8 shadow-sm reveal">
                            <h4 class="text-olive-deep">{{ $service['name'] }}</h4>
                            @isset($service['description'])
                                <span class="detail block text-ink/80 mt-2">{{ $service['description'] }}</span>
                            @endisset

                            <ul class="detail flex flex-col gap-3 mt-6">
                                @foreach ($service['prices'] as $option => $price)
                                    <li class="flex items-baseline gap-3">
                                        <span>{{ $option }}</span>
                                        <span class="flex-1 border-b border-dotted border-olive-sage/40"></span>
                                        <span class="font-normal text-olive-deep whitespace-nowrap">R{{ number_format($price) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="text-center mt-14 reveal">
            <span class="eyebrow text-olive-sage">By appointment only</span>
            <a href="{{ $bookingUrl }}" target="{{ str_starts_with($bookingUrl, 'http') ? '_blank' : '_self' }}" rel="noopener" class="btn btn-primary mt-6"><i class="fab fa-whatsapp"></i> Book your appointment</a>
        </div>
    </div>
</section>
