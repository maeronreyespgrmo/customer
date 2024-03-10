<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Hospital;

class HospitalController extends Controller
{
    //DISPLAY DATA HOSPITAL
    public function display(Request $request)
    {
        $total_count = DB::table('tbl_hospitals')
            ->whereNull('deleted_at')
            ->whereRaw("
        CONCAT(
            hospital_name,
            hospital_address,
            hospital_number
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

        $next = DB::table('tbl_hospitals')
            ->whereNull('deleted_at')
            ->offset($offset)
            ->limit($rowsperpage)
            ->whereRaw("
        CONCAT(
            hospital_name, 
            hospital_address,
            hospital_number
        ) LIKE '%" . $request->search . "%'")
            ->orderBy('id', 'desc')
            ->get();

        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages
            )
        );
        return $myArray;
    }
    //CREATE NEW HOSPITAL
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $hospital = new Hospital;
            $hospital->hospital_name = $request->hospital_name;
            $hospital->hospital_address = $request->hospital_address;
            $hospital->hospital_number = $request->hospital_number;
            $hospital->save();
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE HOSPITAL
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            Hospital::where('id', $request->id)->update([
                'hospital_name' => $request->hospital_name,
                'hospital_address' => $request->hospital_address,
                'hospital_number' => $request->hospital_number,
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE HOSPITAL
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = Hospital::find($request->idd);
            $id->delete();
            DB::commit();
            return "success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
