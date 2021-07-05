<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $APIUrl = "https://dev02.performance.tradedepot.co.nz/api/orders/list";
        $client = new Client();
        $response = $client->request('GET', $APIUrl);

        if($response->getStatusCode() != 200)
        {
            return response()->json(["success"=>false, "data" => []]);
        }
        $results = $response->getBody()->getContents();


        $resultJSON = json_decode($results,true);

        $updatedJSON = array();

        foreach ($resultJSON as $key => $value)
        {
            if($value["Status"] == 'fully_invoiced') {
                $value["Status"] = "Fully Invoiced";
            }
            $value["TotalAmount"] = number_format((float)$value["TotalAmount"], 2, '.', '');
            $updatedJSON[] = ["RefNumber"=>$value["RefNumber"],"TxnDate"=>$value["TxnDate"],"TotalAmount"=>$value["TotalAmount"],"CustomerID"=>$value["CustomerID"],"Status"=>$value["Status"]];
        }

        return response()->json(["success"=>true, "data" => $updatedJSON]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
