<?php

namespace Database\Seeders;

use App\Models\Lease;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leases = Lease::where('status', 'active')->get();

        if ($leases->isEmpty()) {
            $this->command->info('No active leases found. Please run LeaseSeeder first.');
            return;
        }

        $paymentMethods = ['bank_transfer', 'credit_card', 'cash', 'check', 'online_payment'];
        $paymentStatuses = ['completed', 'pending', 'failed', 'refunded'];

        foreach ($leases as $lease) {
            // Create payment history for each lease
            $this->createPaymentsForLease($lease, $paymentMethods, $paymentStatuses);
        }
    }

    /**
     * Create payments for a specific lease
     */
    private function createPaymentsForLease($lease, array $paymentMethods, array $paymentStatuses): void
    {
        $rentAmount = $lease->rent_amount;
        $startDate = Carbon::parse($lease->start_date);
        $endDate = Carbon::now()->isAfter(Carbon::parse($lease->end_date)) 
            ? Carbon::parse($lease->end_date) 
            : Carbon::now();

        // Generate monthly payments from start date to now
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            // Skip some months randomly to create variety (late payments, etc.)
            if (rand(1, 10) > 2) {
                $paymentDate = $currentDate->copy()->addDays(rand(-3, 5));
                
                // Determine payment status
                $status = $this->determinePaymentStatus($paymentDate);
                
                // If payment is pending, don't add payment_date
                $actualPaymentDate = $status === 'pending' ? null : $paymentDate;

                // Add some variance to amount (late fees, discounts)
                $amount = $rentAmount;
                if ($status === 'failed') {
                    // Failed payments might have different amounts
                    $amount = $rentAmount + rand(0, 50);
                }

                Payment::create([
                    'tenant_id' => $lease->tenant_id,
                    'lease_id' => $lease->id,
                    'amount' => $amount,
                    'payment_date' => $actualPaymentDate,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'status' => $status,
                ]);
            }

            // Move to next month
            $currentDate->addMonth();
        }

        // Add some pending future payments
        $this->createPendingPayments($lease, $paymentMethods);
    }

    /**
     * Determine payment status based on payment date
     */
    private function determinePaymentStatus(Carbon $paymentDate): string
    {
        $today = Carbon::now();

        if ($paymentDate->isAfter($today)) {
            return 'pending';
        }

        // For past payments, mostly completed with some failures
        $random = rand(1, 100);

        if ($random <= 85) {
            return 'completed';
        } elseif ($random <= 93) {
            return 'pending';
        } elseif ($random <= 97) {
            return 'failed';
        } else {
            return 'refunded';
        }
    }

    /**
     * Create pending future payments
     */
    private function createPendingPayments($lease, array $paymentMethods): void
    {
        // Add 1-2 pending payments for current and next month
        $pendingCount = rand(1, 2);
        $currentDate = Carbon::now();

        for ($i = 0; $i < $pendingCount; $i++) {
            $dueDate = $currentDate->copy()->addMonths($i + 1)->startOfMonth()->addDays(rand(0, 5));

            // Only create if within lease period
            if (Carbon::parse($lease->end_date)->isAfter($dueDate)) {
                Payment::create([
                    'tenant_id' => $lease->tenant_id,
                    'lease_id' => $lease->id,
                    'amount' => $lease->rent_amount,
                    'payment_date' => null,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'status' => 'pending',
                ]);
            }
        }
    }
}
