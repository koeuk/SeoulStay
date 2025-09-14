<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use App\Models\Areas;
use App\Models\ItemType;
use App\Models\Amenities;
use App\Models\Attractions;
use App\Models\Items;
use App\Models\ItemAmenities;
use App\Models\ItemAttractions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed base data first (independent tables)
        $userTypes = UserType::factory(4)->create();
        $areas = Areas::factory(4)->create();
        $itemTypes = ItemType::factory(4)->create();
        $amenities = Amenities::factory(4)->create();
        $attractions = Attractions::factory(4)->create();

        // Seed users with relationships
        $users = User::factory(4)->create();

        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'koeuk@gmail.com'],
            [
                'uuid' => Str::uuid(),
                'name' => 'Koeuk',
                'full_name' => 'Koeuk Admin',
                'username' => 'koeuk.admin',
                'password' => '12345678',
                'user_type_id' => $userTypes->where('name', 'Administrator')->first()?->id ?? $userTypes->first()->id,
                'gender' => 'Male',
                'birth_date' => '1990-01-01',
                'family_count' => 1,
                'email_verified_at' => now(),
            ]
        );

        // Seed items (properties) with relationships
        $items = Items::factory(20)->create();

        // Seed pivot table relationships
        // Each item gets 2-4 random amenities (max available is 4)
        foreach ($items as $item) {
            $randomAmenities = $amenities->random(rand(2, min(4, $amenities->count())));
            foreach ($randomAmenities as $amenity) {
                ItemAmenities::factory()->create([
                    'item_id' => $item->id,
                    'amenity_id' => $amenity->id,
                ]);
            }
        }

        // Each item gets 2-4 nearby attractions (max available is 4)
        foreach ($items as $item) {
            $randomAttractions = $attractions->random(rand(2, min(4, $attractions->count())));
            foreach ($randomAttractions as $attraction) {
                ItemAttractions::factory()->create([
                    'item_id' => $item->id,
                    'attraction_id' => $attraction->id,
                ]);
            }
        }
    }
}