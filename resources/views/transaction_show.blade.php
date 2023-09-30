@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4>All Transaction</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderd">
                            <tr>
                                <th>Sl</th>
                                <th>Transcation Type</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Date</th>
                            </tr>
                            @forelse ($transactions as $key=>$transaction)
                            <tr>
                                <td>{{ $transactions->firstItem() + $key }}</td>
                                <td>{{($transaction->transaction_type==1?'Deposit':'Withdrwal')}}</td>
                                <td>{{$transaction->amount}}</td>
                                <td>{{$transaction->fee}}</td>
                                <td>{{$transaction->created_at}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">There are no Transaction.</td>
                            </tr>
                            @endforelse
                            
                        </table>
                        {!!$transactions!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection