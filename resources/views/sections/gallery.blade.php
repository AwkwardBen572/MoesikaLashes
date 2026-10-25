@inject('instagram', 'App\Services\InstagramFeed')

@php
    $posts = $instagram->posts();

    // Without an Instagram token, fall back to photos in public/images/gallery.
    // Files are shown in name order; "03-volume-lashes-blue-eyes.jpeg" becomes the alt text "Volume lashes blue eyes".
    if ($posts->isEmpty() && is_dir(public_path('images/gallery'))) {
        $posts = collect(File::files(public_path('images/gallery')))
            ->filter(fn ($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']))
            ->sortBy(fn ($file) => $file->getFilename())
            ->map(fn ($file) => [
                'image' => asset('images/gallery/'.$file->getFilename()),
                'url' => null,
                'caption' => Str::of($file->getFilenameWithoutExtension())->replaceMatches('/^\d+-/', '')->replace('-', ' ')->ucfirst()->toString(),
            ])
            ->values();
    }

    $instagramUrl = 'https://www.instagram.com/'.config('moesika.instagram')[0].'/';
@endphp

<section id="gallery" class="w-full bg-linen-light lg:px-24 px-6 lg:py-28 py-20">
    <div class="max-w-6xl mx-auto">
        <div class="text-center reveal">
            <span class="eyebrow text-olive-sage">Recent work</span>
            <h2 class="text-olive-deep mt-3">Gallery</h2>
            <div class="flourish mt-6"><i class="fas fa-leaf text-xs"></i></div>
        </div>

        {{-- Masonry columns so portrait and before/after photos are shown uncropped --}}
        <div class="columns-2 lg:columns-3 lg:gap-6 gap-3 mt-16">
            @forelse ($posts as $post)
                <a @if ($post['url']) href="{{ $post['url'] }}" target="_blank" rel="noopener" @endif class="group relative block break-inside-avoid lg:mb-6 mb-3 overflow-hidden rounded-2xl bg-linen-cream reveal">
                    <img src="{{ $post['image'] }}" alt="{{ $post['caption'] ?: 'Lash work by Moesika Lashes' }}" loading="lazy" class="block w-full h-auto group-hover:scale-105 transition-transform duration-700">
                    @if ($post['url'])
                        <span class="absolute inset-0 flex items-center justify-center bg-olive-deep/0 group-hover:bg-olive-deep/30 transition-colors">
                            <i class="fab fa-instagram text-3xl text-white opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </span>
                    @endif
                </a>
            @empty
                @for ($i = 0; $i < 6; $i++)
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="break-inside-avoid lg:mb-6 mb-3 aspect-square rounded-2xl bg-linen-cream flex items-center justify-center reveal">
                        <img src="{{ asset('images/logo_short.png') }}" alt="" class="w-1/3 opacity-30 mix-blend-multiply">
                    </a>
                @endfor
            @endforelse
        </div>

        <div class="flex lg:flex-row flex-col items-center justify-center gap-4 mt-12 reveal">
            @foreach (config('moesika.instagram') as $handle)
                <a href="https://www.instagram.com/{{ $handle }}/" target="_blank" rel="noopener" class="btn btn-primary">
                    <i class="fab fa-instagram"></i> Follow &#64;{{ $handle }}
                </a>
            @endforeach
            @if (config('moesika.facebook'))
                <a href="{{ config('moesika.facebook') }}" target="_blank" rel="noopener" class="btn btn-primary">
                    <i class="fab fa-facebook-f"></i> Find us on Facebook
                </a>
            @endif
        </div>
    </div>
</section>
