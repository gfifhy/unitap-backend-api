<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            ['id' => Str::uuid(), 'user_id' => '974c1f8d-dece-4a60-9453-e34e4781b429', 'guardian_id' =>  'd25d089a-a682-466e-a631-73f6ee1d4c27', 'location_id' => '231eeaaa-28a5-409e-b1f4-e5c2f27b93fc', 'contact_number' => '09384657482', 'student_id' => 'K11831246'],
        ]);
    }
}
