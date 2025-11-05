<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TurtleNestFinding;
use App\Models\TurtleNestingLocation;
use Carbon\Carbon;

class TurtleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create penangkaran user
        $penangkaranUser = User::where('email', 'admin@penangkaran.com')->first();
        
        if (!$penangkaranUser) {
            $penangkaranUser = User::create([
                'username' => 'admin_penangkaran',
                'name' => 'Admin Penangkaran',
                'email' => 'admin@penangkaran.com',
                'password' => bcrypt('password'),
                'role' => 'penangkaran'
            ]);
        }

        // Sample Nest Findings (dari Excel DATA TELUR MENETAS 2024)
        $findings = [
            ['2024-03-19', null, 0, 'KARANGTAWANG', null, 0, 'taken_by_fisherman', 'Diambil nelayan'],
            ['2024-03-31', 'P1', 91, 'KARANGTAWANG', '2024-05-12', 0, 'monitoring', 'Monitoring penetasan'],
            ['2024-04-23', 'P2', 43, 'GLEMPANGPASIR', '2024-06-09', 0, 'monitoring', 'Monitoring penetasan'],
            ['2024-04-25', null, 0, 'PAGUBUGAN', null, 0, 'taken_by_fisherman', 'Diambil nelayan'],
            ['2024-04-26', 'P3', 96, 'PAGUBUGAN', '2024-06-13', 91, 'hatched', '94% sukses menetas'],
            ['2024-05-18', 'P4', 35, 'WELAHAN WETAN', '2024-07-04', 35, 'hatched', '100% sukses menetas'],
            ['2024-05-21', 'P5', 110, 'SIDAYU', '2024-07-07', 93, 'hatched', '84% sukses menetas'],
            ['2024-06-03', 'P6', 91, 'SIDAYU', '2024-07-20', 69, 'hatched', '75% sukses menetas'],
            ['2024-06-08', 'P7', 87, 'SIDAURIP', '2024-07-25', 37, 'hatched', '42% penetasan'],
            ['2024-06-08', null, 0, 'JETIS', null, 0, 'taken_by_fisherman', 'Diambil nelayan'],
            ['2024-06-09', 'P8', 85, 'SIDAURIP', '2024-07-25', 74, 'hatched', '87% sukses menetas'],
            ['2024-06-10', 'P9', 105, 'WELAHAN WETAN', '2024-07-26', 93, 'hatched', '88% sukses menetas'],
            ['2024-06-19', null, 106, 'WIDARAPAYUNG WETAN', null, 0, 'taken_by_fisherman', 'Diambil nelayan'],
            ['2024-06-19', 'P10', 78, 'SIDAYU', '2024-08-05', 66, 'hatched', '84% sukses menetas'],
            ['2024-06-20', 'P11', 150, 'WIDARAPAYUNG WETAN', '2024-08-06', 128, 'hatched', '85% sukses menetas'],
        ];

        foreach ($findings as $finding) {
            TurtleNestFinding::create([
                'user_id' => $penangkaranUser->id,
                'finding_date' => $finding[0],
                'nest_code' => $finding[1],
                'egg_count' => $finding[2],
                'location' => $finding[3],
                'estimated_hatching_date' => $finding[4],
                'hatched_count' => $finding[5],
                'hatching_percentage' => $finding[2] > 0 ? ($finding[5] / $finding[2]) * 100 : 0,
                'status' => $finding[6],
                'notes' => $finding[7],
            ]);
        }

        // Sample Nesting Locations (dari Excel DATA WILAYAH PENELURAN 2024)
        $locations = [
            'SODONG', 'SRANDIL', 'WELAHAN WETAN', 'WIDARAPAYUNG KULON', 
            'SIDAYU', 'WIDARAPAYUNG WETAN', 'SIDAURIP', 'PAGUBUGAN KULON', 
            'PAGUBUGAN', 'KARANGTAWANG', 'KARANGPAKIS', 'JETIS'
        ];

        // Data per bulan (simplified dari Excel)
        $monthlyData = [
            'Maret' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0],
            'April' => [0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0],
            'Mei' => [0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0],
            'Juni' => [1, 1, 2, 0, 4, 3, 2, 0, 1, 2, 1, 1],
            'Juli' => [1, 3, 4, 1, 3, 3, 3, 0, 2, 0, 0, 0],
            'Agustus' => [1, 1, 0, 0, 0, 1, 1, 0, 0, 1, 0, 0],
            'September' => [0, 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0],
        ];

        foreach ($monthlyData as $month => $counts) {
            foreach ($locations as $index => $location) {
                if ($counts[$index] > 0) {
                    TurtleNestingLocation::create([
                        'user_id' => $penangkaranUser->id,
                        'location_name' => $location,
                        'month' => $month,
                        'year' => 2024,
                        'nesting_count' => $counts[$index],
                    ]);
                }
            }
        }

        $this->command->info('✅ Turtle data seeded successfully!');
        $this->command->info('📊 Created ' . TurtleNestFinding::count() . ' nest findings');
        $this->command->info('📍 Created ' . TurtleNestingLocation::count() . ' location records');
    }
}
