<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;

use App\Models\Whatsapp;
use Illuminate\Http\Request;
use App\Models\Currencyrate;
use MakiDizajnerica\GeoLocation\Facades\GeoLocation;
use App\Helpers\UserSystemInfoHelper;
use Currency;

class WhatsappController extends Controller
{
    public function ipinfo(){
        $positions = GeoLocation::lookup('103.49.203.178');

        $amount= Currency::conv($from = 'USD', $to = 'NOK', $value = 10);
        return $amount;
    }

    public function clearcache(){
        \Artisan::call('optimize:clear');
        \Artisan::call('route:clear');
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');

        $response = [
            'status' => true,
            'message'=>'Application Cache Clear Successfully',
        ];
        return response()->json($response,200);
    }

    public function appinfo(){
        $value=[
            'php_version'=>phpversion(),
            'composer_version'=>trim(shell_exec('composer --version')),
            'app_version'=>app()->version(),
            'site_name'=>env('APP_NAME'),
            'app_debug_mode'=>config('app.debug') ? 'Enabled' : 'Disabled',
            'site_node'=>config('app.env') == 'local' ? 'Testing' : 'Production',
            'db_port'=>config('database.connections.mysql.port'),
            'server_ip'=>$_SERVER['SERVER_ADDR'],
            'server_protocol'=>$_SERVER['SERVER_PROTOCOL'],
        ];

        $response = [
            'status' => true,
            'message'=>'Application Details Info.',
            "data"=> [
                'applications'=> $value,
            ]
        ];
        return response()->json($response,200);
    }

    public function exchangerate(Request $request){
        $currancyrate=Currencyrate::where('from',$request->from)->where('to',$request->to)->first();
        if(isset($currancyrate)){
            $value=$currancyrate->rate*$request->amount;

            $response = [
                'status' => true,
                'message'=>'Exchange amount',
                "data"=> [
                    'value'=> $value,
                ]
            ];
            return response()->json($response,200);
        }else{
            $response = [
                'status' => false,
                'message'=>'No Exchange rate found !',
                "data"=> [
                    'value'=> [],
                ]
            ];
            return response()->json($response,200);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->search)){
            $whatsapp=Whatsapp::where('user_name','LIKE', "%$request->search%")->get();
        }else{
            $whatsapp=Whatsapp::all();
        }

        $response = [
            'status' => true,
            'message'=>'All whatsapp number infos',
            "data"=> [
                'whatsapp'=> $whatsapp,
            ]
        ];
        return response()->json($response,200);
    }

    public function getwhatsappinfo()
    {
        $whatsapps=Whatsapp::where('status','Active')->inRandomOrder()->first();

        $response = [
            'status' => true,
            'message'=>'Random whatsapp number',
            "data"=> [
                'whatsapp'=> $whatsapps,
            ]
        ];
        return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $whatsapp=new Whatsapp();
        $whatsapp->user_name=$request->user_name;
        $whatsapp->whatsapp_number=$request->whatsapp_number;

        $whatsapp->save();
        $response=[
            "status"=>true,
            'message' => "Whatsapp info create successful",
            "data"=> [
                'whatsapp'=> $whatsapp,
            ]
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Whatsapp  $whatsapp
     * @return \Illuminate\Http\Response
     */
    public function show(Whatsapp $whatsapp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Whatsapp  $whatsapp
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $whatsapp=Whatsapp::findOrfail($id);

        $response=[
            "status"=>true,
            'message' => "Whatsapp info by ID",
            "data"=> [
                'whatsapp'=> $whatsapp,
            ]
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Whatsapp  $whatsapp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $whatsapp=Whatsapp::findOrfail($id);
        $whatsapp->user_name=$request->user_name;
        $whatsapp->whatsapp_number=$request->whatsapp_number;

        $whatsapp->update();
        $response=[
            "status"=>true,
            'message' => "Whatsapp info update successfull",
            "data"=> [
                'whatsapp'=> $whatsapp,
            ]
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Whatsapp  $whatsapp
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $whatsapp=Whatsapp::findOrfail($id);
        $whatsapp->delete();

        $response=[
            "status"=>true,
            'message' => "Whatsapp info delete successfull",
            "data"=> [
                'whatsapp'=> [],
            ]
        ];
        return response()->json($response, 200);
    }
}
