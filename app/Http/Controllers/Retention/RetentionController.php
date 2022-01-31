<?php

namespace App\Http\Controllers\Retention;

use App\Http\Controllers\Controller;
use App\Retention;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RetentionController extends Controller
{
    public function index()
    {
        $from = request ('from') ? request ('from') : Carbon::today()->format('Y-m-01') ;
        $to = request ('to') ? request ('to') : Carbon::today()->format('Y-m-d') ;
        $retentions = Retention::whereBetween('created_at',[$from . ' 00:00:00' , $to . ' 23:59:59'])->where('branch_id',auth()->user()->branch_id)->orderBy('created_at', 'desc')->get();
        return view('retention.index', compact('retentions','from','to'));
    }
}
