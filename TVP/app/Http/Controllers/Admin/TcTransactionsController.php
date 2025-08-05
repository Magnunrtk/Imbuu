<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebManualTransaction;
use App\Models\WebPaymentOption;
use App\Utils\TransactionStatus;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class TcTransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        return view(
            'admin.transactions.tibia-coins.index'
        );
    }

    public function list(): JsonResponse
    {
        $paymentOption = WebPaymentOption::whereName('Tibia Coins')->first();
        $query = WebManualTransaction::whereStatus(0)->wherePaymentOptionId($paymentOption->id)->get();
        return Datatables::of($query)
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d H:i');
            })->make();
    }

    public function action(Request $request): JsonResponse
    {
        $messages = [
            'id.required' => 'Please select a valid transaction.',
            'id.exists' => 'This transaction does not exists.',
            'type.required' => 'This action is not allowed.',
            'type.in' => 'This action is not allowed.',
        ];
        $rules = [
            'id' => 'required|exists:web_manual_transactions,id',
            'type' => 'required|in:approve,reject',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => preg_replace('/\s+/', ' ', $validator->errors()->first())
                ]
            );
        }
        $transaction = WebManualTransaction::find((int) $request->input('id'));
        return match($request->input('type')) {
            'approve' => $this->approve($transaction),
            'reject' =>  $this->reject($transaction),
        };
    }

    private function approve(WebManualTransaction $transaction): JsonResponse
    {
        $transaction->status = TransactionStatus::APPROVE;
        $transaction->save();
        $transaction->webAccount->shop_coins = $transaction->webAccount->shop_coins + $transaction->coins;
        $transaction->webAccount->save();
        return response()->json(
            [
                'success' => true,
                'type' => 'success',
                'title' => 'Done!',
                'message' => 'The transaction has been successfully approved.'
            ]
        );
    }

    private function reject(WebManualTransaction $transaction): JsonResponse
    {
        $transaction->status = TransactionStatus::REJECT;
        $transaction->save();
        return response()->json(
            [
                'success' => true,
                'type' => 'success',
                'title' => 'Done!',
                'message' => 'The transaction has been successfully rejected.'
            ]
        );
    }
}
