<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected function success(string $message)
    {
        return redirect()->back()->with('success', $message);
    }

    protected function failed(string $message)
    {
        return redirect()->back()->withErrors($message);
    }
}
