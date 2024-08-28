<?php

namespace Homeful\References\Actions;

use Homeful\Common\Classes\Input as InputFieldName;
use Homeful\References\Events\ReferenceCreated;
use Homeful\References\Facades\References;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use Homeful\References\Models\Reference;
use Homeful\References\Models\Input;
use Carbon\CarbonInterval;

class CreateReferenceAction
{
    use AsAction;

    /**
     * @param array $attribs
     * @param array $metadata
     * @return Reference
     * @throws \Exception
     */
    public function handle(array $attribs, array $metadata = []): Reference
    {
        $reference = References::withEntities(...$this->getEntities($attribs))
            ->withStartTime(now())
            ->withExpireDateIn($this->getInterval())
            ->withMetadata($metadata)->create();
        ReferenceCreated::dispatch($reference);

        return $reference;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            InputFieldName::PERCENT_DP => ['required', 'numeric', 'min:0', 'max:0.50'],
            InputFieldName::PERCENT_MF => ['required', 'numeric', 'min:0', 'max:0.15'],
            InputFieldName::DP_TERM => ['required', 'integer', 'min:0', 'max:24'],
            InputFieldName::BP_TERM => ['required', 'integer', 'min:0', 'max:30'],
            InputFieldName::BP_INTEREST_RATE => ['required', 'numeric', 'min:0', 'max:0.20'],
            InputFieldName::SELLER_COMMISSION_CODE => ['required', 'string'],
        ];
    }

    /**
     * @return CarbonInterval
     * @throws \Exception
     */
    public function getInterval(): CarbonInterval
    {
        return CarbonInterval::create(config('references.expiry', 'P30D'));
    }

    /**
     * @param array $attribs
     * @return array
     */
    public function getEntities(array $attribs): array
    {
        $validated = Validator::validate($attribs, $this->rules());
        $input = app(Input::class)->create($validated);

        return array_filter(compact('input'));
    }
}
