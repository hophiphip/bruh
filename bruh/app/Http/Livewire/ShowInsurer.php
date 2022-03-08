<?php

namespace App\Http\Livewire;

use App\Models\Insurer;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Http\Request;

class ShowInsurer extends Component
{
    public User $user;
    public Insurer $insurer;

    public function mount(Request $request)
    {
        $this->user = $request->user() ?? abort(401);
        $this->insurer = $this->user->insurer()->firstOrFail();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.insurer', [
            'email' => $this->user->email,
            'insurer' => $this->insurer,
            'offers' => $this->insurer->offers()->get(),
        ]);
    }
}
