<?php

namespace App\Repositories;

use App\Models\LoanDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LoanRepository
{
    protected $model;

    public function __construct(LoanDetail $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findEmis()
    {
        if (!Schema::hasTable('emi_details')) {
            return collect();
        }

        return DB::select('SELECT * FROM emi_details');
    }


    public function processEmi()
    {
        $loans = $this->model->all();

        if ($loans->isEmpty()) {
            return;
        }

        $minDate = $this->model->min('first_payment_date');
        $maxDate = $this->model->max('last_payment_date');

        $months = [];
        $current = Carbon::parse($minDate)->startOfMonth();
        $end = Carbon::parse($maxDate)->startOfMonth();

        while ($current <= $end) {
            $months[] = $current->format('Y_M');
            $current->addMonth();
        }

        DB::statement("DROP TABLE IF EXISTS emi_details");

        $sql = "CREATE TABLE emi_details (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                client_id BIGINT UNSIGNED NOT NULL,";
        foreach ($months as $month) {
            $sql .= "`$month` DECIMAL(10,2) DEFAULT 0,";
        }
        $sql .= "created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        DB::statement($sql);

        foreach ($loans as $loan) {
            $emi = $loan->loan_amount / $loan->num_of_payment;

            $row = [
                'client_id' => $loan->clientid,
            ];

            $firstMonth = Carbon::parse($loan->first_payment_date)->startOfMonth();
            $lastMonth = Carbon::parse($loan->last_payment_date)->startOfMonth();

            $monthsRange = [];
            $temp = $firstMonth->copy();
            while ($temp <= $lastMonth) {
                $monthsRange[] = $temp->format('Y_M');
                $temp->addMonth();
            }

            $emiTotal = 0;
            $count = 0;
            foreach ($monthsRange as $month) {
                $count++;
                if ($count < $loan->num_of_payment) {
                    $row[$month] = round($emi, 2);
                    $emiTotal += $row[$month];
                } else {
                    $row[$month] = $loan->loan_amount - $emiTotal;
                }
            }

            $columns = implode(',', array_map(fn($col) => "`$col`", array_keys($row)));
            $values = implode(',', array_map(fn($val) => is_numeric($val) ? $val : "'$val'", array_values($row)));

            DB::statement("INSERT INTO emi_details ($columns) VALUES ($values)");
        }
    }
}
