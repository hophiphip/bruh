<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    /**
     * Display offers page.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('offers.index');
    }

    /**
     * Display the new offer form page.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('offers.new');
    }
}
