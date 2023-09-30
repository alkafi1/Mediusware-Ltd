@extends('layouts.app')


@section('content')
    <div class="container">
        
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModal">+ Amount
                                Deposit</button> --}}
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#categoryModal">
                                + Amount
                                Deposit
                            </button>
                        </ol>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title ">All Deposit Transaction</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-borderd">
                                    <tr>
                                        <th>Sl</th>
                                        <th>Transcation Type</th>
                                        <th>Amount</th>
                                        <th>Fee</th>
                                        <th>Current Amount</th>
                                        <th>Date</th>
                                    </tr>
                                    @forelse ($transactions as $key=>$transaction)
                                        <tr>
                                            <td>{{ $transactions->firstItem() + $key }}</td>
                                            <td>{{ $transaction->transaction_type == 1 ? 'Deposit' : 'Withdrwal' }}</td>
                                            <td>{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->fee }}</td>
                                            <td>{{ $transaction->remaining_amount }}</td>
                                            <td>{{ $transaction->created_at }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">There are no Transaction.</td>
                                        </tr>
                                    @endforelse

                                </table>
                                {!! $transactions !!}
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ route('deposit.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <label class="mb-3" for="name">Name</label>
                                    <input class="form-control" readonly type="text" name="name"
                                        value="{{ Auth::user()->name }}" />
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <label class="mb-3" for="name">Email</label>
                                    <input class="form-control" readonly type="email" name="email"
                                        value="{{ Auth::user()->email }}" />
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <label class="mb-3" for="name">Amount</label>
                                    <input class="form-control" type="float" name="amount" value=""
                                        placeholder="Enter Your Deposit Amount" />
                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    {{-- <button class="btn btn-success">Deposit</button> --}}
                                </div>
                            </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
