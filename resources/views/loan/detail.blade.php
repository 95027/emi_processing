{{-- @extends('layouts.app')

@section('content')
@endsection --}}

<div class="container mx-auto p-4">

    <form method="POST" action="{{ route('loan.process') }}">
        @csrf
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Process Data</button>
    </form>

    @if(!empty($emis) && count($emis) > 0)
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Client ID</th>
                        @foreach ($emis[0] as $month => $value)
                            @if(!in_array($month, ['id', 'client_id', 'created_at', 'updated_at']))
                                <th class="border px-2 py-1">{{ $month }}</th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emis as $emi)
                        <tr>
                            <td class="border px-2 py-1">{{ $emi->client_id }}</td>
                            @foreach ($emi as $month => $value)
                                @if(!in_array($month, ['id', 'client_id', 'created_at', 'updated_at']))
                                    <td class="border px-2 py-1">{{ $value }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- <p class="mt-4 text-gray-600">No EMI data found. Click "Process Data" to generate.</p> --}}
    @endif

</div>

