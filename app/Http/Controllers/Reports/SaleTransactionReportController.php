<?php

namespace App\Http\Controllers\Reports;

use App\Traits\FormatNumber; 
use App\Traits\FormatsDateInputs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Models\Items\ItemTransaction;
// use App\Models\Items\ItemBatchTransaction;
// use App\Models\Items\ItemSerialTransaction;
use App\Models\Sale\Sale;
use App\Enums\ItemTransactionUniqueCode;
use App\Models\Sale\SaleOrder;
use Carbon\Carbon;

class SaleTransactionReportController extends Controller
{
    use FormatsDateInputs;

    use FormatNumber;

    // public function getSaleRecords(Request $request) : JsonResponse{
    //     try{
    //         // Validation rules
    //         $rules = [
    //             'from_date'         => ['required', 'date_format:'.implode(',', $this->getDateFormats())],
    //             'to_date'           => ['required', 'date_format:'.implode(',', $this->getDateFormats())],
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             throw new \Exception($validator->errors()->first());
    //         }

    //         $fromDate           = $request->input('from_date');
    //         $fromDate           = $this->toSystemDateFormat($fromDate);
    //         $toDate             = $request->input('to_date');
    //         $toDate             = $this->toSystemDateFormat($toDate);
    //         $partyId             = $request->input('party_id');

    //         $preparedData = Sale::with('party')
    //                                             ->when($partyId, function ($query) use ($partyId) {
    //                                                 return $query->where('party_id', $partyId);
    //                                             })
    //                                             ->whereBetween('sale_date', [$fromDate, $toDate])
    //                                             ->get();

            
    //         if($preparedData->count() == 0){
    //             throw new \Exception('No Records Found!!');
    //         }

    //         $recordsArray = [];

    //         foreach ($preparedData as $data) {
    //             $recordsArray[] = [  
    //                                 'sale_date'         => $this->toUserDateFormat($data->sale_date),
    //                                 'invoice_or_bill_code'  => $data->sale_code,
    //                                 'party_name'            => $data->party->getFullName(),
    //                                 'grand_total'           => $this->formatWithPrecision($data->grand_total, comma:false),
    //                                 'paid_amount'           => $this->formatWithPrecision($data->paid_amount, comma:false),
    //                                 'balance'               => $this->formatWithPrecision($data->grand_total - $data->paid_amount , comma:false),
    //                             ];
    //         }
            
    //         return response()->json([
    //                     'status'    => true,
    //                     'message' => "Records are retrieved!!",
    //                     'data' => $recordsArray,
    //                 ]);
    //     } catch (\Exception $e) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => $e->getMessage(),
    //             ], 409);

    //     }
    // }



    // public function getSaleRecords(Request $request) : JsonResponse{
    //     try{
    //         // Validation rules
    //         $rules = [
    //             'from_date'         => ['required', 'date_format:'.implode(',', $this->getDateFormats())],
    //             'to_date'           => ['required', 'date_format:'.implode(',', $this->getDateFormats())],
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             throw new \Exception($validator->errors()->first());
    //         }

    //         $fromDate           = $request->input('from_date');
    //         $fromDate           = $this->toSystemDateFormat($fromDate);
    //         $toDate             = $request->input('to_date');
    //         $toDate             = $this->toSystemDateFormat($toDate);
    //         $partyId             = $request->input('party_id');

    //         $preparedData = SaleOrder::with('party')
    //                                             ->when($partyId, function ($query) use ($partyId) {
    //                                                 return $query->where('party_id', $partyId);
    //                                             })
    //                                             ->whereBetween('created_at', [$fromDate, $toDate])
    //                                             ->get();

            
    //         if($preparedData->count() == 0){
    //             throw new \Exception('No Records Found!!');
    //         }

    //         $recordsArray = [];

    //         foreach ($preparedData as $data) {
    //             $recordsArray[] = [  
    //                                 'sale_date'         => $this->toUserDateFormat($data->sale_date),
    //                                 'invoice_or_bill_code'  => $data->sale_code,
    //                                 'party_name'            => $data->party->getFullName(),
    //                                 'grand_total'           => $this->formatWithPrecision($data->grand_total, comma:false),
    //                                 'paid_amount'           => $this->formatWithPrecision($data->paid_amount, comma:false),
    //                                 'balance'               => $this->formatWithPrecision($data->grand_total - $data->paid_amount , comma:false),
    //                             ];
    //         }
            
    //         return response()->json([
    //                     'status'    => true,
    //                     'message' => "Records are retrieved!!",
    //                     'data' => $recordsArray,
    //                 ]);
    //     } catch (\Exception $e) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => $e->getMessage(),
    //             ], 409);

    //     }
    // }

    // public function getSaleRecords(Request $request): JsonResponse
    // {
    //     try {
    //         // Validation rules
    //         $rules = [
    //             'from_date' => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
    //             'to_date'   => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             throw new \Exception($validator->errors()->first());
    //         }

    //         $fromDate = $this->toSystemDateFormat($request->input('from_date'));
    //         $toDate   = $this->toSystemDateFormat($request->input('to_date'));

    //         // Group by party and sum grand_total
    //         $topCustomers = SaleOrder::select('party_id')
    //             ->selectRaw('SUM(grand_total) as total_purchase')
    //             ->with('party')
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->groupBy('party_id')
    //             ->orderByDesc('total_purchase')
    //             ->get();

    //         if ($topCustomers->isEmpty()) {
    //             throw new \Exception('No Records Found!!');
    //         }

    //         $recordsArray = [];

    //         foreach ($topCustomers as $data) {
    //             $recordsArray[] = [
    //                 'party_name'    => $data->party->getFullName(),
    //                 'total_purchase' => $this->formatWithPrecision($data->total_purchase, comma: false),
    //             ];
    //         }

    //         return response()->json([
    //             'status'  => true,
    //             'message' => "Top customers retrieved successfully!",
    //             'data'    => $recordsArray,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => $e->getMessage(),
    //         ], 409);
    //     }
    // }


    // public function getSaleRecords(Request $request): JsonResponse
    // {
    //     try {
    //         // Validation rules
    //         $rules = [
    //             'from_date' => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
    //             'to_date'   => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             throw new \Exception($validator->errors()->first());
    //         }

    //         $fromDate = Carbon::parse($this->toSystemDateFormat($request->input('from_date')))->startOfDay();
    //         $toDate   = Carbon::parse($this->toSystemDateFormat($request->input('to_date')))->endOfDay();
    //         $partyId            = $request->input('party_id');
    //         // Group by party and sum grand_total
    //         $topCustomers = SaleOrder::select('party_id')
    //             ->selectRaw('SUM(grand_total) as total_purchase')
    //             ->with('party')
    //             ->whereNotNull('party_id')
    //             ->whereBetween('order_date', [$fromDate, $toDate])
    //             ->groupBy('party_id')
    //             ->orderByDesc('total_purchase')
    //             ->limit(10) // optional
    //             ->get();

    //         if ($topCustomers->isEmpty()) {
    //             throw new \Exception('No Records Found!!');
    //         }

    //         $recordsArray = [];

    //         foreach ($topCustomers as $data) {
    //             $recordsArray[] = [
    //                 'party_name'     => $data->party?->getFullName() ?? 'Unknown',
    //                 'total_purchase' => $this->formatWithPrecision($data->total_purchase, comma: false),
    //             ];
    //         }

    //         return response()->json([
    //             'status'  => true,
    //             'message' => "Top customers retrieved successfully!",
    //             'data'    => $recordsArray,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => $e->getMessage(),
    //         ], 409);
    //     }
    // }

    public function getSaleRecords(Request $request): JsonResponse
    {
        try {
            // Validation rules
            $rules = [
                'from_date' => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
                'to_date'   => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $fromDate = Carbon::parse($this->toSystemDateFormat($request->input('from_date')))->startOfDay();
            $toDate   = Carbon::parse($this->toSystemDateFormat($request->input('to_date')))->endOfDay();
            $partyId  = $request->input('party_id');

            // Build query
            $query = SaleOrder::select('party_id')
                ->selectRaw('SUM(grand_total) as total_purchase')
                ->with('party')
                ->whereNotNull('party_id')
                ->whereBetween('order_date', [$fromDate, $toDate])
                ->groupBy('party_id')
                ->orderByDesc('total_purchase');

            // 🔹 Apply party filter if provided
            if (!empty($partyId)) {
                $query->where('party_id', $partyId);
            }

            // Optional: Limit top 10 only if not filtering by one party
            if (empty($partyId)) {
                $query->limit(10);
            }

            $topCustomers = $query->get();

            if ($topCustomers->isEmpty()) {
                throw new \Exception('No Records Found!!');
            }

            $recordsArray = [];

            foreach ($topCustomers as $data) {
                $recordsArray[] = [
                    'party_name'     => $data->party?->getFullName() ?? 'Unknown',
                    'total_purchase' => $this->formatWithPrecision($data->total_purchase, comma: false),
                ];
            }

            return response()->json([
                'status'  => true,
                'message' => "Top customers retrieved successfully!",
                'data'    => $recordsArray,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 409);
        }
    }




    /**
     * Item Sale Report
     * */
    // function getSaleItemRecords(Request $request): JsonResponse{
    //     // dd($request->all());
        
    //     try{
    //         // Validation rules
    //         $rules = [
    //             'from_date'         => ['required', 'date_format:'.implode(',', $this->getDateFormats())],
    //             'to_date'           => ['required', 'date_format:'.implode(',', $this->getDateFormats())],
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             throw new \Exception($validator->errors()->first());
    //         }

    //         $fromDate           = $request->input('from_date');
    //         $fromDate           = $this->toSystemDateFormat($fromDate);
    //         $toDate             = $request->input('to_date');
    //         $toDate             = $this->toSystemDateFormat($toDate);
    //         $partyId            = $request->input('party_id');
    //         $itemId             = $request->input('item_id');
    //         $warehouseId        = $request->input('warehouse_id');

    //         $preparedData = ItemTransaction::
    //                                             whereBetween('created_at', [$fromDate, $toDate])
    //                                             ->when($itemId, function ($query) use ($itemId) {
    //                                                 return $query->where('item_id', $itemId);
    //                                             })
    //                                             ->when($itemId, function ($query) use ($itemId) {
    //                                                 return $query->whereHas('itemTransaction', function ($query) use ($itemId) {
    //                                                     return $query->where('item_id', $itemId)
    //                                                                 ->where('transaction_type', 'Sale Order');
    //                                                 });
    //                                             })

    //                                             ->when($warehouseId, function ($query) use ($warehouseId) {
    //                                                     return $query->whereHas('itemTransaction', function ($query) use ($warehouseId) {
    //                                                         return $query->where('warehouse_id', $warehouseId);
    //                                                     });
    //                                                 })
    //                                              ->get();

    //                                              dd($preparedData);
                                                
        
    //         if($preparedData->count() == 0){
    //             throw new \Exception('No Records Found!!');
    //         }
    //         $recordsArray = [];

    //         foreach ($preparedData as $data) {
    //             foreach($data->itemTransaction as $transaction){
    //                 $recordsArray[] = [  
    //                                 'sale_date'         => $this->toUserDateFormat($data->sale_date),
    //                                 'invoice_or_bill_code'  => $data->sale_code,
    //                                 'party_name'            => $data->party->getFullName(),
    //                                 'warehouse'             => $transaction->warehouse->name,
    //                                 'item_name'             => $transaction->item->name,
    //                                 'unit_price'            => $this->formatWithPrecision($transaction->unit_price, comma:false),
    //                                 'quantity'              => $this->formatWithPrecision($transaction->quantity, comma:false),
    //                                 'discount_amount'       => $this->formatWithPrecision($transaction->discount_amount, comma:false),
    //                                 'tax_amount'            => $this->formatWithPrecision($transaction->tax_amount, comma:false),
    //                                 'total'                 => $this->formatWithPrecision($transaction->total , comma:false),
    //                             ];

    //             }
                
    //         }
            
    //         return response()->json([
    //                     'status'    => true,
    //                     'message' => "Records are retrieved!!",
    //                     'data' => $recordsArray,
    //                 ]);
    //     } catch (\Exception $e) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => $e->getMessage(),
    //             ], 409);

    //     }
    // }



    public function getSaleItemRecords(Request $request): JsonResponse
    {
        try {
            // Validate input
            $rules = [
                'from_date' => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
                'to_date'   => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
                'item_id'   => ['required', 'integer'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            // Format input
            $fromDate = Carbon::parse($this->toSystemDateFormat($request->input('from_date')))->startOfDay();
            $toDate   = Carbon::parse($this->toSystemDateFormat($request->input('to_date')))->endOfDay();

            $itemId   = $request->input('item_id');

            // Get only relevant item transactions
            $transactions = ItemTransaction::where('item_id', $itemId)
                
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->get();

            if ($transactions->isEmpty()) {
                throw new \Exception('No Records Found!!');
            }

            
            // Calculate total and get item name
            $totalQuantity = $transactions->sum('quantity');
            $itemName = optional($transactions->first()->item)->name ?? 'Unknown Item';

            // Return response
            return response()->json([
                'status'  => true,
                'message' => "Records are retrieved!!",
                'data'    => [[
                    'item_name'            => $itemName,
                    'total_quantity_sold'  => $this->formatWithPrecision($totalQuantity, comma: false),
                ]],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 409);
        }
    }












    /**
     * Item Sale Report
     * */
    // function getSalePaymentRecords(Request $request): JsonResponse{

    //     try{
    //         // Validation rules
    //         $rules = [
    //             'from_date'         => ['required', 'date_format:'.implode(',', $this->getDateFormats())],
    //             'to_date'           => ['required', 'date_format:'.implode(',', $this->getDateFormats())],
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             throw new \Exception($validator->errors()->first());
    //         }

    //         $fromDate           = $request->input('from_date');
    //         $fromDate           = $this->toSystemDateFormat($fromDate);
    //         $toDate             = $request->input('to_date');
    //         $toDate             = $this->toSystemDateFormat($toDate);
    //         $partyId            = $request->input('party_id');
    //         $paymentTypeId      = $request->input('payment_type_id');

    //         $preparedData = Sale::with('party', 'paymentTransaction')
    //                                             ->when($fromDate, function ($query) use ($fromDate, $toDate) {
    //                                                 return $query->whereHas('paymentTransaction', function ($query) use ($fromDate, $toDate) {
    //                                                     $query->whereBetween('transaction_date', [$fromDate, $toDate]);
    //                                                 });
    //                                             })
    //                                             ->when($partyId, function ($query) use ($partyId) {
    //                                                 return $query->where('party_id', $partyId);
    //                                             })
    //                                             ->when($paymentTypeId, function ($query) use ($paymentTypeId) {
    //                                                     return $query->whereHas('paymentTransaction', function ($query) use ($paymentTypeId) {
    //                                                         return $query->where('payment_type_id', $paymentTypeId);
    //                                                     });
    //                                                 })
    //                                             ->get();
        
    //         if($preparedData->count() == 0){
    //             throw new \Exception('No Records Found!!');
    //         }
    //         $recordsArray = [];

    //         foreach ($preparedData as $data) {
    //             foreach($data->paymentTransaction as $transaction){
    //                 $recordsArray[] = [  
    //                                 'transaction_date'      => $this->toUserDateFormat($transaction->transaction_date),
    //                                 'invoice_or_bill_code'  => $data->sale_code,
    //                                 'party_name'            => $data->party->getFullName(),
    //                                 'payment_type'          => $transaction->paymentType->name,
    //                                 'amount'                => $this->formatWithPrecision($transaction->amount, comma:false),
    //                             ];

    //             }
                
    //         }
            
    //         return response()->json([
    //                     'status'    => true,
    //                     'message' => "Records are retrieved!!",
    //                     'data' => $recordsArray,
    //                 ]);
    //     } catch (\Exception $e) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => $e->getMessage(),
    //             ], 409);

    //     }
    // }




    public function getSalePaymentRecords(Request $request): JsonResponse
    {
        try {
            // ✅ Validation rules
            $rules = [
                'from_date' => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
                'to_date'   => ['required', 'date_format:' . implode(',', $this->getDateFormats())],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            // ✅ Convert dates
            $fromDate = Carbon::parse($this->toSystemDateFormat($request->input('from_date')))->startOfDay();
            $toDate   = Carbon::parse($this->toSystemDateFormat($request->input('to_date')))->endOfDay();

            // ✅ Fetch total sales grouped by day
            $salesSummary = SaleOrder::selectRaw('DATE(order_date) as order_date, SUM(grand_total) as total_sales')
                ->whereBetween('order_date', [$fromDate, $toDate])
                ->groupBy('order_date')
                ->orderBy('order_date', 'ASC')
                ->get();

            if ($salesSummary->isEmpty()) {
                throw new \Exception('No Records Found!!');
            }

            // ✅ Prepare response array
            $recordsArray = [];
            $grandTotal = 0;

            foreach ($salesSummary as $data) {
                $recordsArray[] = [
                    'order_date'    => $this->toUserDateFormat($data->order_date),
                    'total_sales'  => $this->formatWithPrecision($data->total_sales, comma: false),
                ];
                $grandTotal += $data->total_sales;
            }

            return response()->json([
                'status'       => true,
                'message'      => "Total Sales Report Retrieved Successfully!",
                'data'         => $recordsArray,
                'grand_total'  => $this->formatWithPrecision($grandTotal, comma: false),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 409);
        }
    }



    
}
