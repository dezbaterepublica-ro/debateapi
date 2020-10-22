<?php
namespace Database\Seeders;

class CountiesCitiesSeeder extends OctavianParalescu\UatSeeder\UatSeeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        $table = 'counties';
        $mapping = [
            'countySirutaId' => 'id',
            'countyLabel' => 'name',
            'typesOfCountiesLabel' => 'type',
        ];

        $this->seed($table, $mapping);

        $table = 'cities';
        $mapping = [
            'countySirutaId' => 'county_id',
            'townLabel' => 'name',
            'typesOfTownsLabel' => 'type',
            'sirutaId' => 'id',
            'coords' => 'coords',
        ];
        $insertChunkSize = 500;
        $this->seed($table, $mapping, $insertChunkSize);

        $table = 'sate';
        $mapping = [
            'sateSirutaId' => 'id',
            'countySirutaId' => 'county_id',
            'sirutaId' => 'city_id',
            'sateLabel' => 'name',
            'sateCoords' => 'coords',
        ];

        $this->seed($table, $mapping, $insertChunkSize, true);
    }
}
