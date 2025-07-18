<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Run all seeders
        echo "Running database seeders...\n";
        
        $this->call('UserSeeder');
        
        echo "All seeders completed successfully!\n";
    }
}
