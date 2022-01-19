<?php

namespace Blockpc\Traits;

trait ModalTrait
{
    public function initializeModalTrait()
	{
		$this->listeners = array_merge($this->listeners, [
			'show-modal' => 'show',
		]);
	}

}