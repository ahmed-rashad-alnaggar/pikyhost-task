@php
    $heroSection = $sections['hero'];
    $aboutSection = $sections['about'];
    $contactSection = $sections['contact'];

    $heroSectionBackgroundImagesChunks = array_chunk(
        $heroSection['background_images'],
        intdiv(count($heroSection['background_images']), 3)
    );

    // Only Allow 3 columns.
    if (count($heroSectionBackgroundImagesChunks) > 3) {
        array_push($heroSectionBackgroundImagesChunks[2], ...$heroSectionBackgroundImagesChunks[3]);
        unset($heroSectionBackgroundImagesChunks[3]);
    }

    $heroSectionBackgroundImagesChunks = array_map(
        fn (array $chunk): array => array_merge($chunk, $chunk), $heroSectionBackgroundImagesChunks
    );

    $heroSectionSliderImages = array_merge($heroSection['slider_images'], $heroSection['slider_images']);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="{{ $page['seo_description'] }}">
    <meta name="keywords" content="{{ $page['seo_keywords'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $page['title'] }}</title>
    <link rel="icon" href="{{ $page['logo'] }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    @foreach($theme['fonts']['urls'] as $fontURL)
        <link href="{{ $fontURL }}" rel="stylesheet" />
    @endforeach

    <!-- Styles -->
    <style>
        :root {
            --primary-color:
                {{ $theme['colors']['primary'] }}
            ;
            --main-heading-color:
                {{ $theme['colors']['main_heading'] }}
            ;
            --sub-heading-color:
                {{ $theme['colors']['sub_heading'] }}
            ;
            --body-text-color:
                {{ $theme['colors']['body_text'] }}
            ;

            --main-heading-font-family:
                {!!  $theme['fonts']['families']['main_heading'] !!}
            ;
            --sub-heading-font-family:
                {!! $theme['fonts']['families']['sub_heading'] !!}

            ;
            --body-text-font-family:
                {!! $theme['fonts']['families']['body_text'] !!}
            ;

            --primary-gradient-from-color:
                {{ $theme['gradients']['primary']['from'] }}
            ;
            --primary-gradient-to-color:
                {{ $theme['gradients']['primary']['to'] }}
            ;

            scroll-behavior: smooth;
        }

        @keyframes slide-h {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @keyframes slide-v {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-50%);
            }
        }

        @keyframes pulseBorder {

            0%,
            100% {
                opacity: 0.5;
                filter: blur(4px);
            }


            50% {
                opacity: 1;
                filter: blur(8px);
            }

        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
</head>

<body class="relative bg-[--primary-color] font-[family-name:var(--body-text-font-family)] text-[--body-text-color]">
    <header class="absolute left-0 top-0 z-30 flex w-full items-center justify-between border-b border-white px-8 py-2">
        <a href="/">
            <img src="{{ $page['logo'] }}" class="h-8 object-contain md:h-12" alt="Pikyhost" />
        </a>
        <a href="{{ $heroSection['cta_link'] }}" class="relative hidden border border-white/50 px-12 py-3 font-[family-name:var(--sub-heading-font-family)] text-lg font-semibold text-[--sub-heading-color] transition hover:bg-white/10 md:block">
            <span class="relative z-10">{{ $heroSection['cta_text'] }}</span>
            <span class="absolute inset-0 animate-[pulseBorder_1.5s_infinite_ease-in-out] border-2 border-white/60 blur-lg"></span>
        </a>
    </header>

    <main class="space-y-8">
        <section id="hero">
            <div class="relative z-0 flex h-[90vh] max-h-[500px] items-center justify-center gap-y-4 bg-white px-8 md:max-h-[550px] md:justify-start">
                <div class="absolute inset-0 z-10 h-full w-full overflow-hidden">
                    <div class="ml-auto flex h-full w-[90%] origin-bottom-left -translate-y-[20%] rotate-[15deg] items-start gap-x-3 md:w-[65%] md:max-w-[870px] md:-translate-y-[35%]">
                        @foreach ($heroSectionBackgroundImagesChunks as $chunk)
                            <div class="flex w-[70%] max-w-80 flex-none animate-[slide-v_50s_linear_infinite] flex-col will-change-transform even:[animation-direction:reverse]">
                                @foreach ($chunk as $thumbnail)
                                    <img src="{{ $thumbnail }}" class="rounded-md object-cover [margin-block-end:0.75rem] [margin-block-start:0.75rem]" alt="thumbnail" />
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="relative z-10 flex flex-col items-center gap-y-2 md:w-1/2 md:items-start">
                    <p class="font-[family-name:var(--sub-heading-font-family)] text-lg font-semibold text-[--sub-heading-color]">
                        {{ $heroSection['tagline'] }}
                    </p>
                    <h1 class="font-[family-name:var(--main-heading-font-family)] text-3xl font-bold text-[--main-heading-color] md:text-5xl">
                        {{ $heroSection['main_heading'] }}
                    </h1>
                    <p class="font-[family-name:var(--sub-heading-font-family)] text-lg font-semibold text-[--sub-heading-color]">
                        {{ $heroSection['sub_heading'] }}
                    </p>
                    <a href="{{ $heroSection['cta_link'] }}" class="relative mt-6 border border-white/50 px-6 py-3 font-[family-name:var(--sub-heading-font-family)] text-xl font-semibold text-[--sub-heading-color] transition hover:bg-white/10 md:px-12 md:text-2xl">
                        <span class="relative z-10">{{ $heroSection['cta_text'] }}</span>
                        <span class="absolute inset-0 animate-[pulseBorder_1.5s_infinite_ease-in-out] border-2 border-white/60 blur-lg"></span>
                    </a>
                </div>

                <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-[--primary-gradient-to-color] via-[--primary-gradient-to-color] via-[33%] to-transparent"></div>
            </div>

            <div class="h-[10vh] max-h-[100px] overflow-hidden py-3.5 [mask-image:linear-gradient(to_right,_transparent,_#000000_10%_90%,_transparent)]">
                <div class="flex h-full w-max animate-[slide-h_50s_linear_infinite] items-center will-change-transform">
                    @foreach ($heroSectionSliderImages as $logo)
                        <img src="{{ $logo }}" class="me-[5vw] ms-[5vw] max-h-full object-contain" alt="logo" />
                    @endforeach
                </div>
            </div>
        </section>

        <section id="about" class="flex h-screen flex-col-reverse items-center justify-center gap-8 px-8 md:flex-row">
            <div class="md:w-1/3">
                <img src="{{ $aboutSection['illustration'] }}" class="object-contain" alt="illustration" />
            </div>

            <div class="flex flex-col items-center gap-y-2 md:w-1/3">
                <h2 class="font-[family-name:var(--main-heading-font-family)] text-2xl font-bold text-[--main-heading-color] md:text-4xl">
                    {{ $aboutSection['heading'] }}
                </h2>
                <p class="font-[family-name:var(--body-text-font-family)] text-[--body-text-color] md:text-lg">
                    {{ $aboutSection['description'] }}
                </p>
            </div>
        </section>

        <section id="contact" class="flex h-screen flex-col flex-wrap content-center items-center justify-center gap-8 px-8 md:flex-row md:gap-y-16">
            <h2 class="text-center font-[family-name:var(--main-heading-font-family)] text-2xl font-bold text-[--main-heading-color] md:w-full md:text-4xl">
                {{ $contactSection['heading'] }}
            </h2>

            <div class="flex flex-col items-center gap-y-2 md:w-1/3 md:items-start">
                <div>
                    <a href="tel:{{ $contactSection['phone'] }}" class="inline-flex items-center justify-center gap-x-2">
                        <i class="fa-solid fa-phone"></i>
                        <span>{{ $contactSection['phone'] }}</span>
                    </a>
                </div>

                <div>
                    <a href="mailto:{{ $contactSection['email'] }}" class="inline-flex items-center justify-center gap-x-2">
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ $contactSection['email'] }}</span>
                    </a>
                </div>

                <p class="flex items-center justify-center gap-x-2">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>{{ $contactSection['address'] }}</span>
                </p>
            </div>

            <a href="mailto:{{ $contactSection['cta_email'] }}" class="relative border border-white/50 px-6 py-3 font-[family-name:var(--sub-heading-font-family)] text-xl font-semibold text-[--sub-heading-color] transition hover:bg-white/10 md:px-12 md:text-2xl">
                <span class="relative z-10">{{ $contactSection['cta_text'] }}</span>
                <span class="absolute inset-0 animate-[pulseBorder_1.5s_infinite_ease-in-out] border-2 border-white/60 blur-lg"></span>
            </a>
        </section>
    </main>

    <footer class="border-t border-white py-2">
        <p class="text-center">©2025 Pickhost. All rights reserved</p>
    </footer>
</body>

</html>