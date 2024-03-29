<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Order;
use App\Models\Basicinfo;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = request()->bearerToken();
        $user_id=PersonalAccessToken::findToken($token);
        $order =Order::with('users')->where('user_id',$user_id->tokenable_id)->get();
        foreach($order as $or){
            $invo =Invoice::with(['orders','orders.users.roles'])->where('order_id',$or->id)->first();
            if(isset($invo)){
                $invoices[]=$invo;
            }
        }
        if(isset($invoices)){

        }else{
            $invoices=[];
        }
        $response = [
            'status' => true,
            'message'=>'My Invoices',
            "data"=> [
                'invoices'=> $invoices,
            ]

        ];
        return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $invoices =Invoice::with(['orders','orders.users'])->where('id',$id)->first();

            $response = [
                'status' => true,
                'message'=>'Invoice by invoice ID',
                "data"=> [
                    'invoices'=> $invoices,
                ]
            ];

            return response()->json($response,200);
        } catch (\Exception $e) {

            $response = [
                'status' => false,
                'message'=>$e->getMessage(),
            ];
            return response()->json($response,200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function updatepayment(Request $request)
    {
        $invoice =Invoice::where('invoiceID',$request->invoice_id)->first();
        $invoice->paid_amount=$invoice->payable_amount;
        $invoice->payable_amount=0;
        $invoice->paymentDate=date('Y-m-d');
        $invoice->status=$request->status;
        $success=$invoice->update();
        if($success){
            $order=Order::where('id',$invoice->order_id)->first();
            if($order->expireDate!=''){
                if($order->new_user>0){
                    $order->account_total_user=$order->account_total_user+$order->new_user;
                    $order->amount_total=$order->account_total_user*$order->cost_per_user;
                    $order->new_user=0;
                }else{
                    $order->status='Active';
                    $order->expireDate=date('Y-m-d', strtotime('+1 month'));
                }
            }else{
                $order->status='Active';
                $order->expireDate=date('Y-m-d', strtotime('+1 month'));
            }
            $order->update();
        }
        $user=User::where('id',$order->user_id)->first();
        $details = [
            'title' => 'Payment Confirmation -'. env('APP_NAME'),
            "user"=>$user,
            'invoice'=>$invoice,
        ];

        \Mail::to($user->email)->send(new \App\Mail\SendMailPayment($details));

        $response = [
            'status' => true,
            'message'=>'Payment Give Successfully',
            "data"=> [
                'invoices'=> $invoice,
            ]
        ];

        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
