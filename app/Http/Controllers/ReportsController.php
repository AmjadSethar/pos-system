<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    Public function SaleReportPage()
    {
        return view('reports.sale_report');
    }
}
