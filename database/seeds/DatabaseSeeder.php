<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('meta_keywords')->insert(
            ['name' => 'rock']
        );
        DB::table('meta_keywords')->insert(
            ['name' => 'raw']
        );
        DB::table('meta_keywords')->insert(
            ['name' => 'news']
        );
        DB::table('meta_keywords')->insert(
            ['name' => 'fight']
        );
        DB::table('meta_keywords')->insert(
            ['name' => 'trend']
        );

        DB::table('meta_locations')->insert(
            ['name' => 'miami']
        );
        DB::table('meta_locations')->insert(
            ['name' => 'nyc']
        );
        DB::table('meta_locations')->insert(
            ['name' => 'los angeles']
        );
        DB::table('meta_locations')->insert(
            ['name' => 'san francisco']
        );

        $this->command->info('WWE test app seeds finished.');
    }
}
