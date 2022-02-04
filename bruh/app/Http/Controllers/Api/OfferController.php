<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
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

    /**
     * Validate and save a new offer to the database.
     *
     * @param Request $request
     * @return OfferResource
     */
    public function store(Request $request): OfferResource
    {
        $offer = $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'company' => 'required|min:3|max:50',
            'description' => 'required|min:10',
        ]);

        $offer = Offer::create($offer);

        return new OfferResource($offer);
    }
}
