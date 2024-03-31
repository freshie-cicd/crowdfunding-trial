<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $previousCodeToNewCode = [
            37221253 => 86753168,
            61839039 => 96413746,
            69510223 => 29129245,
            56228447 => 64596084,
        ];

        foreach ($previousCodeToNewCode as $previousCode => $newCode) {
            $previousPayment =  DB::table('booking_payments')
                ->where('code', $previousCode)
                ->join('bookings', 'bookings.id', '=', 'booking_payments.booking_id')
                ->select('booking_payments.*')
                ->first();

            $newPayment = DB::table('booking_payments')
                ->where('code', $newCode)
                ->join('bookings', 'bookings.id', '=', 'booking_payments.booking_id')
                ->select('booking_payments.*')
                ->first();
            $newBooking = DB::table('bookings')
                ->where('code', $newCode)
                ->select('bookings.*')
                ->first();

            if ($previousPayment && $newPayment) {
                echo "here\n";
                DB::table('booking_payments')
                    ->where('id', $newPayment->id)
                    ->update([
                        'payment_date' => $previousPayment->payment_date,
                        'payment_document' => $previousPayment->payment_document,
                        'document_two' => $previousPayment->document_two,
                        'document_three' => $previousPayment->document_three,
                        'bank' => $previousPayment->bank,
                        'branch' => $previousPayment->branch,
                        'depositors_name' => $previousPayment->depositors_name,
                        'depositors_mobile_number' => $previousPayment->depositors_mobile_number,
                        'booking_id' => $newBooking->id,
                        'payment_method' => 'migration',
                        'deposit_reference' => "Previous Payment ID:" . $previousPayment->id . " and Booking ID: " .  $previousCode . " migrated from Batch 4 to Batch 6",
                        'status' => 'complete',
                    ]);
            } else {
                DB::table('booking_payments')
                    ->insert([
                        'booking_id' => $newBooking->id,
                        'payment_date' => $previousPayment->payment_date,
                        'payment_document' => $previousPayment->payment_document,
                        'document_two' => $previousPayment->document_two,
                        'document_three' => $previousPayment->document_three,
                        'bank' => $previousPayment->bank,
                        'branch' => $previousPayment->branch,
                        'depositors_name' => $previousPayment->depositors_name,
                        'depositors_mobile_number' => $previousPayment->depositors_mobile_number,
                        'payment_method' => 'migration',
                        'deposit_reference' => "Previous Payment ID:" . $previousPayment->id . " and Booking ID: " .  $previousCode . " migrated from Batch 4 to Batch 6",
                        'status' => 'complete',
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to rollback
    }
};
