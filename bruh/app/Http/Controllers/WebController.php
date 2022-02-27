<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Services\Interfaces\SearchServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class WebController extends Controller
{
    public function home(): Factory|View|Application
    {
        /* TODO: Add caching */
        return view('index',[
            'insurers_count' => Insurer::count(),
            'offers_count' => Offer::count(),
            'requests_count' => OfferRequest::count(),
        ]);
    }

    public function offers(SearchServiceInterface $service): Factory|View|Application
    {
        $rawQuery = request('q') ?? '';
        $cleanQuery = htmlspecialchars($rawQuery, ENT_QUOTES, 'UTF-8');

        $offers = $service->search($cleanQuery);

        return view('offers', [
            'offers' => $offers,
        ]);
    }

    public function gettingStarted(): Factory|View|Application
    {
        return view('auth.getting-started');
    }
}
