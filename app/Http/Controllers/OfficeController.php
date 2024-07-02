<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\OfficeCSM;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    //DISPLAY OFFICE
    public function display(Request $request)
    {
        $total_count = DB::table('tbl_offices')
            ->select('tbl_offices.*')
            ->whereNull('tbl_offices.deleted_at')
            ->whereRaw("
        CONCAT(
            office_name
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

        $next = DB::table('tbl_offices')
            ->select('tbl_offices.*')
            ->whereNull('tbl_offices.deleted_at')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereRaw("
        CONCAT(
            office_name
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
    //CREATE NEW OFFICE
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $table = new Office;
            $table->office_name = $request->office_name;
            $table->save();
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE NEW OFFICE
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            Office::where('id', $request->id)->update([
                'office_name' => $request->office_name
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE OFFICE
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = Office::find($request->idd);
            $id->delete();
            DB::commit();
            return "success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DROPDOWN MANAGER
    public function dropdown_manager(Request $request)
    {
        $manager = DB::table('tbl_managers')->get();
        return $manager;
    }

    //CSM
    //DISPLAY OFFICE
    public function display_csm(Request $request)
    {
        $total_count = DB::table('tbl_offices_csm')
            ->select('tbl_offices_csm.*')
            ->whereNull('tbl_offices_csm.deleted_at')
            ->whereRaw("
        CONCAT(
            office_name
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

        $next = DB::table('tbl_offices_csm')
            ->select('tbl_offices_csm.*')
            ->whereNull('tbl_offices_csm.deleted_at')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereRaw("
        CONCAT(
            office_name
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
    //CREATE NEW OFFICE
    public function create_csm(Request $request)
    {
        try {
            DB::beginTransaction();
            $table = new OfficeCSM;
            $table->office_name = $request->office_name;
            $table->save();
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE NEW OFFICE
    public function update_csm(Request $request)
    {
        try {
            DB::beginTransaction();
            OfficeCSM::where('id', $request->id)->update([
                'office_name' => $request->office_name
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE OFFICE
    public function destroy_csm(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = OfficeCSM::find($request->idd);
            $id->delete();
            DB::commit();
            return "success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DROPDOWN MANAGER
    public function dropdown_manager_csm(Request $request)
    {
        $manager = DB::table('tbl_managers')->get();
        return $manager;
    }
}
