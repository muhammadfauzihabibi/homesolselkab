<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;

class FrontendController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('aktif', true)
            ->firstOrFail();

        return view('frontend.page', compact('page'));
    }
}