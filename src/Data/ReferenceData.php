<?php

namespace Homeful\References\Data;

use Homeful\References\Models\Reference;
use Homeful\Contracts\Data\ContractData;
use Homeful\Contracts\Models\Contract;
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
//        public ?ContractData $contract,
    ) {}

    public static function fromModel(Reference $reference): self
    {
        $isContract = $reference->getContract() instanceof Contract;//TODO: fix ContractData

        return new self (
            code: $reference->code,
            metadata: $reference->metadata,
            starts_at: $reference->getAttribute('starts_at'),
            expires_at: $reference->getAttribute('expires_at'),
            redeemed_at: $reference->getAttribute('redeemed_at'),
            lead: null == $reference->getLead() ? null : LeadData::fromModel($reference->getLead()),
//            contract: $isContract ? ContractData::fromModel($reference->getContract()) : null
        );
    }
}
