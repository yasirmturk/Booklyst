<?php

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Image::truncate();

        Image::insert([
            [
                'filename' => 'zCX6WUr5EQpktvfcKuHrul8Vyp3ljNUULjYCOAhk.jpeg',
                'url' => 'https://turklyst.s3.eu-west-2.amazonaws.com/images/zCX6WUr5EQpktvfcKuHrul8Vyp3ljNUULjYCOAhk.jpeg'
            ],
            [
                'filename' => '62BQfF7h3fOupC5m0V2hVrrqtFnFpqVEQwsqpROU.jpeg',
                'url' => 'https://turklyst.s3.eu-west-2.amazonaws.com/images/62BQfF7h3fOupC5m0V2hVrrqtFnFpqVEQwsqpROU.jpeg'
            ],
            [
                'filename' => 'JujLk1LlqQhnbsWKdlbjdHsbImENIQWszhWZtcqF.jpeg',
                'url' => 'https://turklyst.s3.eu-west-2.amazonaws.com/images/62BQfF7h3fOupC5m0V2hVrrqtFnFpqVEQwsqpROU.jpeg'
            ],
        ]);
    }
}
