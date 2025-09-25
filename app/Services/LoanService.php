<?php

namespace App\Services;

use App\Repositories\LoanRepository;

class LoanService
{
    protected $loanRepo;

    public function __construct(LoanRepository $loanRepo)
    {
        $this->loanRepo = $loanRepo;
    }

    public function getAllLoans()
    {
        return $this->loanRepo->all();
    }

    public function getEmis()
    {
        return $this->loanRepo->findEmis();
    }

    public function processEmi()
    {
        return $this->loanRepo->processEmi();
    }
}
