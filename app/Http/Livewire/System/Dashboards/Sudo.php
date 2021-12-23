<?php

namespace App\Http\Livewire\System\Dashboards;

use App\Models\User;
use Blockpc\Models\Fadmin\Log;
use Blockpc\Traits\AlertBrowserEvent;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sudo extends Component
{
    use AlertBrowserEvent;
    
    public User $auth;

    public function mount()
    {
        $this->auth = current_user();
    }

    public function render()
    {
        return view('livewire.system.dashboards.sudo');
    }
}
