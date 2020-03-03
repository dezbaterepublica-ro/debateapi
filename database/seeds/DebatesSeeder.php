<?php


class DebatesSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $authorities = \App\Authority::inRandomOrder()->limit(10)->get();
        foreach ($authorities as $authority) {
            $debate = new \App\Debate();
            $debate->title = 'Bugetul ' . $authority->name;
            $debate->slug = str_replace(' ', '-', strtolower($debate->title));
            $debate->start_date = new \DateTime('-1 day');
            $debate->end_date = new \DateTime('+100 day');
            $debate->description = 'Descriere pentru ' . $debate->title;
            $debate->url = $authority->website ?? null;
            $debate->authority()->associate($authority);
            $debate->save();
        }
    }
}
