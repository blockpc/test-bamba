<?php

namespace App\Http\Livewire\System\Dashboards;

use App\Models\Setting;
use App\Models\User;
use Livewire\Component;

class Admin extends Component
{
    public User $auth;
    public Setting $setting;
    
    public function mount()
    {
        $this->auth = current_user();
        $this->setting = Setting::first();
    }

    public function render()
    {
        return view('livewire.system.dashboards.admin');
    }
}
