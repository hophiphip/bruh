<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Services\Interfaces\SearchServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        $perPage = $request->input('per_page');
        $query = $request->input('q');

        if (!$perPage) {
            $perPage = 10;
        }

        if (!$query) {
            $query = '';
        }

        return $service->search($query, $perPage);
    }

    /**
     * Fetch and return the offer.
     *
     * @param Offer $offer
     * @return OfferResource
     */
    public function show(Offer $offer): OfferResource
    {
        return new OfferResource($offer);
    }
}
