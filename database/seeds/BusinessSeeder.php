<?php

use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        Business::truncate();

        Category::insert([
            ['name' => 'Men\'s Hair', 'is_service' => 1, 'is_product' => 1],
            ['name' => 'Women\'s Hair', 'is_service' => 1, 'is_product' => 1],
            ['name' => 'Face', 'is_service' => 0, 'is_product' => 1],
            ['name' => 'Massage', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Pedicure', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Manicure', 'is_service' => 1, 'is_product' => 0],
            ['name' => 'Spa', 'is_service' => 1, 'is_product' => 0],
        ]);

        $saloon = Category::create(['name' => 'Saloon', 'is_service' => 1, 'is_product' => 0]);
        $parlour = Category::create(['name' => 'Parlour', 'is_service' => 1, 'is_product' => 0]);
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
        $business->save();
    }
}
