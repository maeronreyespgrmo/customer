<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    //DISPLAY MANAGER
    public function display(Request $request)
    {
        $total_count = DB::table('tbl_managers')
            ->join('tbl_offices', 'tbl_offices.id', '=', 'tbl_managers.office_id')
            ->select('tbl_offices.office_name', 'tbl_managers.*')
            ->whereNull('tbl_managers.deleted_at')
            ->whereRaw("
        CONCAT(
            manager_name
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

        $next = DB::table('tbl_managers')
            ->join('tbl_offices', 'tbl_offices.id', '=', 'tbl_managers.office_id')
            ->select('tbl_offices.office_name', 'tbl_managers.*')
            ->whereNull('tbl_managers.deleted_at')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereRaw("
        CONCAT(
            office_name,
            manager_name
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
    //CREATE NEW MANAGER
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $offices = DB::table('tbl_offices')
                ->select('id')
                ->where('office_name', $request->office_name)
                ->get();
            $manager_name = $request->suffix . "" .$request->first_name . "".$request->middle_name. "".$request->last_name;
            $table = new Manager;
            $table->office_id = $offices[0]->id;
            $table->first_name = $request->first_name;
            $table->middle_name = $request->middle_name;
            $table->last_name = $request->last_name;
            $table->suffix = $request->suffix;
            $table->manager_name = $manager_name;
            $table->save();
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE MANAGER
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $offices = DB::table('tbl_offices')
                ->select('id')
                ->where('office_name', $request->office_name)
                ->get();
            $manager_name = $request->suffix . " " .$request->first_name . " ".$request->middle_name. "".$request->last_name;
            Manager::where('id', $request->id)->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'suffix' => $request->suffix,
                'office_id' => $offices[0]->id,
                'manager_name' => $manager_name,
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE MANAGER
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = Manager::find($request->idd);
            $id->delete();
            DB::commit();
            return "success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
