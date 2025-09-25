{{-- @extends('layouts.app')

@section('content')

@endsection --}}

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Loans List</h1>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Client ID</th>
                    <th class="border px-4 py-2">Loan Amount</th>
                    <th class="border px-4 py-2">Payments</th>
                    <th class="border px-4 py-2">Start Date</th>
                    <th class="border px-4 py-2">End Date</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <td class="border px-4 py-2">{{ $loan->clientid }}</td>
                        <td class="border px-4 py-2">{{ $loan->loan_amount }}</td>
                        <td class="border px-4 py-2">{{ $loan->num_of_payment }}</td>
                        <td class="border px-4 py-2">{{ $loan->first_payment_date }}</td>
                        <td class="border px-4 py-2">{{ $loan->last_payment_date }}</td>
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('loan.detail') }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
