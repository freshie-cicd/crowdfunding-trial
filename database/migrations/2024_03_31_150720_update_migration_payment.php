<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // mapping
        $paymentToCodeMap = [
            '75715698' => 1166,
            '14295698' => 1167,
            '39928575' => 1168,
            '40824428' => 1169,
            '80835783' => 1170,
            '69464484' => 1171,
            '82922304' => 1172,
            '65537935' => 1173,
            '99878374' => 1174,
            '22595709' => 1175,
            '80430067' => 1176,
            '83047773' => 1177,
            '97395757' => 1178,
            '63961453' => 1179,
            '74104207' => 1180,
            '12829088' => 1181,
            '28226975' => 1182,
            '30051966' => 1183,
            '29906720' => 1185,
            '85980176' => 1186,
            '97012664' => 1187,
            '17649957' => 1188,
            '30960004' => 1189,
            '70096251' => 1190,
            '29761066' => 1191,
            '86560314' => 1193,
            '83047773' => 1195,
            '73070258' => 1196,
        ];

        foreach ($paymentToCodeMap as $code => $paymentId) {
            $previousPayment = DB::table('booking_payments')
                ->join('bookings', 'booking_payments.booking_id', '=', 'bookings.id')
                ->where('bookings.code', '=', $code)
                ->select('booking_payments.*')
                ->first();

            if ($paymentId) {
                DB::table('booking_payments')
                    ->where('id', $paymentId)
                    ->update([
                        'payment_date' => $previousPayment->payment_date,
                        'payment_document' => $previousPayment->payment_document,
                        'document_two' => $previousPayment->document_two,
                        'document_three' => $previousPayment->document_three,
                        'bank' => $previousPayment->bank,
                        'branch' => $previousPayment->branch,
                        'depositors_name' => $previousPayment->depositors_name,
                        'depositors_mobile_number' => $previousPayment->depositors_mobile_number,
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}

    private function extractBookingIDs($text)
    {
        // Define the regular expression pattern to match 8-digit numbers
        $pattern = '/\b\d{8}\b/';

        // Use preg_match_all to find all matches
        preg_match_all($pattern, $text, $matches);

        // $matches[0] will contain all matched 8-digit numbers
        return $matches[0];
    }
};
