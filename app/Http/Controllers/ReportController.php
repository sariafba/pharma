<?php

namespace App\Http\Controllers;

    use App\Models\Medicine;
    use App\Models\Report;
    use App\Models\StatusMedicine;
    use Illuminate\Http\Request;

    use Carbon\Carbon;


class ReportController extends Controller
{
    use Apitrait;

    public function statusReport(Request $request)
    {
        if (!auth()->user()->role) {
            return $this->apiResponse(null, 'Access only for admin');
        }

        // Get the current month and year
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->month;

        // Admin Report for the current month
        $Report = Medicine::withSum('statusMedicines', 'report_quantity')
            ->orwhereHas('statusMedicines', function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('expiration_date', '=', $currentMonth)
                    ->whereYear('expiration_date', '=', $currentYear);
            })
            ->get();

        $response = [
            'statusReport' => $Report,
            'startDate' => now()->startOfMonth()->format('Y-m-d'),
            'endDate' => now()->endOfMonth()->format('Y-m-d'),
        ];

        return response($response);
    }


    public function OrderReport(Request $request)
    {
        if (!auth()->user()->role) {
            return $this->apiResponse(null, 'Access only for admin');
        }

        // Get the current month and year
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->month;


        $orderReport = Medicine::withSum('orders', 'required_quantity')
            ->orWhereHas('orders', function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('created_at', '=', $currentMonth)
                    ->whereYear('created_at', '=', $currentYear);
            })
            ->get();
        $response = [
            'OrderReport' => $orderReport,
            'startDate' => now()->startOfMonth()->format('Y-m-d'),
            'endDate' => now()->endOfMonth()->format('Y-m-d'),
        ];
        return response($response);
    }
}
