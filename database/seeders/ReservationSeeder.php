<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservations = [
            ['time_slot' => '10:00 AM', 'available_slots' => 58],
            ['time_slot' => '11:00 AM', 'available_slots' => 58],
            ['time_slot' => '12:00 PM', 'available_slots' => 58],
            ['time_slot' => '1:00 PM', 'available_slots' => 58],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
}
