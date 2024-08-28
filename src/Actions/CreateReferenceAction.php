<?php

namespace Homeful\References\Actions;

use Homeful\Common\Classes\Input as InputFieldName;
use Homeful\References\Events\ReferenceCreated;
use Homeful\References\Facades\References;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use Homeful\References\Models\Reference;
use Homeful\References\Models\Input;

class CreateReferenceAction
{
    use AsAction;

    public function handle(array $attribs, array $metadata = []): Reference
    {
        $validated = Validator::validate($attribs, $this->rules());
        $input = Input::create($validated);
        $entities = array_filter(compact('input'));
        $reference = References::withEntities(...$entities)
            ->withStartTime(now())
            ->withExpireTime(now())//TODO: update this
            ->withMetadata($metadata)->create();
        ReferenceCreated::dispatch($reference);

        return $reference;
    }

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
}
