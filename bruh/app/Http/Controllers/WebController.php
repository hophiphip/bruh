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
use Illuminate\Support\Facades\Redis;
use Stevebauman\Location\Facades\Location;

/* TODO: New signed up users don't show as verified on the insurer page */

class WebController extends Controller
{
    public function home(): Factory|View|Application
    {
        return view('index',[
            'insurers_count' => Redis::get(Insurer::$cacheCountKey),
            'offers_count' => Redis::get(Offer::$cacheCountKey),
            'requests_count' => Redis::get(OfferRequest::$cacheCountKey),
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

    public function newOffer(Request $request): Redirector|Application|RedirectResponse
    {
        $user = $request->user() ?? abort(401);
        $insurer = $user->insurer()->firstOrFail();

        $allCases = implode(',', array_values(Offer::CASES));

        $submit = $request->validate([
            'cases' => 'required|in:' . $allCases,
            'description' => 'required',
        ]);

        $caseId = Offer::caseId($submit['cases']);

        $insurer->offers()->create([
            'case_id' => 1,
            'description' => $submit['description'],
        ]);

        return redirect(RouteServiceProvider::INSURER);
    }

    public function gettingStarted(): Factory|View|Application
    {
        return view('auth.getting-started');
    }
}
