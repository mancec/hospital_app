<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PrescribedDrugsStatisticsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('date_from') && $request->has('date_to'))
        {
            $date = $request->validate([
                'date_from' => 'required|date',
                'date_to' => 'required|date',
            ]);
        }
        else {
            $date['date_from'] = now()->startOfWeek()->toDateString();
            $date['date_to'] = now()->endOfWeek()->toDateString();
        }

        $drugs = DB::table('prescription_drug')
            ->leftJoin('drugs','drugs.id', '=', 'drug_id')
            ->select('title', 'drug_id', DB::raw('SUM(amount) total'), DB::raw("DATE_FORMAT(prescription_drug.created_at, '%Y %m %e') date"))
            ->whereBetween('prescription_drug.created_at', [$date['date_from'], $date['date_to']])
            ->groupBy('drug_id', 'date')
            ->orderBy('total', 'desc')
            ->paginate(10);

        return view('prescription_statistics.drugs_by_day', ['drugs' => $drugs, 'date' => $date]);
    }
}
