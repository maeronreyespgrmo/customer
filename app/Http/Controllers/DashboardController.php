<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $page = array(
            'title' =>  'Dashboard',
            'name'  =>  'Dashboard 1',
            'crumb' =>  array(
                'Home' => '',
                'Dashboard' => ''
            )
        );
        return view('dashboard', compact('page'));
    }


    public function user()
    {
        $page = array(
            'title' =>  'User',
            'name'  =>  'User',
            'crumb' =>  array(
                'Home' => '',   
                'User' => ''
            )
        );
        return view('user', compact('page'));
    }

    public function services()
    {
        $page = array(
            'title' =>  'Services',
            'name'  =>  'Services',
            'crumb' =>  array(
                'Home' => '',   
                'Services' => ''
            )
        );
        return view('services', compact('page'));
    }


    public function view_css()
    {
        $page = array(
            'title' =>  'View CSS Survey',
            'name'  =>  'View CSS Survey',
            'crumb' =>  array(
                'Home' => '',   
                'View CSS Survey' => ''
            )
        );
        return view('view_css', compact('page'));
    }

    public function view_pss()
    {
        $page = array(
            'title' =>  'View PSS Survey',
            'name'  =>  'View PSS Survey',
            'crumb' =>  array(
                'Home' => '',   
                'View PSS Survey' => ''
            )
        );
        return view('view_pss', compact('page'));
    }
    
    public function view_csm()
    {
        $page = array(
            'title' =>  'View CSM Survey',
            'name'  =>  'View CSM Survey',
            'crumb' =>  array(
                'Home' => '',   
                'View CSM Survey' => ''
            )
        );
        return view('view_csm', compact('page'));
    }

    public function doctor()
    {
        $page = array(
            'title' =>  'Doctor Maintenance',
            'name'  =>  'Doctor Maintenance',
            'crumb' =>  array(
                'Home' => '',   
                'Doctor' => ''
            )
        );
        return view('doctor', compact('page'));
    }

    public function manager()
    {
        $page = array(
            'title' =>  'Manager Maintenance',
            'name'  =>  'Manager Maintenance',
            'crumb' =>  array(
                'Home' => '',   
                'Manager' => ''
            )
        );
        return view('manager', compact('page'));
    }

    public function hospital()
    {
        $page = array(
            'title' =>  'Hospital Maintenance',
            'name'  =>  'Hospital Maintenance',
            'crumb' =>  array(
                'Home' => '',   
                'Manager' => ''
            )
        );
        return view('hospital', compact('page'));
    }

    public function office()
    {
        $page = array(
            'title' =>  'Office Maintenance',
            'name'  =>  'Office Maintenance',
            'crumb' =>  array(
                'Home' => '',   
                'Manager' => ''
            )
        );
        return view('office', compact('page'));
    }

    public function comments_css()
    {
        $page = array(
            'title' =>  'Comment CSS',
            'name'  =>  'Comment CSS',
            'crumb' =>  array(
                'Home' => '',   
                'Manager' => ''
            )
        );
        return view('comments_css', compact('page'));
    }

    public function comments_pss()
    {
        $page = array(
            'title' =>  'Comment PSS',
            'name'  =>  'Comment PSS',
            'crumb' =>  array(
                'Home' => '',   
                'Manager' => ''
            )
        );
        return view('comments_pss', compact('page'));
    }

    public function import_css()
    {
        $page = array(
            'title' =>  'Import CSS',
            'name'  =>  'Import CSS',
            'crumb' =>  array(
                'Home' => '',   
                'Manager' => ''
            )
        );
        return view('import_css', compact('page'));
    }

    public function import_pss()
    {
        $page = array(
            'title' =>  'Import PSS',
            'name'  =>  'Import PSS',
            'crumb' =>  array(
                'Home' => '',   
                'Manager' => ''
            )
        );
        return view('import_pss', compact('page'));
    }
    
    public function chart_settings()
    {
        $page = array(
            'title' =>  'Chart Settings',
            'name'  =>  'Chart Settings',
            'crumb' =>  array(
                'Home' => '',   
                'Manager' => ''
            )
        );
        return view('chart_settings', compact('page'));
    }
    
}
