@props([
    'eyebrow' => null,
    'eyebrowVariant' => 'primary', // primary, accent, success
    'title' => '',
    'description' => null,
    'actionUrl' => null,
    'actionLabel' => null,
    'actionIcon' => 'bi-arrow-right',
    'align' => 'start', // start, center
])

@php
    $eyebrowClass = match($eyebrowVariant) {
        'accent' => 'bento-eyebrow bento-eyebrow-accent',
        'success' => 'bento-eyebrow bento-eyebrow-success',
        default => 'bento-eyebrow',
    };
@endphp

<div class="bento-section-header {{ $align === 'center' ? 'text-center' : '' }}">
  @if($align === 'center')
    <div class="max-w-2xl mx-auto">
      @if($eyebrow)
        <div>
          <span class="{{ $eyebrowClass }}">
            {{ $eyebrow }}
          </span>
        </div>
      @endif
      <h2 class="bento-title">{{ $title }}</h2>
      @if($description)
        <p class="bento-desc mx-auto">{{ $description }}</p>
      @endif
    </div>
  @else
    <div class="row align-items-end g-3">
      <div class="col-lg-8">
        @if($eyebrow)
          <div>
            <span class="{{ $eyebrowClass }}">
              {{ $eyebrow }}
            </span>
          </div>
        @endif
        <h2 class="bento-title mb-2">{{ $title }}</h2>
        @if($description)
          <p class="bento-desc">{{ $description }}</p>
        @endif
      </div>
      @if($actionUrl && $actionLabel)
        <div class="col-lg-4 text-lg-end">
          <a href="{{ $actionUrl }}" class="btn-bento btn-bento-outline">
            {{ $actionLabel }} <i class="bi {{ $actionIcon }}"></i>
          </a>
        </div>
      @endif
    </div>
  @endif
</div>
