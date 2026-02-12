<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 85; $i++) {
            Ticket::create([
                'reference_number' => 'KRX' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'is_used' => false,
            ]);
        }
    }
}
