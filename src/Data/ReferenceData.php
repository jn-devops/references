<?php

namespace Homeful\References\Data;

use Homeful\Contacts\Classes\ContactMetaData;
use Homeful\References\Models\Reference;
use Homeful\Contracts\Data\ContractData;
use Homeful\KwYCCheck\Data\LeadData;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class ReferenceData extends Data
{
    public function __construct(
        public string $code,
        public ?array $metadata,
        public ?Carbon $starts_at,
        public ?Carbon $expires_at,
        public ?Carbon $redeemed_at,
        public ?LeadData $lead,
        public ?ContractData $contract,
        public ?ContactMetaData $contact
    ) {}

    public static function fromModel(Reference $reference): self
    {
        $lead = $reference->getLead();
        $contract = $reference->getContract();
        $contact = optional($contract)->contact;

        return new self (
            code: $reference->code,
            metadata: $reference->metadata,
            starts_at: $reference->getAttribute('starts_at'),
            expires_at: $reference->getAttribute('expires_at'),
            redeemed_at: $reference->getAttribute('redeemed_at'),
            lead: null == $lead ? null : config('references.data.lead')::fromModel($lead),
            contract: null == $contract ? null : config('references.data.contract')::fromModel($contract),
            contact: $contact
        );
    }
}
