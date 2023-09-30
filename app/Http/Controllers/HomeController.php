<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

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
        $message = array(
            'message' => 'Amount Deposit Successfully.!',
            'type' => 'success',
        );
        return back()->with($message);
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
        // return $request->all();
        $request->validate([
            'amount' => 'required'
        ]);
        $user  = User::where('id', $request->user_id)->first();
        if ($user->account_type == 1) {
            $today = Carbon::now();
            $currentMonth = $today->month;
            $currentYear = $today->year;
            $startDate = Carbon::create($currentYear, $currentMonth, 1, 0, 0, 0)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
            $totalWithdrawal = DB::table('transactions')->where('user_id', Auth::user()->id)
                ->where('transaction_type', '2')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
            if ($today->dayOfWeek === Carbon::FRIDAY) {
                $fee = 0;
            } else {
                if ($totalWithdrawal > 5000) {
                    if ($request->amount > 1000) {
                        $reamining_amount = $request->amount - 1000;
                        $fee =  (0.015 * $reamining_amount) / 100;
                    } else {
                        $fee = 0;
                    }
                } else {
                    $fee = 0;
                }
            }
            $total_withdral_amount = $request->amount + $fee;
            if ($total_withdral_amount <= $user->balance) {
                $current_amount =  $user->balance - $total_withdral_amount;
                Transactions::insert([
                    'user_id' => Auth::user()->id,
                    'transaction_type' => 2,
                    'amount' => $request->amount,
                    'fee' => $fee,
                    'remaining_amount' => $current_amount,
                    'created_at' => Carbon::now(),
                ]);
                $new_amount = $user->balance - $total_withdral_amount;
                User::where('id', $request->user_id)->update([
                    'balance' => $new_amount,
                    'updated_at' => Carbon::now(),
                ]);
                $message = array(
                    'message' => 'Amount Withdrwal Successfully.!',
                    'type' => 'success',
                );
                return back()->with($message);
            } else {
                $message  = [
                    'type' => 'error',
                    'message' => 'Insufficient Balance'
                ];
                return back()->with($message);
            }
        } else {
            $today = Carbon::now();
            $currentMonth = $today->month;
            $currentYear = $today->year;
            $startDate = Carbon::create($currentYear, $currentMonth, 1, 0, 0, 0)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
            $totalWithdrawal = DB::table('transactions')->where('user_id', Auth::user()->id)
                ->where('transaction_type', '2')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
            if ($totalWithdrawal < 50000) {
                $fee =  (0.015 * $request->amount) / 100;
            } else {
                $fee =  (0.025 * $request->amount) / 100;
            }
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
                $message = array(
                    'message' => 'Amount Withdrwal Successfully.!',
                    'type' => 'success',
                );
            } else {
                $message  = [
                    'type' => 'error',
                    'message' => 'Insufficient Balance'
                ];
                return back()->with($message);
            }
        }
    }
}
