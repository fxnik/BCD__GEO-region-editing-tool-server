<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;


class RegionController extends Controller
{

    public function addRegion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [ 
                'info' => 'required',              
                'geo_json' => 'required'
            ]);
     
            if($validator->fails())
            {
                return response()->json([
                    'isError'=> true,                
                    'message'=>'uncompleted_data'
                ]);
            }
    
            //-------------------------------------------------

            DB::insert('insert into regions (uuid, info, geo_json) values (?, ?, ?)', 
                [
                  (string) Str::uuid(), 
                  $request->info, 
                  $request->geo_json
                ]);

            return response()->json([
                'isError'=> false,
                'message' => 'done'                
            ]);
        }
        catch (Exception $e) {            
            return response()->json([
                'isError'=> true,
                'message' => $e->getMessage()
            ]);
        }        
    }

    //=====================================================

    public function updateRegion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [ 
                'uuid' => 'required',
                'info' => 'required',              
                'geo_json' => 'required'
            ]);
     
            if($validator->fails())
            {
                return response()->json([
                    'isError'=> true,                
                    'message'=>'uncompleted_data'
                ]);
            }
    
            //-------------------------------------------------

            DB::table('regions')->where('uuid', $request->uuid)
                ->update([
                           'info' => $request->info,
                           'geo_json' => $request->geo_json
                         ]);

            return response()->json([
                'isError'=> false,
                'message' => 'done'                
            ]);
        }
        catch (Exception $e) {            
            return response()->json([
                'isError'=> true,
                'message' => $e->getMessage()
            ]);
        }        
    }

    //=====================================================

    public function getRegionsInfo(Request $request)
    {
        try {
            $regionsInfo = DB::select('select uuid, info from regions');

            return response()->json([
                'isError'=> false,
                'message' => 'done',
                'payload' => $regionsInfo
            ]);
        }
        catch (Exception $e) {            
            return response()->json([
                'isError'=> true,
                'message' => $e->getMessage()
            ]);
        }
    }

    //=====================================================

    public function deleteRegion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [ 
                'uuid' => 'required'               
            ]);
     
            if($validator->fails())
            {
                return response()->json([
                    'isError'=> true,                
                    'message'=>'uncompleted_data'
                ]);
            }
    
            //------------------------------------

            Region::where('uuid', $request->uuid)->delete();

            return response()->json([
                'isError'=> false,
                'message' => 'done'                
            ]);
        }
        catch (Exception $e) {            
            return response()->json([
                'isError'=> true,
                'message' => $e->getMessage()
            ]);
        }
    }

    //=====================================================

    public function getOneRegion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [ 
                'uuid' => 'required'               
            ]);
     
            if($validator->fails())
            {
                return response()->json([
                    'isError'=> true,                
                    'message'=>'uncompleted_data'
                ]);
            }
    
            //------------------------------------

            $region = Region::where('uuid', $request->uuid)->first();

            return response()->json([
                'isError'=> false,
                'message' => 'done',
                'payload' => $region                
            ]);
        }
        catch (Exception $e) {            
            return response()->json([
                'isError'=> true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
