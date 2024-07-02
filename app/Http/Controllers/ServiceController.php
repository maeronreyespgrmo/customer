<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceCSM;
use App\Models\Office;
use App\Models\OfficeCSM;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    //DISPLAY SERVICES DATA
    public function display(Request $request)
    {
        $total_count = DB::table('tbl_services')
            ->join('tbl_offices', 'tbl_services.office_id', '=', 'tbl_offices.id')
            ->select('tbl_services.service_name', 'tbl_services.id', 'tbl_services.deleted_at', 'tbl_offices.office_name')
            ->whereNull('tbl_services.deleted_at')
            ->whereRaw("
        CONCAT(
            office_name, 
            service_name
        ) LIKE '%" . $request->search . "%'")
            ->count();
        $currentpage =  $request->nextpage;
        $rowsperpage = 10;
        $totalpages = ceil($total_count / $rowsperpage);
        if ($currentpage == null && !is_numeric($currentpage)) {
            $currentpage = 1;
        }
        if ($currentpage > $totalpages) {
            $currentpage = $totalpages;
        }
        $offset = ($currentpage - 1) * $rowsperpage;

        $next = DB::table('tbl_services')
            ->join('tbl_offices', 'tbl_services.office_id', '=', 'tbl_offices.id')
            ->select('tbl_services.service_name', 'tbl_services.id', 'tbl_services.deleted_at', 'tbl_offices.office_name')
            ->whereNull('tbl_services.deleted_at')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereRaw("
        CONCAT(
            office_name, 
            service_name
        ) LIKE '%" . $request->search . "%'")
            ->orderBy('tbl_services.id', 'desc')
            ->get();

        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages
            )
        );
        return $myArray;
    }
    //CREATE DATA ON SERVICES
    public function create(Request $request)
    {

        try {
            DB::beginTransaction();
            $office = DB::table('tbl_offices')
                ->select('id')
                ->where('office_name', $request->office_name)
                ->get();
            $table = new Service;
            $table->office_id = $office[0]->id;
            $table->service_name = $request->service_name;
            $table->save();
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE DATA ON SERVICES
    public function update(Request $request)
    {

        try {
            DB::beginTransaction();
            $office = DB::table('tbl_offices')
                ->select('id')
                ->where('office_name', $request->office_name)
                ->get();
            Service::where('id', $request->id)->update([
                'office_id' => $office[0]->id,
                'service_name' => $request->service_name,
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE DATA ON SERVICES
    public function destroy(Request $request)
    {
        $id = Service::find($request->idd);
        $id->delete();
        return $request->idd;
    }

    //CSM
     //DISPLAY SERVICES DATA
     public function display_csm(Request $request)
     {
         $total_count = DB::table('tbl_services_csm')
             ->join('tbl_offices_csm', 'tbl_services_csm.office_id', '=', 'tbl_offices_csm.id')
             ->select('tbl_services_csm.service_name', 'tbl_services_csm.id', 'tbl_services.service_type', 'tbl_services_csm.deleted_at', 'tbl_offices.office_name')
             ->whereNull('tbl_services_csm.deleted_at')
             ->whereRaw("
         CONCAT(
             office_name, 
             service_name
         ) LIKE '%" . $request->search . "%'")
             ->count();
         $currentpage =  $request->nextpage;
         $rowsperpage = 10;
         $totalpages = ceil($total_count / $rowsperpage);
         if ($currentpage == null && !is_numeric($currentpage)) {
             $currentpage = 1;
         }
         if ($currentpage > $totalpages) {
             $currentpage = $totalpages;
         }
         $offset = ($currentpage - 1) * $rowsperpage;
 
         $next = DB::table('tbl_services_csm')
             ->join('tbl_offices_csm', 'tbl_services_csm.office_id', '=', 'tbl_offices_csm.id')
             ->select('tbl_services_csm.service_name', 'tbl_services_csm.id', 'tbl_services_csm.service_type', 'tbl_services_csm.deleted_at', 'tbl_offices_csm.office_name')
             ->whereNull('tbl_services_csm.deleted_at')
             // ->offset($offset)
             // ->limit($rowsperpage)
             ->whereRaw("
         CONCAT(
             office_name,
             service_type, 
             service_name
         ) LIKE '%" . $request->search . "%'")
             ->orderBy('tbl_services_csm.id', 'desc')
             ->get();
 
         $myArray = array(
             array(
                 "first_array" => $next,
                 "last_array" => $totalpages
             )
         );
         return $myArray;
     }
     //CREATE DATA ON SERVICES
     public function create_csm(Request $request)
     {
         try {
             DB::beginTransaction();
             $office = DB::table('tbl_offices_csm')
                 ->select('id')
                 ->where('office_name', $request->office_name)
                 ->get();

            $service_type = $request->service_type == "External" ? 0 : 1;
                 
             $table = new ServiceCSM;
             $table->office_id = $office[0]->id;
             $table->service_name = $request->service_name;
             $table->service_type = $service_type;
             $table->save();
             DB::commit();
             return "Success";
         } catch (\Exception $e) {
             DB::rollBack();
             return $e->getMessage();
         }
     }
     //UPDATE DATA ON SERVICES
     public function update_csm(Request $request)
     {
         try {
             DB::beginTransaction();
             $office = DB::table('tbl_offices_csm')
                 ->select('id')
                 ->where('office_name', $request->office_name)
                 ->get();
            $service_type = $request->service_type == "External" ? 0 : 1;
             ServiceCSM::where('id', $request->id)->update([
                 'office_id' => $office[0]->id,
                 'service_name' => $request->service_name,
                 'service_type' => $request->service_type,
             ]);
             DB::commit();
             return "Success";
         } catch (\Exception $e) {
             DB::rollBack();
             return $e->getMessage();
         }
     }
     //DELETE DATA ON SERVICES
     public function destroy_csm(Request $request)
     {
         $id = ServiceCSM::find($request->idd);
         $id->delete();
         return $request->idd;
     }
}
