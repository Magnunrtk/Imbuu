<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\WebPaymentOption;
use App\Models\WebShopProduct;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        return view(
            'admin.store.products.index'
        );
    }

    public function list(): JsonResponse
    {
        $query = WebShopProduct::all();
        return Datatables::of($query)
            ->editColumn('value', function ($query) {
                return number_format((float) $query->value, $query->decimals);
            })
            ->addColumn('payment_option', function ($query) {
                return $query->payment->name;
            })
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d H:i');
            })
            ->make();
    }

    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'image.required' => 'You need to provide an image name!',
            'value.required' => 'You need to provide a value!',
            'decimals.required' => 'You need to provide a decimal value!',
            'coins.required' => 'You need to provide coins!',
            'decimals.min' => 'Decimal value can be between :min and :max',
            'decimals.max' => 'Decimal value can be between :min and :max',
            'payment_option.required' => 'Please select a payment option.',
            'payment_option.exists' => 'Please select a valid payment option.',
        ];
        $rules = [
            'image' => 'required',
            'value' => 'required',
            'coins' => 'required',
            'decimals' => 'required|min:0|max:10',
            'payment_option' => 'required|exists:web_payment_options,id',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()
                ->with('error', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $paymentOption = WebPaymentOption::find((int) $request->input('payment_option'));
        $data = [
            'image' => $request->input('image'),
            'value' => $request->input('value'),
            'coins' => $request->input('coins'),
            'prefix' => $request->input('prefix'),
            'suffix' => $request->input('suffix'),
            'payment_option_id' => $paymentOption->id,
            'decimals' => $request->input('decimals'),
            'active' => $request->has('active'),
        ];
        WebShopProduct::create($data);

        return Redirect::back()
            ->with('success', 'Product has been successfully added.');
    }

    public function info(Request $request): JsonResponse
    {
        return response()->json(
            WebShopProduct::find((int) $request->input('id'))
        );
    }

    public function update(Request $request): RedirectResponse
    {
        $messages = [
            'image.required' => 'You need to provide an image name!',
            'value.required' => 'You need to provide a value!',
            'decimals.required' => 'You need to provide a decimal value!',
            'coins.required' => 'You need to provide coins!',
            'decimals.min' => 'Decimal value can be between :min and :max',
            'decimals.max' => 'Decimal value can be between :min and :max',
            'payment_option.required' => 'Please select a payment option.',
            'payment_option.exists' => 'Please select a valid payment option.',
        ];
        $rules = [
            'image' => 'required',
            'value' => 'required',
            'coins' => 'required',
            'decimals' => 'required|min:0|max:10',
            'payment_option' => 'required|exists:web_payment_options,id',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()
                ->with('error', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $paymentOption = WebPaymentOption::find((int) $request->input('payment_option'));
        WebShopProduct::updateOrCreate(
            [
                'id' => (int) $request->input('product_id')
            ],
            [
                'image' => $request->input('image'),
                'value' => $request->input('value'),
                'coins' => $request->input('coins'),
                'prefix' => $request->input('prefix'),
                'suffix' => $request->input('suffix'),
                'payment_option_id' => $paymentOption->id,
                'decimals' => $request->input('decimals'),
                'active' => $request->has('active'),
            ]
        );
        return Redirect::back()
            ->with('success', 'Product has been successfully updated.');
    }
}
