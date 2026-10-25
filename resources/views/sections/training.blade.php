@php
    $trainingDates = collect(config('moesika.training_dates'))->map(fn ($date) => $date + [
        'status' => match (true) {
            today()->gt($date['end']) => 'completed',
            today()->gte($date['start']) => 'in-progress',
            default => 'upcoming',
        },
    ]);
@endphp

<section id="training" class="w-full lg:px-24 px-6 lg:py-28 py-20 bg-cover bg-center text-white" style="background-image: linear-gradient(rgba(40, 46, 34, 0.35), rgba(40, 46, 34, 0.45)), url('{{ asset('images/green_bg.jpeg') }}')">
    <div class="max-w-6xl mx-auto">
        {{-- Intro --}}
        <div class="text-center reveal">
            <span class="eyebrow text-linen-cream">Moesika Lashes Academy</span>
            <h2 class="mt-3">Professional Lash Training</h2>
            <div class="flourish mt-6 text-linen-cream"><i class="fas fa-leaf text-xs"></i></div>
            <p class="lg:w-2/3 mx-auto mt-6 text-linen-light/90">
                Whether you're looking to start a new career, earn an additional income, or expand your existing beauty services, we have a training option suited to your goals.
            </p>
            <p class="lg:w-2/3 mx-auto mt-4 text-linen-light/90">
                Our training is designed to provide students with both the practical skills and theoretical knowledge needed to confidently begin their lash journey. We believe in quality education, small classes, hands-on learning and ongoing support.
            </p>
        </div>

        {{-- Why choose --}}
        <div class="mt-16 reveal">
            <h3 class="text-center">Why choose Moesika Lashes Academy?</h3>
            <ul class="detail grid lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-x-8 gap-y-4 mt-8 lg:w-5/6 mx-auto">
                @foreach (config('moesika.academy_why') as $reason)
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-linen-cream mt-0.5"></i>
                        {{ $reason }}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Course options --}}
        <div class="grid lg:grid-cols-3 grid-cols-1 gap-8 mt-20 items-start">
            @foreach (config('moesika.courses') as $course)
                <div @class([
                    'relative flex flex-col rounded-3xl lg:p-10 p-8 bg-linen-light text-olive-deep shadow-2xl reveal',
                    'outline outline-1 outline-linen-cream/80 outline-offset-8 lg:-translate-y-4 lg:mt-0 mt-4' => $course['popular'] ?? false,
                ])>
                    @if ($course['popular'] ?? false)
                        <span class="eyebrow absolute -top-4 left-1/2 -translate-x-1/2 whitespace-nowrap px-5 py-1.5 rounded-full bg-olive-deep text-white shadow-lg">
                            <i class="fas fa-star mr-2"></i>Most popular
                        </span>
                    @endif

                    <span class="eyebrow self-start px-4 py-1 rounded-full bg-olive-sage text-white">{{ $course['badge'] }}</span>

                    <h3 class="mt-5">{{ $course['name'] }}</h3>
                    <span class="detail block mt-3 opacity-85"><i class="far fa-clock mr-2"></i>{{ ucfirst($course['duration']) }} · {{ $course['hours'] }}</span>

                    <span class="detail block mt-5 opacity-85">{{ $course['summary'] }}</span>

                    <ul class="detail flex flex-col gap-2 mt-6">
                        @foreach ($course['highlights'] as $highlight)
                            <li><i class="fas fa-check mr-2 text-olive-sage"></i>{{ $highlight }}</li>
                        @endforeach
                    </ul>

                    <details class="smooth-details group mt-6 pt-5 border-t border-olive-sage/20">
                        <summary class="detail font-normal cursor-pointer list-none [&::-webkit-details-marker]:hidden flex items-center justify-between">
                            What's included ({{ count($course['includes']) }})
                            <i class="fas fa-chevron-down text-xs transition-transform duration-500 group-[.is-open]:rotate-180"></i>
                        </summary>
                        <div class="overflow-hidden">
                            <ul class="detail grid grid-cols-1 gap-1.5 pt-4 opacity-85">
                                @foreach ($course['includes'] as $item)
                                    <li>· {{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </details>
                </div>
            @endforeach
        </div>

        {{-- Enrolment, booking and dates --}}
        <div class="grid lg:grid-cols-3 grid-cols-1 gap-8 mt-20">
            <div class="reveal">
                <h4><i class="fas fa-user-graduate mr-3 text-linen-cream"></i>Who can enrol?</h4>
                <span class="detail block mt-4 text-linen-light/85">
                    No previous experience is required. Our courses are suitable for complete beginners as well as beauty professionals wanting to add lash extensions to their service menu.
                </span>
                <span class="detail block mt-3 text-linen-light/85">
                    Whether your goal is to start your own lash business, create an additional income, or build a career in the beauty industry, we are here to help you get started.
                </span>
            </div>

            <div class="reveal">
                <h4><i class="fas fa-info-circle mr-3 text-linen-cream"></i>Booking information</h4>
                <span class="detail block mt-4 text-linen-light/85">
                    A non-refundable booking deposit is required to secure your training date. Training spaces are limited to ensure that every student receives individual attention and hands-on guidance.
                </span>
                <span class="detail block mt-3 text-linen-light/85">
                    Please note that deposits are non-refundable if a student cancels or fails to attend, unless otherwise agreed in writing.
                </span>
            </div>

            <div class="reveal">
                <h4><i class="far fa-calendar-alt mr-3 text-linen-cream"></i>QCTO training dates</h4>
                <ul class="flex flex-col gap-3 mt-4">
                    @foreach ($trainingDates as $date)
                        <li @class([
                            'detail font-normal flex items-center justify-between gap-3 px-5 py-3 rounded-full border',
                            'bg-linen-light/10 border-linen-light/20' => $date['status'] === 'upcoming',
                            'bg-linen-light text-olive-deep border-linen-light' => $date['status'] === 'in-progress',
                            'border-linen-light/10 text-linen-light/50' => $date['status'] === 'completed',
                        ])>
                            <span @class(['line-through' => $date['status'] === 'completed'])>{{ $date['label'] }}</span>
                            @if ($date['status'] === 'in-progress')
                                <span class="text-xs uppercase tracking-widest whitespace-nowrap"><i class="fas fa-circle text-[0.5rem] mr-1.5 text-olive-sage animate-pulse"></i>In progress</span>
                            @elseif ($date['status'] === 'completed')
                                <span class="text-xs uppercase tracking-widest whitespace-nowrap">Completed</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                @if ($trainingDates->doesntContain('status', 'upcoming'))
                    <span class="detail block mt-4 text-linen-light/85">New dates coming soon. Send us a WhatsApp to be the first to know.</span>
                @endif
                <span class="detail block mt-4 text-linen-light/85">Moesika Lashes Academy, home studio in Kempton Park</span>
            </div>
        </div>

        {{-- Call to action --}}
        <div class="text-center mt-20 reveal">
            <h3>Start your lash career today</h3>
            <p class="lg:w-2/3 mx-auto mt-4 text-linen-light/90">
                Invest in yourself and learn a skill that can create financial freedom and endless opportunities within the beauty industry. To secure your place or ask any questions about the courses, simply send us a WhatsApp.
            </p>
            <span class="tagline block mt-6 text-linen-cream">We look forward to welcoming you to the Moesika Lashes Academy family!</span>
            <a href="{{ $trainingUrl }}" target="{{ str_starts_with($trainingUrl, 'http') ? '_blank' : '_self' }}" rel="noopener" class="btn btn-light mt-8"><i class="fab fa-whatsapp"></i> Secure your place</a>
        </div>
    </div>
</section>
