<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Office;
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
}
