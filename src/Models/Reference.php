<?php

namespace Homeful\References\Models;

use Homeful\References\Traits\HasEntityAttributes;
use FrittenKeeZ\Vouchers\Models\Voucher;
use Homeful\Contracts\Models\Contract;
use Homeful\KwYCCheck\Models\Lead;
use Illuminate\Support\Carbon;

/**
 * Class Reference
 *
 * @property string $code
 * @property Carbon $starts_at
 * @property Carbon $expires_at
 * @property string $checkin_code
 * @property object $owner
 * @property array $metadata
 * @property Input $input
 *
 * @method   int    getKey()
 */
class Reference extends Voucher
{
    use HasEntityAttributes;

    static public function from(Voucher $voucher): self
    {
        $model = new self;
        $model->setRawAttributes($voucher->getAttributes(), true);
        $model->exists = true;
        $model->setConnection($voucher->getConnectionName());
        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    public function getForeignKey(): string
    {
        return 'voucher_id';
    }

    public function resolveRouteBinding($value, $field = null): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->where('code', $value)->firstOrFail();
    }

    public function getInput(): Input
    {
        return $this->getEntities(Input::class)->first();
    }

    public function getLead(): Lead
    {
        return $this->getEntities(Lead::class)->first();
    }

    public function getContract(): Contract
    {
        return $this->getEntities(Contract::class)->first();
    }
}
