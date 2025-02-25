<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request): View
    {
        $theme = config('theme');
        $page = Page::where('type', 'landing')->first();
        $sections = $page->sections->pluck('content', 'type')->toArray();

        $page = $page->only('title', 'seo_keywords', 'seo_description');
        $page['logo'] = asset('storage/images/logo.svg');

        $sections['hero']['background_images'] = array_map(
            fn (string $image): string => Storage::disk('public')->url($image),
            $sections['hero']['background_images']
        );

        $sections['hero']['slider_images'] = array_map(
            fn (string $image): string => Storage::disk('public')->url($image),
            $sections['hero']['slider_images']
        );

        $sections['about']['illustration'] = Storage::disk('public')->url($sections['about']['illustration']);

        return view('landing', compact('theme', 'page', 'sections'));
    }
}
