@inject('google', 'App\Services\GoogleReviews')

@php
    $summary = $google->summary(10);
    $reviews = $summary['reviews'];
    $writeReviewUrl = $google->writeReviewUrl();
@endphp

<section id="reviews" class="w-full lg:px-24 px-6 lg:py-28 py-20 bg-cover bg-center text-white" style="background-image: linear-gradient(rgba(40, 46, 34, 0.35), rgba(40, 46, 34, 0.45)), url('{{ asset('images/green_bg.jpeg') }}')">
    <div class="max-w-4xl mx-auto text-center">
        <div class="reveal">
            <span class="eyebrow text-linen-cream">Kind words</span>
            <h2 class="mt-3">Reviews</h2>
            <div class="flourish mt-6 text-linen-cream"><i class="fas fa-leaf text-xs"></i></div>

            @if ($summary['rating'])
                <div class="flex items-center justify-center gap-3 mt-6 text-linen-cream">
                    <span class="tagline text-white">{{ number_format($summary['rating'], 1) }}</span>
                    @include('partials.stars', ['rating' => $summary['rating']])
                    <span class="detail text-linen-light/85">
                        @if ($summary['url'])
                            <a href="{{ $summary['url'] }}" target="_blank" rel="noopener" class="underline underline-offset-4 hover:text-white">{{ $summary['count'] }} Google {{ Str::plural('review', $summary['count']) }}</a>
                        @else
                            {{ $summary['count'] }} Google {{ Str::plural('review', $summary['count']) }}
                        @endif
                    </span>
                </div>
            @endif
        </div>

        @if (count($reviews))
            <div class="review-carousel mt-14 reveal" aria-roledescription="carousel" aria-label="Client reviews">
                {{-- Slides share one grid cell so the box keeps the height of the tallest review --}}
                <div class="grid">
                    @foreach ($reviews as $review)
                        <figure data-slide @class([
                            '[grid-area:1/1] flex flex-col items-center transition-opacity duration-700',
                            'opacity-0 pointer-events-none' => ! $loop->first,
                        ]) @if (! $loop->first) inert @endif aria-roledescription="slide" aria-label="{{ $loop->iteration }} of {{ count($reviews) }}">
                            <span class="text-linen-cream">@include('partials.stars', ['rating' => $review['rating']])</span>
                            <blockquote @class(['quote mt-6', 'lg:text-2xl text-xl' => mb_strlen($review['text']) > 280])>“{{ $review['text'] }}”</blockquote>
                            <figcaption class="flex items-center gap-3 mt-8">
                                @if ($review['photo'])
                                    <img src="{{ $review['photo'] }}" alt="" class="w-10 h-10 rounded-full" referrerpolicy="no-referrer" loading="lazy">
                                @endif
                                <span class="text-left">
                                    <span class="block font-normal">{{ $review['author'] }}</span>
                                    <span class="detail block text-linen-light/75">
                                        {{ $review['when'] }}
                                        @if ($review['url'])
                                            · <a href="{{ $review['url'] }}" target="_blank" rel="noopener" class="underline underline-offset-4 hover:text-white">Read on Google</a>
                                        @endif
                                    </span>
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>

                @if (count($reviews) > 1)
                    <div class="flex justify-center gap-3 mt-10">
                        @foreach ($reviews as $review)
                            <button type="button" data-dot aria-label="Show review {{ $loop->iteration }}" @class([
                                'w-2.5 h-2.5 rounded-full transition-colors',
                                'bg-linen-light' => $loop->first,
                                'bg-linen-light/30' => ! $loop->first,
                            ])></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <p class="mt-12 text-linen-light/90 reveal">No reviews yet.</p>
        @endif

        <div class="mt-14 pt-12 border-t border-linen-light/20 reveal">
            <h3>Loved your lashes?</h3>
            <p class="lg:w-2/3 mx-auto mt-3 text-linen-light/90">
                Whether you visited for a set or trained with Tania, we'd be so grateful if you shared your experience.
            </p>
            <a href="{{ $writeReviewUrl }}" target="_blank" rel="noopener" class="btn btn-light mt-8"><i class="fab fa-google"></i> Leave a Google review</a>
            @if (count($reviews))
                <span class="detail block mt-6 text-linen-light/75">Reviews shown are from Google</span>
            @endif
        </div>
    </div>
</section>
