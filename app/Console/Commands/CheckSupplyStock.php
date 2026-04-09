<?php

namespace App\Console\Commands;

use App\Models\RestockRequest;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Console\Command;

class CheckSupplyStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-supply-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the stock levels of all supplies and create restock requests if necessary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Define the threshold for restocking
         $restockThreshold = 100; // This can be adjusted as needed

         // Fetch all supplies
         $supplies = Supply::all();



         foreach ($supplies as $supply) {
             $quantityLeft = $supply->total_quantity;

             // Check if the quantity is below the threshold
             if ($quantityLeft < $restockThreshold) {
                 // Get an admin user for the location (or customize this based on your requirements)
                 $adminUser = User::where('role', 'admin')->where('location_id', $supply->location_id)->first();

                 if ($adminUser) {
                     // Create a restock request if below the threshold
                     RestockRequest::create([
                         'supply_id' => $supply->supply_id,
                         'user_id' => $adminUser->id, // Assume the admin is making the request
                         'quantity_left' => $quantityLeft,
                         'location_id' => $supply->location_id,
                     ]);

                     $this->info('Restock request created for supply: ' . $supply->name);
                 }
             }
         }

         $this->info('Stock check completed.');
    }
}
