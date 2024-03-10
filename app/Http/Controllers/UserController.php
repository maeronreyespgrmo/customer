<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //DIRECT USER TO DASHBOARD
    public function index(Request $request)
    {
        if (Auth::Account()) {
            return redirect('/dashboard');
        }
        return view('login');
    }
    //LOGIN USER
    public function login(Request $request)
    {
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            return "success";
        } else {
            return "failed";
        }
    }
    //DISPLAY USER
    public function display(Request $request)
    {
        $total_count = DB::table('tbl_users')
            ->whereNull('deleted_at')
            ->whereRaw("
                    CONCAT(
                        username, 
                        password,
                        first_name,
                        last_name,
                        middle_name,
                        user_type
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

        $next = DB::table('tbl_users')
            ->whereNull('deleted_at')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereRaw("
CONCAT(
        username, 
        password,
        first_name,
        last_name,
        middle_name,
        user_type
    ) LIKE '%" . $request->search . "%'")
            ->orderBy('id', 'desc')
            ->get();
        // foreach ($next as $key => $item) {
        //     $result[$key] = array(
        //         "id" => $next[0]->id,
        //         "username" => $item->username,
        //         "password" => $item->password,
        //         "first_name" => $item->first_name,
        //         "last_name" => $item->last_name,
        //         "middle_name" => $item->middle_name,
        //         "user_type" => $item->user_type
        //     );
        // }
        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages,
                "total_count" => $total_count
            )
        );
        return $myArray;
    }
    //SEARCH USER
    public function search(Request $request)
    {
        $total_count = DB::table('tbl_users')->whereNull('deleted_at')->count();
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

        $accounts = Account::select(
            'username',
            'password',
            'first_name',
            'last_name',
            'middle_name',
            'user_type',
        );

        $result = $accounts->where(
            DB::raw(
                "CONCAT(
                `first_name`,
                `username` ,
                `password`,
                `first_name`,
                `last_name`,
                `middle_name`,
                `user_type`
            )"
            ),
            'LIKE',
            "%1%"
        );

        $accounts->offset($offset);
        $accounts->whereNull('deleted_at');
        $accounts->limit($rowsperpage);
        $accounts->orderBy('id', 'asc');
        $result = $accounts->get();

        $myArray = array(
            array(
                "first_array" => $result,
                "last_array" => $totalpages,
                "total_count" => $total_count
            )
        );

        return $myArray;
    }
    //LOGOUT USER
    public function logout()
    {
        if (Auth::user()) {
            Auth::logout();
        }

        return back();
    }
    //CREATE USER
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $table = new Account;
            $table->first_name = $request->firstname;
            $table->last_name = $request->lastname;
            $table->username = $request->username;
            $table->middle_name = $request->middlename;
            $table->password = Hash::make($request->password);
            $table->user_type = $request->user_type;
            $table->save();
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE USER
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            Account::where('id', $request->id)->update([
                'first_name' => $request->firstname,
                'middle_name' => $request->middlename,
                'last_name' => $request->lastname,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE USER
    public function destroy(Request $request)
    {
        $id = Account::find($request->id);
        $id->delete();
        return "success";
    }
    //FOR TESTING PURPOSES
    public function table(Request $request)
    {
        $accounts = Account::select(
            'first_name',
            'username',
            'password',
        );

        $total = $accounts->count();

        $result = $accounts->where(
            DB::raw(
                "CONCAT(
                `first_name`,
                `username` ,
                `password`  
            )"
            ),
            'LIKE',
            "%" . $request->search['value'] . "%"
        );

        $result = $accounts->orderBy('first_name', 'ASC')
            ->skip($request->start)
            ->take($request->length)
            ->get();

        $filtered = (is_null($request->search['value']) ? $total : $result->count());

        return array(
            "draw" => $request->draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $filtered,
            "data" => $result,
            "request" => $request->all()
        );
    }
}
