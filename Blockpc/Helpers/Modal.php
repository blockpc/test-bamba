<?php

namespace Blockpc\Helpers;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;

    public function show()
    {
        $this->show = !$this->show;
    }
}