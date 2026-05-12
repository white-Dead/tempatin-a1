<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class AuthNav extends Component
{
    #[On('refreshAuthNav')]
    public function refresh(): void
    {
        // Re-renders the component with the current auth state
    }

    public function render()
    {
        return view('livewire.auth-nav');
    }
}
