<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Component;

/* TODO: Livewire is crap - is can't parse template that contains @section, and all the content must be placed inside a <div>...</div> */

class Admin extends Component
{
    /* TODO: Limit to 10 and add search bar */
    public Collection $users;

    public function mount(Request $request)
    {
        $this->users = User::all();
    }

    public function toggleVerified(int $id)
    {
        User::whereId($id)->firstOrFail()->toggleVerified();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.admin', [
            'users' => $this->users,
        ])->extends('layouts.app')->section('content');
    }
}
