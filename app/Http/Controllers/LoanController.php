<?php

namespace App\Http\Controllers;

use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index()
    {
        $data['loans'] = $this->loanService->getAllLoans();
        return view('loan.index', $data);
    }

    public function loanDetail()
    {
        $data['emis'] = $this->loanService->getEmis();
        return view('loan.detail', $data);
    }


    public function processEmi()
    {
        $this->loanService->processEmi();
        return redirect()->back()->with('success', 'EMI processed successfully....!');
    }
}
