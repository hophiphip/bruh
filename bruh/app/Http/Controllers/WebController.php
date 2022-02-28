<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\ClientLocation;
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

        $offer = Offer::whereId($id)->firstOrFail();
        $insurer = $offer->insurer()->firstOrFail();
        $user = $insurer->user()->firstOrFail();

        $offerRequest = $offer->requests()->create([
           'email' => $submit['email'],
           'email_verified_at' => null,
        ]);

        // If insurer is verified notify him about a new request
        if ($user->isVerified()) {
            $offerRequest->sendNotificationMessage();
        }

        /* TODO: Can be seed up with local DB location storage -- but need to download some stuff and store it in .git repo and licence stuff */
        // Store client-email-related meta/location data
        if ($position = Location::get()) {
            ClientLocation::create([
               'email' => $submit['email'],
               'location' => [
                   'country_code' => $position->countryCode,
                   'country' => $position->countryName,
                   'city' => $position->cityName,
                   'lat' => $position->latitude,
                   'lng' => $position->longitude
               ],
            ]);
        }

        session()->flash('success', true);

        return redirect(RouteServiceProvider::HOME);
    }

    public function gettingStarted(): Factory|View|Application
    {
        return view('auth.getting-started');
    }
}
