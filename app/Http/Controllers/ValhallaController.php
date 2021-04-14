<?php

namespace App\Http\Controllers;

class ValhallaController extends Controller
{
    public function __invoke()
    {
        return view('valhallaapp');
    }
}
