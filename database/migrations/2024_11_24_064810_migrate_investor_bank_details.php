<?php

use App\Models\InvestorBankDetail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Load JSON data
        $json = File::get(database_path('data/routing_numbers_bd.json'));
        $data = json_decode($json, true);

        // Check if the root key is present
        if (!isset($data['Routing number of All Bank in B'])) {
            dd('Data format is not as expected.');
        }

        // Access the array under the root key
        $banks = $data['Routing number of All Bank in B'];

        $routingNumbers = [];

        foreach ($banks as $item) {
            // Extract only the required fields and map 'Location' to 'district'
            $routingNumbers[] = [
                'routing_number' => $item['Routing Number'] ?? null,
                'bank' => $item['Bank Name'] ?? null,
                'branch' => $item['Branch Name'] ?? null,
                'district' => $item['Location'] ?? null,
            ];
        }

        // Remove any entries where 'routing_number' is null (optional)
        $routingNumbers = array_filter($routingNumbers, function ($item) {
            return null !== $item['routing_number'];
        });

        // Insert data into the database in chunks to handle large datasets
        foreach (array_chunk($routingNumbers, 500) as $chunk) {
            DB::table('routing_numbers')->insert($chunk);
        }

        DB::table('investor_bank_details')
            ->update([
                'routing_number' => DB::raw("REPLACE(REPLACE(REPLACE(routing_number, ' ', ''), '-', ''), '.', '')"),
            ]);

        $investorBankDetails = DB::table('investor_bank_details')->get();

        try {
            DB::beginTransaction();

            foreach ($investorBankDetails as $details) {
                $routingInfo = DB::table('routing_numbers')
                    ->where('routing_number', $details->routing_number)->first();

                if (!empty($routingInfo)) {
                    DB::table('investor_bank_details')
                        ->where('id', $details->id)
                        ->update([
                            'bank_name' => $routingInfo->bank,
                            'branch_name' => $routingInfo->branch,
                            'district' => $routingInfo->district,
                        ]);
                } else {
                    InvestorBankDetail::where('id', $details->id)
                        ->delete();
                }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down() {}
};
