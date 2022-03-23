<?php

namespace App\Http\Controllers;

use App\Events\RequestNotification;
use App\Http\Requests\PostNewOfferRequest;
use App\Http\Requests\PostOfferRequest;
use App\Models\Insurer;
use App\Models\ClientLocation;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Interfaces\SearchServiceInterface;
use App\Utils\GetIpAddress;
use App\Utils\QuerySanitiser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Stevebauman\Location\Facades\Location;


class WebController extends Controller
{
    public function home(): Factory|View|Application
    {
        return view('index',[
            'requests_count' => Redis::get(OfferRequest::$cacheCountKey),
            'insurers_count' => Redis::get(Insurer::$cacheCountKey),
            'offers_count'   => Redis::get(Offer::$cacheCountKey),
        ]);
    }

    public function offers(SearchServiceInterface $service): Factory|View|Application
    {
        return view('offers', [
            'offers' => $service->search(
                QuerySanitiser::sanitise(request('q') ?? '')
            ),
        ]);
    }

    public function offer(int $id): Factory|View|Application
    {
        return view('offer', [
            'offer' => Offer::whereId($id)->firstOrFail(),
        ]);
    }

    public function offerRequestSubmit(PostOfferRequest $request, int $id): Redirector|Application|RedirectResponse
    {
        $submit = $request->validated();

        $offer = Offer::whereId($id)->firstOrFail();
        $insurer = $offer->insurer()->firstOrFail();
        $user = $insurer->user()->firstOrFail();

        $offerRequest = $offer->requests()->create([
           'email'             => $submit['email'],
           'email_verified_at' => null,
        ]);

        if ($user->isVerified()) {
            RequestNotification::dispatch($user);
        }

        if ($position = Location::get(GetIpAddress::getIp())) {
            ClientLocation::createNew($submit['email'], $position);
        }

        session()->flash('success', true);

        return redirect(RouteServiceProvider::HOME);
    }

    public function newOffer(PostNewOfferRequest $request): Redirector|Application|RedirectResponse
    {
        $submit = $request->validated();

        $user = $request->user() ?? abort(401);
        $insurer = $user->insurer()->firstOrFail();

        $caseId = Offer::caseId($submit['cases']);

        $insurer->offers()->create([
            'case_id'     => $caseId,
            'description' => $submit['description'],
        ]);

        return redirect(RouteServiceProvider::INSURER);
    }

    public function gettingStarted(): Factory|View|Application
    {
        return view('auth.getting-started');
    }
}
