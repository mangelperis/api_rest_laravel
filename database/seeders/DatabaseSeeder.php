<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WorkEntry;
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
        $label = 'fake-name';
        $limit = 5;

        for ($i = 1; $i <= $limit; $i++) {
            $name = sprintf('%s-%d', $label,$i);
            $user = User::create(['name' => $name,
                'email' => sprintf('%s@%s', $name, 'gmail.com'),
            ]);

            WorkEntry::create([
                'user_id' => $user->id,
                'start_date' => new \DateTime('now'),
            ]);
        }
    }
}
