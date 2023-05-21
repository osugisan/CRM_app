<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AnalysisApiController extends Controller
{
    public function index(Request $request) 
    {
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);
        
        if ($request->type === 'perDay') {
            $subQuery->where('status', true)
                ->groupBy('id')
                ->selectRaw('
                    id,
                    SUM(subTotal) as totalPerPurchase,
                    DATE_FORMAT(created_at, "%Y%m%d") as date');

            $data = DB::table($subQuery)
                ->groupBy('date')
                ->selectRaw('
                    date,
                    sum(totalPerPurchase) as total')
                ->get();

            $labels = $data->pluck('date');
            $totals = $data->pluck('total');
        }

        return response()->json([
            'data' => $data,
            'labels' => $labels,
            'totals' => $totals,
            'type' => $request->type
        ], Response::HTTP_OK);
    }
}
