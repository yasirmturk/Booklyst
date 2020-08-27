<?php

use App\Models\Business;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Rinvex\Addresses\Models\Address;

class BusinessSeeder extends Seeder
{
    /**
     * Category for seeding
     * @var Category
     */
    protected $menHair;

    /**
     * Category for seeding
     * @var Category
     */
    protected $womenHair;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('business_user')->delete();
        DB::table('business_category')->delete();

        Category::truncate();

        $this->seedAddresses();
        $this->seedCategories();

        Business::truncate();

        $user = User::where('email', 'p@example.com')->first();

        $this->seedBusinessesForUser($user);
        $this->seedParlourBusiness();

        Service::truncate();
        Product::truncate();

        $business1 = $this->seedHairBusinessesForUser('E Men Salon', $user, $this->menHair);
        $this->seedServicesForBusiness('Men Hair', $business1);
        $this->seedServicesForBusiness('Beard', $business1);
        $this->seedProductsForBusiness('Perfume', 4, $business1);

        $business2 = $this->seedHairBusinessesForUser('E Women Salon', $user, $this->womenHair);
        $this->seedServicesForBusiness('Women Hair', $business2);
        $this->seedServicesForBusiness('Women Nails', $business1);
        $this->seedProductsForBusiness('Perfume', 5, $business2);

        Schema::enableForeignKeyConstraints();
    }

    private function seedAddresses()
    {
        Address::truncate();
    }

    private function seedCategories()
    {
        $this->menHair = Category::create(['name' => 'Men\'s Hair', 'is_service' => 1, 'is_product' => 1]);
        $this->menHair->images()->attach(1);

        $this->womenHair = Category::create(['name' => 'Women\'s Hair', 'is_service' => 1, 'is_product' => 1]);
        $this->womenHair->images()->attach(2);

        Category::insert([
            ['name' => 'Face', 'is_service' => 0, 'is_product' => 1],
            ['name' => 'Massage', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Pedicure', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Manicure', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Spa', 'is_service' => 1, 'is_product' => 0],
        ]);
    }

    private function seedBusinessesForUser($user)
    {
        $faker = Faker\Factory::create();

        $saloon = Category::create(['name' => 'Saloon', 'is_service' => 1, 'is_product' => 0]);
        $saloon->images()->attach(3);

        $business = Business::create([
            'name' => 'Saloon X',
            'is_service' => 1,
            'is_product' => 0,
            'type' => Business::TYPE_HOME,
            'description' => $faker->text,
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
            'description' => $faker->text,
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
    }

    private function seedParlourBusiness()
    {
        $faker = Faker\Factory::create();

        $parlour = Category::create(['name' => 'Parlour', 'is_service' => 1, 'is_product' => 0]);
        $parlour->images()->attach(3);

        $superAdmin = User::where('email', 'sa@example.com')->first();
        $business = Business::create([
            'name' => 'Saloon Z',
            'is_service' => 1,
            'is_product' => 1,
            'type' => Business::TYPE_MOBILE,
            'description' => $faker->text,
            'phone' => $faker->phoneNumber,
            'employee_count' => 100
        ]);
        $business->categories()->save($parlour);
        $business->users()->save($superAdmin);
        $business->images()->attach(3);
        $business->addresses()->create([
            'label' => 'Default Address 3',
            'given_name' => $faker->firstName,
            'family_name' => $faker->lastName,
            'organization' => $faker->company,
            'country_code' => 'eg',
            'street' => $faker->streetAddress,
            'state' => $faker->state,
            'city' => $faker->city,
            'postal_code' => $faker->postcode,
            'latitude' => '31.2467601',
            'longitude' => '29.9020376',
            'is_primary' => true,
            'is_billing' => true,
            'is_shipping' => true,
        ]);
        $business->save();
    }

    private function seedHairBusinessesForUser($name, $user, $category)
    {
        $faker = Faker\Factory::create();

        $business = Business::create([
            'name' => $name,
            'is_service' => 1,
            'is_product' => 1,
            'type' => Business::TYPE_SHOP,
            'description' => $faker->text,
            'phone' => '+441274992000',
            'employee_count' => 50
        ]);
        $business->categories()->save($category);
        $business->users()->save($user);
        $business->images()->attach(1);
        $business->addresses()->create([
            'label' => 'E Address',
            'given_name' => $faker->firstName,
            'family_name' => $faker->lastName,
            'organization' => $faker->company,
            'country_code' => 'gb',
            'street' => $faker->streetAddress,
            'state' => $faker->state,
            'city' => $faker->city,
            'postal_code' => $faker->postcode,
            'latitude' => '31.2467601',
            'longitude' => '29.9020376',
            'is_primary' => true,
            'is_billing' => true,
            'is_shipping' => true,
        ]);
        $business->save();
        return $business;
    }

    private function seedServicesForBusiness($name, $business)
    {
        $faker = Faker\Factory::create();
        $service = Service::create([
            'name' => $name,
            'business_id' => $business->id,
            'duration' => $faker->randomNumber(2),
            'price' => $faker->randomFloat(2, 0, 9999),
            'discount' => $faker->randomNumber(2),
        ]);
        return $service;
    }

    private function seedProductsForBusiness($name, $imageID, $business)
    {
        $faker = Faker\Factory::create();
        $product = Product::create([
            'name' => $name,
            'business_id' => $business->id,
            'price' => $faker->randomFloat(2, 0, 9999),
            'discount' => $faker->randomNumber(2),
            'description' => $faker->text,
        ]);
        $product->images()->attach($imageID);
        $product->save();
    }
}
