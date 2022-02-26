<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\Offer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsurerController extends Controller
{
    public function insurer(): Factory|View|Application
    {
        $user = Auth::user();

        return view('insurer', [
            'email' => $user->email,
            'insurer' => $user->insurer()->get()->first(),
        ]);
    }
}
