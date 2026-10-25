{{-- Five stars for a rating out of 5, with half stars --}}
<span class="inline-flex gap-1" role="img" aria-label="{{ $rating }} out of 5 stars">
    @for ($i = 1; $i <= 5; $i++)
        @if ($rating >= $i)
            <i class="fas fa-star"></i>
        @elseif ($rating >= $i - 0.5)
            <i class="fas fa-star-half-alt"></i>
        @else
            <i class="far fa-star"></i>
        @endif
    @endfor
</span>
