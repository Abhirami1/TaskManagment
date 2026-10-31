<?php
namespace Database\Seeders;

use App\Models\{User, Task};
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'role_id' => 1,
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'status' => 'active',
        ]);

        $staff = collect(range(1, 5))->map(fn ($i) => User::create([
            'role_id' => 2,
            'name' => "Staff $i",
            'email' => "staff$i@example.com",
            'password' => 'password123',
            'status' => 'active',
        ]));

        foreach (range(1, 25) as $i) {
            Task::create([
                'title' => "Sample Task #$i",
                'description' => "Description for task $i",
                'status' => $i % 3 === 0 ? 'completed' : 'open',
                'assigned_to' => $staff->random()->id,
                'created_by' => $admin->id,
            ]);
        }
    }
}