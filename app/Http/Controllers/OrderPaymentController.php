<?php

namespace App\Http\Controllers;

use App\Enums\App;
use App\Models\CustomerPayment;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Prefix;
use App\Models\Sale\SaleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderPaymentController extends Controller
{
    protected $companyId;

    public function __construct()
    {
        $this->companyId = App::APP_SETTINGS_RECORD_ID->value;
    }

    public function getLastCountId(){
        return Order::select('count_id')->orderBy('id', 'desc')->first()?->count_id ?? 0;
    }

    public function create()
    {
        $prefix = Prefix::findOrNew($this->companyId);
        $categories = DB::table('party_categories')->where('status', 1)->pluck('name', 'id');
        $lastCountId = $this->getLastCountId();
        $data = [
            'prefix_code' => $prefix->order,
            'count_id' => ($lastCountId+1),
        ];
        $customers = DB::table('parties')->where('party_type','customer')->where('status',1)->get();
        
        return view('order_payments.create',compact('data','categories','customers'));
    }

    // public function getCustomerOrders(Request $request)
    // {
    //     $customerId = $request->customer_id;

    //     $orders = SaleOrder::where('party_id', $customerId)
            
    //         ->get();

    //     // You can return a Blade partial or raw HTML
    //     // return view('partials.customer_orders', compact('orders'));

    //     return response()->json([
    //         'html' => view('order_payments.partials.customer_orders', compact('orders'))->render(),
    //         'orders' => $orders,
    //     ]);



    // }


    public function getCustomerOrders(Request $request)
    {
        $customerId = $request->customer_id;

        // Fetch customer orders
        $orders = SaleOrder::with('item')->where('party_id', $customerId)->get();

        // Total order amount
        $totalOrders = $orders->sum('grand_total');

        // Total paid from payments table
        $totalPaid = CustomerPayment::where('party_id', $customerId)->sum('paid_amount');

        // Remaining
        $remaining = $totalOrders - $totalPaid;

        return response()->json([
            'html' => view('order_payments.partials.customer_orders', compact('orders', 'totalOrders', 'totalPaid', 'remaining'))->render(),
            'orders' => $orders,
        ]);
    }


    // public function CustomerOrdersPaymentStore(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate()
    // }


    public function CustomerOrdersPaymentStore(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'party_id' => 'required|exists:parties,id',
            'amount' => 'required|numeric',
            'payment_type_id' => 'required',
            'payment_note' => 'nullable|string|max:255',
            'payment_date' => 'required',
        ]);


        // Proceed to save the payment
       

    // Get all active orders for this customer
    $orders = SaleOrder::where('party_id', $validated['party_id'])->get();

    // Sum total due from orders
    $totalAmount = $orders->sum('grand_total');

    // Sum total paid so far by the customer
    $totalPaid = CustomerPayment::where('party_id', $validated['party_id'])->sum('amount');

    // Add current payment to total paid
    $newTotalPaid = $totalPaid + $validated['amount'];

    // Calculate remaining
    $remainingAmount = max($totalAmount - $newTotalPaid, 0);

    // Save payment
    $payment = CustomerPayment::create([
        'party_id' => $validated['party_id'],
        'amount' => $validated['amount'],
        'payment_type' => $validated['payment_type_id'], // adjust key name if needed
        'total_amount' => $totalAmount,
        'paid_amount' => $newTotalPaid,
        'remainig_amount' => $remainingAmount,
        'payment_note' => $validated['payment_note'],
        'payment_date' => $validated['payment_date'],
    ]);

    return redirect()->back()->with('success', 'Payment recorded successfully.');

    }

}
