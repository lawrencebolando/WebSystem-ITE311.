<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        return view('home');   // Loads app/Views/home.php
    }

    public function about()
    {
        return view('about');  // Loads app/Views/about.php
    }

    public function contact()
    {
        return view('contact'); // Loads app/Views/contact.php
    }
}
