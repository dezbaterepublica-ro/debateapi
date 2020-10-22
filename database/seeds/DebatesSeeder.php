<?php
namespace Database\Seeders;


use App\Authority;
use App\Debate;
use DateTime;
use Illuminate\Database\Seeder;

class DebatesSeeder extends Seeder
{
    public function run()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $authorities = Authority::inRandomOrder()
                                ->limit(10)
                                ->get();
        foreach ($authorities as $authority) {
            $debate = new Debate();
            $debate->title = 'Bugetul ' . $authority->name;
            $debate->slug = str_replace(' ', '-', strtolower($debate->title));
            $debate->start_date = new DateTime('-1 day');
            $debate->end_date = new DateTime('+100 day');
            $debate->description = 'Descriere pentru ' . $debate->title;
            $debate->url = $authority->website ?? null;
            $debate->authority()
                   ->associate($authority);
            $debate->save();
        }
    }
}
