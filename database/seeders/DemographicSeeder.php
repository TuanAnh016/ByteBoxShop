<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class DemographicSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $genders = ['male', 'female', 'other'];
        
        foreach ($users as $index => $user) {
            // Assign some random-ish but deterministic data
            $user->update([
                'gender' => $genders[$index % 3],
                'date_of_birth' => Carbon::now()->subYears(20 + ($index * 5))->subDays($index * 10),
            ]);
        }
    }
}
