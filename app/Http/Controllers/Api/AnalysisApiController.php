<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Services\AnalysisService;
use App\Services\DecileService;
use App\Services\RFMService;

class AnalysisApiController extends Controller
{
    public function index(Request $request) 
    {
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);
        
        if ($request->type === 'perDay') {
            list($data, $labels, $totals) = AnalysisService::perDay($subQuery);
        }
        
        if ($request->type === 'perMonth') {
            list($data, $labels, $totals) = AnalysisService::perMonth($subQuery);
        }
        
        if ($request->type === 'perYear') {
            list($data, $labels, $totals) = AnalysisService::perYear($subQuery);
        }
        
        if ($request->type === 'decile') {
            list($data, $labels, $totals) = DecileService::decile($subQuery);
        }
        
        if ($request->type === 'rfm') {
            list($data, $totals, $eachCount) = RFMService::rfm($subQuery, $request->rfmParams);

            return response()->json([
                'data' => $data,
                'eachCount' => $eachCount,
                'totals' => $totals,
                'type' => $request->type
            ], Response::HTTP_OK);
        }
        
        return response()->json([
            'data' => $data,
            'labels' => $labels,
            'totals' => $totals,
            'type' => $request->type
        ], Response::HTTP_OK);
    }
}
