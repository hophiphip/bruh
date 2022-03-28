<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Services\Interfaces\SearchServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class OfferController extends Controller
{
    /**
     * Return a paginated list of offers.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $offers = Offer::latest()->paginate(20);

        return OfferResource::collection($offers);
    }

    public function paginate(Request $request, SearchServiceInterface $service): LengthAwarePaginator
    {
        $perPage  = $request->input('size', 1000);
        $fromPage = $request->input('page', 0);
        $query    = $request->input('q', '');

        return $service->search($query, $perPage, $fromPage);
    }

    /**
     * Fetch and return the offer.
     *
     * @param Offer $offer
     * @return OfferResource
     */
    #[Pure]
    public function show(Offer $offer): OfferResource
    {
        return new OfferResource($offer);
    }
}
