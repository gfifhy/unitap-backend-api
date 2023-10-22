<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SchoolLocation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(SecurityGuardsTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(StudentGuardiansTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ViolationsTableSeeder::class);
        $this->call(WalletsTableSeeder::class);
        $this->call(SchoolLocationsTableSeeder::class);
    }
}
