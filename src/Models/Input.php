<?php

namespace Homeful\References\Models;

use Homeful\Common\Classes\Input as InputFieldName;
use Homeful\Common\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Input
 *
 * @property int $id
 * @property float $percent_down_payment
 * @property float $percent_miscellaneous_fees
 * @property float $down_payment_term
 * @property float $balance_payment_term
 * @property float $balance_payment_interest_rate
 * @property string $seller_commission_code
 *
 * @method int getKey()
 */
class Input extends Model
{
    use HasFactory;

    protected $fillable = [
        InputFieldName::PERCENT_DP,
        InputFieldName::PERCENT_MF,
        InputFieldName::DP_TERM,
        InputFieldName::BP_TERM,
        InputFieldName::BP_INTEREST_RATE,
        InputFieldName::SELLER_COMMISSION_CODE,
    ];
}
