<?php
namespace Database\Seeders;


use App\Authority;
use App\City;
use App\County;
use Illuminate\Database\Seeder;

class AuthoritiesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        $counties = County::all();
        foreach ($counties as $county) {
            $authority = new Authority();
            if ($county->type === 'diviziune administrativă de rangul întâi') {
                $authority->name = 'Consiliul General al Municipiului București';
            } else {
                $authority->name = 'Consiliul Județean ' . $county->name;
            }
            $authority->slug = str_replace(' ', '-', strtolower($authority->name));
            $authority->county()->associate($county);

            $authority->save();

            $authority = new Authority();
            if ($county->type === 'diviziune administrativă de rangul întâi') {
                $authority->name = 'Instituția Prefectului Municipiului București';
            } else {
                $authority->name = 'Institutia Prefectului județul ' . $county->name;
            }
            $authority->slug = str_replace(' ', '-', strtolower($authority->name));
            $authority->county()
                      ->associate($county);

            $authority->save();
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $cities = City::inRandomOrder()
                      ->limit(30)
                      ->get();
        foreach ($cities as $city) {
            $authority = new Authority();
            $authority->name = 'Consiliul Local ' . $city->name . ', ' . $city->county->name;
            $authority->slug = str_replace([' ', ','], ['-', ''], strtolower($authority->name));
            $authority->county()
                      ->associate($city->county);
            $authority->city()
                      ->associate($city);
            $authority->save();

            $authority = new Authority();
            $authority->name = 'Primăria ' . $city->name . ', ' . $city->county->name;
            $authority->slug = str_replace([' ', ','], ['-', ''], strtolower($authority->name));
            $authority->county()->associate($city->county);
            $authority->city()->associate($city);
            $authority->save();
        }
    }
}
