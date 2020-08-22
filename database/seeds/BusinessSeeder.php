<?php

use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Rinvex\Addresses\Models\Address;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->seedCatgories();
        $this->seedAddresses();
        $this->seedBusinesses();

        Schema::enableForeignKeyConstraints();
    }

    private function seedCatgories()
    {
        Category::truncate();

        $category = Category::create(['name' => 'Men\'s Hair', 'is_service' => 1, 'is_product' => 1]);
        $category->images()->attach(1);

        $category = Category::create(['name' => 'Women\'s Hair', 'is_service' => 1, 'is_product' => 1]);
        $category->images()->attach(2);

        Category::insert([
            ['name' => 'Face', 'is_service' => 0, 'is_product' => 1],
            ['name' => 'Massage', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Pedicure', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Manicure', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Spa', 'is_service' => 1, 'is_product' => 0],
        ]);
    }

    private function seedAddresses()
    {
        Address::truncate();
    }

    private function seedBusinesses()
    {
        Business::truncate();

        $saloon = Category::create(['name' => 'Saloon', 'is_service' => 1, 'is_product' => 0]);
        $saloon->images()->attach(3);

        $parlour = Category::create(['name' => 'Parlour', 'is_service' => 1, 'is_product' => 0]);
        $parlour->images()->attach(3);

        $user = User::where('email', 'u@example.com')->first();
        $business = Business::create([
            'name' => 'Saloon X',
            'is_service' => 1,
            'is_product' => 0,
            'type' => Business::TYPE_HOME,
            'phone' => '+441274991000',
            'employee_count' => 10
        ]);
        $business->categories()->save($saloon);
        $business->users()->save($user);
        $business->images()->attach(3);
        $business->addresses()->create([
            'label' => 'Default Address 1',
            'given_name' => 'Abdelrahman 1',
            'family_name' => 'Omran',
            'organization' => 'Rinvex',
            'country_code' => 'eg',
            'street' => '56 john doe st.',
            'state' => 'Alexandria',
            'city' => 'Alexandria',
            'postal_code' => '21614',
            'latitude' => '31.2467601',
            'longitude' => '29.9020376',
            'is_primary' => true,
            'is_billing' => true,
            'is_shipping' => true,
        ]);
        $business->save();

        $admin = User::where('email', 'a@example.com')->first();
        $business = Business::create([
            'name' => 'Saloon Y',
            'is_service' => 0,
            'is_product' => 1,
            'type' => Business::TYPE_SHOP,
            'phone' => '+441274992000',
            'employee_count' => 50
        ]);
        $business->categories()->save($saloon);
        $business->users()->save($admin);
        $business->images()->attach(3);
        $business->addresses()->create([
            'label' => 'Default Address 2',
            'given_name' => 'Abdelrahman 2',
            'family_name' => 'Omran',
            'organization' => 'Rinvex',
            'country_code' => 'eg',
            'street' => '56 john doe st.',
            'state' => 'Alexandria',
            'city' => 'Alexandria',
            'postal_code' => '21614',
            'latitude' => '31.2467601',
            'longitude' => '29.9020376',
            'is_primary' => true,
            'is_billing' => true,
            'is_shipping' => true,
        ]);
        $business->save();

        $superAdmin = User::where('email', 'sa@example.com')->first();
        $business = Business::create([
            'name' => 'Saloon Z',
            'is_service' => 1,
            'is_product' => 1,
            'type' => Business::TYPE_MOBILE,
            'phone' => '+441274993000',
            'employee_count' => 100
        ]);
        $business->categories()->save($parlour);
        $business->users()->save($superAdmin);
        $business->images()->attach(3);
        $business->addresses()->create([
            'label' => 'Default Address 3',
            'given_name' => 'Abdelrahman 3',
            'family_name' => 'Omran',
            'organization' => 'Rinvex',
            'country_code' => 'eg',
            'street' => '56 john doe st.',
            'state' => 'Alexandria',
            'city' => 'Alexandria',
            'postal_code' => '21614',
            'latitude' => '31.2467601',
            'longitude' => '29.9020376',
            'is_primary' => true,
            'is_billing' => true,
            'is_shipping' => true,
        ]);
        $business->save();
    }
}
