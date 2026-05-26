<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class PosIntegrationController extends Controller
{
    public function index()
    {
        return view('partner.pos-integration');
    }
}
