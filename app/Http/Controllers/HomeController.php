<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function get_search_users(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $searchValue = $request->get('txtSearch');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    
        // Total records
        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')
        ->where('first_name', 'like', '%' . $searchValue . '%')
        ->Orwhere('last_name', 'like', '%' . $searchValue . '%')
        ->Orwhere('phone_number', 'like', '%' . $searchValue . '%')
        ->count();

        // Fetch records
        $records = User::orderBy($columnName, $columnSortOrder)
            ->where('users.first_name', 'like', '%' . $searchValue . '%')
            ->Orwhere('users.last_name', 'like', '%' . $searchValue . '%')
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $first_name = $record->first_name;
            $last_name = $record->last_name;
            $email = $record->email;
            $phone_number = $record->phone_number;
            $data_arr[] = array(
                "id" => $id,
                "last_name" => $last_name,
                "first_name" => $first_name,
                "phone_number" => $phone_number,
                "email" => $email,
                "technologies" =>""
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
        exit;
    }
}
