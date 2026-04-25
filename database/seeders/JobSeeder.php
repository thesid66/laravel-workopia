<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // fetch job listings from the json file

        $jobListings = include database_path('seeders/data/job_listings.php');

        // get test user id
        $testUserID = User::where('email','test@test.com')->value('id');

        // get all other user ids from user model
        $userIds = User::where('email','!=','test@test.com')->pluck('id')->toArray();

        foreach ($jobListings as $index=> &$listing) {
            if($index < 2) {
                // Assign the first two listings to the test user
                $listing['user_id'] = $testUserID;
            }
            else {
            // Assign user id to the listing
            $listing['user_id'] = $userIds[array_rand($userIds)];
            }
            //Add timestamps
            $listing['created_at'] = now();
            $listing['updated_at'] = now();
        }

        // Insert JobListing

        DB::table('job_listings')->insert($jobListings);
        echo 'Jobs created successfully';
    }
}
