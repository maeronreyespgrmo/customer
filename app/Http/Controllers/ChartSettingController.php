<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChartSettingCSS;
use App\Models\ChartSettingPSS;
use Illuminate\Support\Facades\DB;

class ChartSettingController extends Controller
{
    //DISPLAY VIEW CSS
    public function view_css()
    {
        return ChartSettingCSS::all();
    }
    //DISPLAY VIEW PSS
    public function view_pss()
    {
        return ChartSettingPSS::all();
    }
    //UPDATE CHART SETTINGS
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            ChartSettingCSS::where('id', 1)->update([
                'chart_name' => $request->chart_css,
            ]);

            ChartSettingPSS::where('id', 1)->update([
                'chart_name' => $request->chart_pss,
            ]);

            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
