<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Load the view content (your actual page content)
        $content = view('home'); // we'll create this view next

        // Load the template and inject the content
        return view('template', ['content' => $content]);
    }
}
