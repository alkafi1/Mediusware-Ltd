<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function deposit()
    {
        $transactions = Transactions::where('user_id', Auth::user()->id)->where('transaction_type', 1)->paginate(10);
        return view('deposit', [
            'transactions' => $transactions,
        ]);
    }
    public function deposit_store(Request $request)
    {
        // return $request->user_id;
        $request->validate([
            'amount' => 'required'
        ]);

        Transactions::insert([
            'user_id' => Auth::user()->id,
            'transaction_type' => 1,
            'amount' => $request->amount,
            'fee' => 0,
            'created_at' => Carbon::now(),
        ]);
        $old_amount  = User::where('id', $request->user_id)->first();
        $new_amount = $old_amount->balance + $request->amount;
        User::where('id', $request->user_id)->update([
            'balance' => $new_amount,
            'updated_at' => Carbon::now(),
        ]);
        return back();
    }
    public function transaction_show()
    {
        $transactions = Transactions::where('user_id', Auth::user()->id)->paginate(10);
        return view('transaction_show', [
            'transactions' => $transactions,
        ]);
    }

    public function withdrawl()
    {
        $transactions = Transactions::where('user_id', Auth::user()->id)->where('transaction_type', 2)->paginate(10);
        return view('withdrawl', [
            'transactions' => $transactions,
        ]);
    }
    public function widthdral_store(Request $request)
    {
        // return $request->user_id;
        $request->validate([
            'amount' => 'required'
        ]);
        $user  = User::where('id', $request->user_id)->first();
        if ($user->account_type == 1) {
            $fee = (0.015 * $request->amount) / 100;
            $total_withdral_amount = $request->amount + $fee;
            if ($total_withdral_amount <= $user->balance) {
                Transactions::insert([
                    'user_id' => Auth::user()->id,
                    'transaction_type' => 2,
                    'amount' => $request->amount,
                    'fee' => $fee,
                    'created_at' => Carbon::now(),
                ]);
                $new_amount = $user->balance - $total_withdral_amount;
                User::where('id', $request->user_id)->update([
                    'balance' => $new_amount,
                    'updated_at' => Carbon::now(),
                ]);
                return 'success';
            } else {
                $notification  = [
                    'type' => 'error',
                    'message' => 'Insufficient Balance'
                ];
                return back()->with($notification);
            }
        } else {
            $fee = (0.025 * $request->amount) / 100;
            $total_withdral_amount = $request->amount + $fee;
            if ($total_withdral_amount <= $user->balance) {
                Transactions::insert([
                    'user_id' => Auth::user()->id,
                    'transaction_type' => 2,
                    'amount' => $request->amount,
                    'fee' => $fee,
                    'created_at' => Carbon::now(),
                ]);
                $new_amount = $user->balance - $total_withdral_amount;
                User::where('id', $request->user_id)->update([
                    'balance' => $new_amount,
                    'updated_at' => Carbon::now(),
                ]);
                return 'success';
            } else {
                $notification  = [
                    'type' => 'error',
                    'message' => 'Insufficient Balance'
                ];
                return back()->with($notification);
            }
        }
    }
}
