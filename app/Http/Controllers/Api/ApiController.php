<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleDetail;
use App\Models\DeleteVehicleDetail;

class ApiController extends Controller
{
    // create api POST
    public function CreateVehicle(request $request)
    {
        // validation
        $request-> validate([
            "manufacturer" => "required",
            "model" => "required",
            "fin" => "required"
        ]);

        //create data

        $vehicle = new VehicleDetail();

        $vehicle->manufacturer = $request->manufacturer;
        $vehicle->model = $request->model;
        $vehicle->fin = $request->fin;
        $vehicle->first_registration = $request->first_registration;
        $vehicle->kilometers_stand = $request->kilometers_stand;
        $vehicle->created_by = $request->created_by;

        $vehicle-> save();

        //send response
        return response()->json([
            "status"=> 1,
            "message" => "Vehicle created sucessfully"
        ]);
    }

    //all view api GET
    public function VehicleList()
    {
        $vehicle = VehicleDetail::get();

        return response()-> json([
            "status" => 1,
            "message" => "Listing Employees",
            "data" => $vehicle
        ], 200);
    }

    //vehicle single view api GET
    public function SingleVehicleDetails($id)
    {
        if(VehicleDetail::where("id",$id)->exists()){

            $vehicle_detail = VehicleDetail::where("id",$id)->first();

            return response()->json([
                "status"=> 1,
                "message"=> "Vehicle Found",
                "data" =>  $vehicle_detail
            ]);

        }else{
            return response()->json([
                "status"=>0,
                "message"=>"Vehicle Not Found."
            ], 404);
        }
    }

    //vehicle update api PUT
    public function VehicleUpdate(request $request,$id)
    {
        if (VehicleDetail::where("id", $id)->exists()) {

            $vehicle = VehicleDetail::find($id);
            
        $vehicle->manufacturer = $request->manufacturer;
        $vehicle->model = $request->model;
        $vehicle->fin = $request->fin;
        $vehicle->first_registration = $request->first_registration;
        $vehicle->kilometers_stand = $request->kilometers_stand;
        $vehicle->last_edited_by = $request->last_edited_by;

        $vehicle->save();

        return response()->json([
            "status"=>1,
            "message"=>"Vehicle Data Updated Successfully"
        ]);


        }else{
            return response()->json([
                "status"=>0,
                "message"=>"Vehicle Not Found."
            ], 404); 
        }
    }

    //vehicle delete api DELETE
    public function VehicleDelete($id)
    {

        if (VehicleDetail::where("id", $id)->exists()) {

            /*first insert deleted record in another table*/
            $vehicle_detail = VehicleDetail::where("id",$id)->first();

            $deletevehicle = new DeleteVehicleDetail();

            $deletevehicle->manufacturer = $vehicle_detail->manufacturer;
            $deletevehicle->model = $vehicle_detail->model;
            $deletevehicle->fin = $vehicle_detail->fin;
            $deletevehicle->first_registration = $vehicle_detail->first_registration;
            $deletevehicle->kilometers_stand = $vehicle_detail->kilometers_stand;
            $deletevehicle->created_at = $vehicle_detail->created_at;
            $deletevehicle->updated_at = $vehicle_detail->updated_at;


            $deletevehicle->save();
            /*end*/
        
            $vehicle = VehicleDetail::find($id);
            $vehicle -> delete();

            return response()->json([
                "status"=>1,
                "message"=>"Vehicle Data Deleted Successfully"
            ]);

        }else{
            return response()->json([
                "status"=>0,
                "message"=>"Vehicle Not Found."
            ], 404); 
        }

    }

    //all view api GET
    public function DeleteList()
    {
        $vehicle = DeleteVehicleDetail::get();

        return response()-> json([
            "status" => 1,
            "message" => "Listing Employees",
            "data" => $vehicle
        ], 200);
    }
}
