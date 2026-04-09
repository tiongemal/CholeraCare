<?php

namespace App\Listeners;

use App\Events\CholeraReportSubmitted;
use App\Models\Supply;
use App\Models\SupplyUsed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateSuppliesTable
{


    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CholeraReportSubmitted $event)
    {
        $reportData = $event->reportData;

        // Define the supplies to be used for confirmed cases
        $suppliesUsed = [
            'Cholera Treatment' => $reportData['confirmed_cases'],
        ];

        foreach ($suppliesUsed as $supplyName => $quantityUsed) {
            $supply = Supply::where('supply_name', $supplyName)->first();

            if ($supply && $quantityUsed > 0) {
                SupplyUsed::create([
                    'report_id' => $reportData['report_id'],
                    'supply_id' => $supply->supply_id,
                    'quantity_used' => $quantityUsed,
                ]);

                // Decrement the total quantity in stock
                $supply->total_quantity -= $quantityUsed;
                $supply->save();
            }
        }
    }
}
