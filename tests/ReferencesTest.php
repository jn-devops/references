<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Homeful\References\Actions\CreateReferenceAction;
use Homeful\Common\Classes\Input as InputFieldName;
use Homeful\References\Events\ReferenceCreated;
use Homeful\Contacts\Models\Contact as Seller;
use Homeful\References\Data\ReferenceData;
use Homeful\References\Facades\References;
use Homeful\References\Models\Reference;
use Homeful\Contracts\Data\ContractData;
use Homeful\Contracts\Models\Contract;
use Illuminate\Support\Facades\Event;
use Homeful\KwYCCheck\Data\LeadData;
use Homeful\References\Models\Input;
use Homeful\KwYCCheck\Models\Lead;
use Illuminate\Support\Arr;
use Carbon\CarbonInterval;

uses(RefreshDatabase::class, WithFaker::class);

const INPUT_ID = 1234;
const LEAD_ID = '9b182ba6-842f-4531-9d38-920e5a904358';
const CONTRACT_ID = 317;
const SELLER_ID = 537;

beforeEach(function () {
    $migration = include 'vendor/frittenkeez/laravel-vouchers/publishes/migrations/2018_06_12_000000_create_voucher_tables.php';
    $migration->up();
    $migration = include 'vendor/homeful/kwyc-check/database/migrations/create_leads_table.php.stub';
    $migration->up();
    $migration = include 'vendor/spatie/laravel-medialibrary/database/migrations/create_media_table.php.stub';
    $migration->up();
    $migration = include 'vendor/jn-devops/contacts/database/migrations/create_contacts_table.php.stub';
    $migration->up();
    $migration = include 'vendor/jn-devops/products/database/migrations/create_products_table.php.stub';
    $migration->up();
    $migration = include 'vendor/jn-devops/properties/database/migrations/create_properties_table.php.stub';
    $migration->up();
    $migration = include 'vendor/jn-devops/contracts/database/migrations/create_contracts_table.php.stub';
    $migration->up();
});

dataset('lead', function () {
    return [
        [fn () => Lead::factory()->forContact()->create(['id' => LEAD_ID])],
    ];
});

dataset('contract', function () {
    return [
        [fn () => Contract::factory()->create(['id' => CONTRACT_ID])],
    ];
});

dataset('seller', function () {
    return [
        [fn () => Seller::factory()->create(['id' => SELLER_ID])],
    ];
});

dataset('input', function () {
    return [
        [fn () => Input::factory()->create(['id' => INPUT_ID])],
    ];
});

test('input has attributes', function () {
    $input = Input::factory()->create();
    if ($input instanceof Input) {
        expect($input->percent_down_payment)->toBeFloat();
        expect($input->percent_miscellaneous_fees)->toBeFloat();
        expect($input->down_payment_term)->toBeFloat();
        expect($input->balance_payment_term)->toBeFloat();
        expect($input->balance_payment_interest_rate)->toBeFloat();
        expect($input->seller_commission_code)->toBeString();
    }
});

test('reference model mimic voucher', function (Input $input, Seller $seller, Lead $lead, Contract $contract) {
    $prefix = 'jn';
    $mask = '***-***-***';
    $expiry = CarbonInterval::create(2, 0, 5, 1, 1, 2, 7, 123); // 2 years 5 weeks 1 day 1 hour 2 minutes 7 seconds
    $metadata = [
        'discount' => 10,
    ];
    $entities = array_filter(compact('input', 'lead', 'contract'));
    $reference = References::withPrefix($prefix)
        ->withMask($mask)
        ->withMetadata($metadata)
        ->withExpireDateIn($expiry)
        ->withOwner($seller)
        ->withEntities(...$entities)
        ->create();
    expect($reference)->toBeInstanceOf(Reference::class);
    if ($reference instanceof Reference) {
        $code = $reference->code;
        $success = false;
        try {
            $success = References::redeem($code, $seller, ['foo' => 'bar']);

        } catch (FrittenKeeZ\Vouchers\Exceptions\VoucherNotFoundException $e) {
            // Code provided did not match any vouchers in the database.
        } catch (FrittenKeeZ\Vouchers\Exceptions\VoucherAlreadyRedeemedException $e) {
            // Voucher has already been redeemed.
        }
        expect($success)->toBeTrue();
        expect($reference->owner)->toBe($seller);

        expect($input->is(Input::find(INPUT_ID)))->toBeTrue();
        expect($reference->getEntities(Input::class)->first()->is($input))->toBeTrue();

        expect($lead->is(Lead::find(LEAD_ID)))->toBeTrue();
        expect($reference->getEntities(Lead::class)->first()->is($lead))->toBeTrue();

        expect($contract->is(Contract::find(CONTRACT_ID)))->toBeTrue();
        expect($reference->getEntities(Contract::class)->first()->is($contract))->toBeTrue();

        expect($reference->getInput()->is($input))->toBeTrue();
        expect($reference->getLead()->is($lead))->toBeTrue();
        expect($reference->getContract()->is($contract))->toBeTrue();
        expect($reference->owner->is($seller))->toBeTrue();
        expect($reference->metadata)->toBe($metadata);

        $success = false;
        try {
            $success = References::redeem($code, $seller, ['foo' => 'bar']);
        } catch (FrittenKeeZ\Vouchers\Exceptions\VoucherNotFoundException $e) {
            // Code provided did not match any vouchers in the database.
        } catch (FrittenKeeZ\Vouchers\Exceptions\VoucherAlreadyRedeemedException $e) {
            // Voucher has already been redeemed.
        }

        expect($success)->toBeFalse();
    }
})->with('input', 'seller', 'lead', 'contract');

test('reference config', function () {
    $reference = References::create();
    if ($reference instanceof Reference) {
        $prefix = config('vouchers.prefix');
        expect(substr($reference->code, 0, strlen($prefix)))->toBe($prefix);
    }
});

dataset('attribs', function () {
    return [
        [fn() => [
            InputFieldName::PERCENT_DP => $this->faker->numberBetween(5, 10)/100,
            InputFieldName::PERCENT_MF => $this->faker->numberBetween(8, 10)/100,
            InputFieldName::DP_TERM => $this->faker->numberBetween(12, 24) * 1.00,
            InputFieldName::BP_TERM => $this->faker->numberBetween(20, 30) * 1.00,
            InputFieldName::BP_INTEREST_RATE => $this->faker->numberBetween(3, 7)/100,
            InputFieldName::SELLER_COMMISSION_CODE => $this->faker->word(),
        ]]
    ];
});

dataset('reference', function () {
    return [
        [fn() => app(CreateReferenceAction::class)->run([
            InputFieldName::PERCENT_DP => $this->faker->numberBetween(5, 10)/100,
            InputFieldName::PERCENT_MF => $this->faker->numberBetween(8, 10)/100,
            InputFieldName::DP_TERM => $this->faker->numberBetween(12, 24) * 1.00,
            InputFieldName::BP_TERM => $this->faker->numberBetween(20, 30) * 1.00,
            InputFieldName::BP_INTEREST_RATE => $this->faker->numberBetween(3, 7)/100,
            InputFieldName::SELLER_COMMISSION_CODE => $this->faker->word(),
        ], ['author' => 'Lester'])]
    ];
});

test('reference has initial nullable but settable entity attributes', function (Lead $lead) {
    $reference = References::create();
    if ($reference instanceof Reference) {
        expect($reference->getInput())->toBeNull();
        expect($reference->getLead())->toBeNull();
        expect($reference->getContract())->toBeNull();
        expect($lead->id)->toBeUuid();
        $reference->addEntities($lead);
        expect($reference->getLead()->id)->toBe($lead->id);
        $contact = $lead->contact;
        expect($contact->id)->toBeUuid();
        $reference->addEntities($contact);
    }
})->with('lead');

test('create reference action', function(Lead $lead, array $attribs) {
    Event::fake();
    $action = app(CreateReferenceAction::class);
    $reference = $action->run($attribs);
    $reference->addEntities($lead);
    if ($reference instanceof Reference) {
        expect($reference)->toBeInstanceOf(Reference::class);
        expect($reference->getLead()->is($lead))->toBeTrue();;
    }
    Event::assertDispatched(ReferenceCreated::class);
})->with('lead', 'attribs');

test('create reference end point', function(Lead $lead, array $attribs) {
    $booking_server_response = $this->postJson(route('create-reference'), $attribs);
    $booking_server_response->assertStatus(200);
    with($booking_server_response->json(), function (array $json) {
        expect(Arr::get($json, 'reference_code'))->toBeString();
        $code = Arr::get($json, 'reference_code');
        expect(Reference::where('code', $code)->first())->toBeInstanceOf(Reference::class);
    });
})->with('lead', 'attribs');

test('reference has data', function (Reference $reference, Lead $lead, Contract $contract) {
    $reference->addEntities($lead);
    $reference->addEntities($contract);
    with (ReferenceData::fromModel($reference), function(ReferenceData $data) use ($reference, $lead) {
        expect($data->code)->toBe($reference->code);
        expect($data->metadata)->toBe($reference->metadata);
        expect($data->starts_at->eq($reference->starts_at))->toBeTrue();
        expect($data->expires_at->eq($reference->expires_at))->toBeTrue();
        expect($data->lead)->toBeInstanceOf(LeadData::class);
        expect($data->contract)->toBeInstanceOf(ContractData::class);
    });
})->with('reference', 'lead', 'contract');
