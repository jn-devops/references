<?php

namespace Homeful\References\Traits;

use Homeful\References\Models\Input;

trait HasEntityAttributes
{
    public function getInputAttribute(): ?Input
    {
        return $this->getEntities(Input::class)->first();
    }
}
