<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->seedOauthClients();

        $this->call(ImageSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BusinessSeeder::class);

        Schema::enableForeignKeyConstraints();
    }

    private function seedOauthClients()
    {
        $datetime = Carbon::now();
        $clients = [
            [
                'id' => '90dd4658-148b-4c33-b3c5-e91bba3d86dc',
                'secret' => 'xpS8X7QaCueEidQ3ktsYTpVPyhLmVFse4hFQUR5R',
                'name' => 'Turkly PAC',
                'personal_access_client' => true,
                'password_client' => false,
                'provider' => null,
                'redirect' => 'http://localhost',
                'revoked' => false,
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => '90dd476f-b75d-4d61-bfa6-628650698ae7',
                'secret' => '3IgbfCZFZbnwDmh91VpbXQn30M40M2E4VCrsmXLa',
                'name' => 'Turkly PGC',
                'personal_access_client' => false,
                'password_client' => true,
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'revoked' => false,
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
        ];
        DB::table('oauth_clients')->delete();
        DB::table('oauth_clients')->insert($clients);
    }
}
