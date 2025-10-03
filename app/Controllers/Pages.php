<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pages extends Controller
{
    public function index()
    {
        $data = [];
        $data['content'] = view('home');
        return view('template', $data);
    }

    public function about()
    {
        $data = [];
        $data['content'] = view('about');
        return view('template', $data);
    }

    public function contact()
    {
        $data = [];
        $data['content'] = view('contact');
        return view('template', $data);
    }
}


