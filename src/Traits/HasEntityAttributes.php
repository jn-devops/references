<?php

namespace Homeful\References\Traits;

trait HasEntityAttributes
{
    public function getInput()
    {
        return $this->getEntities(config('references.models.input'))->first();
    }

    public function getLead()
    {
        return $this->getEntities(config('references.models.lead'))->first();
    }

    public function getContract()
    {
        return $this->getEntities(config('references.models.contract'))->first();
    }

    public function getContact()
    {
        return $this->getEntities(config('references.models.contact'))->first();
    }
}
