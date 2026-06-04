<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(): View
    {
        $featuredServices = Service::where('is_active', true)->take(6)->get();
        $barbers = Barber::with('user')->where('is_active', true)->get();
        $testimonials = Review::where('is_approved', true)
            ->with(['customer.user', 'barber.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('public.home', compact('featuredServices', 'barbers', 'testimonials'));
    }

    public function services(): View
    {
        $categories = ServiceCategory::where('is_active', true)
            ->with(['services' => fn($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        return view('public.services', compact('categories'));
    }

    public function about(): View
    {
        $barbers = Barber::with('user')->where('is_active', true)->get();

        return view('public.about', compact('barbers'));
    }

    public function contact(): View
    {
        return view('public.contact');
    }

    public function hours(): View
    {
        return view('public.hours');
    }

    public function gallery(): View
    {
        $galleryItems = Gallery::where('is_active', true)
            ->with('barber.user')
            ->orderBy('sort_order')
            ->get();

        return view('public.gallery', compact('galleryItems'));
    }
}
