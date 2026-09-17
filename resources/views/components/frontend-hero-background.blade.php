@php
    $heroBgs = [];

    try {
        $heroSettings = \App\Models\Setting::pluck('value', 'key')->all();
        $heroBgs = json_decode($heroSettings['hero_images'] ?? '[]', true) ?: [];
    } catch (\Throwable $e) {
        $heroBgs = [];
    }

    $heroBgs = array_values(array_filter($heroBgs, function ($image) {
        return !empty($image) && file_exists(public_path($image));
    }));

    if (empty($heroBgs)) {
        $defaultBgs = ['images/bg1.jpeg', 'images/bg2.jpeg', 'images/bg3.jpeg', 'images/bg4.jpeg'];
        $heroBgs = array_values(array_filter($defaultBgs, function ($image) {
            return file_exists(public_path($image));
        }));
    }

    if (empty($heroBgs)) {
        $heroBgs = ['images/placeholder-hero.svg'];
    }
@endphp

<div class="hero-bg-backdrop position-absolute top-0 start-0 w-100 h-100">
    <div class="hero-bg-slider w-100 h-100">
        @foreach ($heroBgs as $index => $heroBg)
            <div class="hero-bg-slide {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset($heroBg) }}" class="w-100 h-100 object-fit-cover" alt="Hero Background {{ $index + 1 }}">
            </div>
        @endforeach
    </div>
    <div class="hero-gradient-overlay position-absolute top-0 start-0 w-100 h-100"></div>
</div>
