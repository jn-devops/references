<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Homeful\References\Actions\CreateReferenceAction;
use Homeful\Common\Classes\Input as InputFieldName;
use Homeful\References\Events\ReferenceCreated;
use Homeful\Contacts\Models\Contact as Seller;
use Homeful\References\Data\ReferenceData;

use Homeful\Contracts\Data\ContractData;
use Homeful\Contracts\Models\Contract;
use Illuminate\Support\Facades\Event;
use Homeful\KwYCCheck\Data\LeadData;
use Homeful\References\Models\Input;
use Homeful\KwYCCheck\Models\Lead;
use Illuminate\Support\Arr;
use Carbon\CarbonInterval;

use Homeful\References\Facades\References;
use Homeful\References\Models\Reference;
use Homeful\Contacts\Models\Contact;

uses(RefreshDatabase::class, WithFaker::class);

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
    $migration = include 'vendor/jn-devops/properties/database/migrations/d_add_status_to_properties_table.php.stub';
    $migration->up();
    $migration = include 'vendor/jn-devops/contracts/database/migrations/create_contracts_table.php.stub';
    $migration->up();
});

test('reference adds contact', function () {
    $contact = Contact::factory()->create();
    $reference = References::create();
    if ($reference instanceof Reference) {
        $reference->addEntities($contact);
        expect($reference->getEntities(Contact::class)->first()->is($contact))->toBeTrue();
    }
    else {
        dd('asdsadsa');
    }
});


