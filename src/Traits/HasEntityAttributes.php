<?php

namespace Homeful\References\Traits;

use Homeful\Contracts\Models\Contract;
use Homeful\References\Models\Input;
use Homeful\KwYCCheck\Models\Lead;

trait HasEntityAttributes
{
    /**
     * @return Input
     */
    public function getInput(): Input
    {
        return $this->getEntities(Input::class)->first();
    }

    /**
     * @return Lead
     */
    public function getLead(): Lead
    {
        return $this->getEntities(Lead::class)->first();
    }

    /**
     * @return Contract
     */
    public function getContract(): Contract
    {
        return $this->getEntities(Contract::class)->first();
    }
}
