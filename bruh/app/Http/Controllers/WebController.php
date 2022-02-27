<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Interfaces\SearchServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;


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

    public function offer(int $id): Factory|View|Application
    {
        $offer = Offer::whereId($id)->firstOrFail();

        return view('offer', [
            'offer' => $offer,
        ]);
    }

    public function offerRequestSubmit(Request $request, int $id): Redirector|Application|RedirectResponse
    {
        $submit = $request->validate([
            'email' => [ 'required', 'email' ],
            'captcha' => 'required|captcha',
        ]);

        // If insurer is verified notify him
        $offer = Offer::whereId($id)->firstOrFail();
        $insurer = $offer->insurer()->firstOrFail();
        $user = $insurer->user()->firstOrFail();

        if ($user->isVerified()) {
            // TODO: Send notification mail
        }

        /* TODO: Store email-client info in MongoDB for statistics */
        if ($position = Location::get()) {
            // TODO: e.t.c
            //Log::channel('stderr')->info($position->countryName);
        }

        session()->flash('success', true);

        return back();
    }

    public function gettingStarted(): Factory|View|Application
    {
        return view('auth.getting-started');
    }
}
