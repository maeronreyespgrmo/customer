<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Doctor;

class DoctorController extends Controller
{
    //DISPLAY DOCTORS
    public function display(Request $request)
    {
        $total_count = DB::table('tbl_doctors')
            ->join('tbl_hospitals', 'tbl_doctors.hospital_id', '=', 'tbl_hospitals.id')
            ->select('tbl_doctors.*', 'tbl_hospitals.hospital_name')
            ->whereNull('tbl_doctors.deleted_at')
            ->whereRaw("
        CONCAT(
            doctor_name,
            position,
            hospital_name
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

        $next = DB::table('tbl_doctors')
            ->join('tbl_hospitals', 'tbl_doctors.hospital_id', '=', 'tbl_hospitals.id')
            ->select('tbl_doctors.*', 'tbl_hospitals.hospital_name')
            ->offset($offset)
            ->limit($rowsperpage)
            ->whereNull('tbl_doctors.deleted_at')
            ->whereRaw("
        CONCAT(
            doctor_name, 
            position,
            hospital_name
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
    //CREATE NEW HOSPITALS
    public function create(Request $request)
    {

        try {
            DB::beginTransaction();
            $hospital = DB::table('tbl_hospitals')
                ->select('id')
                ->where('hospital_name', $request->hospital_name)
                ->get();
            $doctor = new Doctor;
            $doctor->hospital_id = $hospital[0]->id;
            $doctor->doctor_name = $request->doctor_name;
            $doctor->position = $request->position;
            $doctor->save();
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE HOSPITALS
    public function update(Request $request)
    {

        try {
            DB::beginTransaction();
            $hospital = DB::table('tbl_hospitals')
                ->select('id')
                ->where('hospital_name', $request->hospital_name)
                ->get();

            Doctor::where('id', $request->id)->update([
                'hospital_id' => $hospital[0]->id,
                'doctor_name' => $request->doctor_name,
                'position' => $request->position,
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE HOSPITALS
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            Doctor::find($request->idd)->delete();

            DB::commit();
            return "success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
