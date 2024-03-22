<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\DailyReports;
use App\Models\Events;
use App\Models\LodgeAreas;
use App\Models\MonthlyReports;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-monthly-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly reports for all lodge areas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Scheduler command executed successfully.');
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $startDate = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $endDate = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        $lodgeAreas = LodgeAreas::all();

        foreach ($lodgeAreas as $lodgeArea) {
            $lodgeId = $lodgeArea->lodge_id;
            $reportDate = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
            $dailyReports = DailyReports::where('lodge_id', $lodgeArea->id)
                ->whereYear('report_date', $currentYear)
                ->whereMonth('report_date', $currentMonth)
                ->get();

            $totalRevenue = $dailyReports->sum('revenue');
            $occupancyRate = $dailyReports->avg('occupancy_rate');
            $damageRate = $dailyReports->avg('damage_rate');
            $averageRate = $dailyReports->avg('average_rate');
            $totalBookings = $dailyReports->sum('total_bookings');
            $totalRooms = $lodgeArea->total_rooms;
            $totalDamage = $dailyReports->sum('total_damage');

            $totalCustomersByGender = Customer::whereIn('cust_id', function ($query) use ($lodgeArea) {
                $query->select('cust_id')
                    ->from('books')
                    ->where('lodge_id', $lodgeArea->lodge_id)
                    ->where(function ($subQuery) use ($lodgeArea) {
                        $subQuery->whereBetween('start_date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                            ->orWhereBetween('end_date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                            ->orWhere(function ($subQuery) use ($lodgeArea) {
                                $subQuery->where('start_date', '<', Carbon::now()->startOfDay())
                                    ->where('end_date', '>', Carbon::now()->endOfDay())
                                    ->where('lodge_id', $lodgeArea->lodge_id);
                            });
                    });
            })
            ->join('users', 'customers.user_id', '=', 'users.user_id')
            ->selectRaw('users.gender as gender, count(*) as total')
            ->where('status', 'stayed-in') // Assuming 'status' column exists in the 'customers' table
            ->groupBy('users.gender')
            ->get();


            // Get events for the current lodge area
            $lodgeEvents = Events::where('lodge_id', $lodgeArea->id)
                ->whereYear('start_date', $currentYear)
                ->whereMonth('start_date', $currentMonth)
                ->get();

            // Get university-wide events
            $universityEvents = Events::whereNull('lodge_id')
                ->whereYear('start_date', $currentYear)
                ->whereMonth('start_date', $currentMonth)
                ->get();

            // Merge events
            $events = $lodgeEvents->merge($universityEvents);

            // Get event names
            $eventNames = $events->pluck('name')->implode(', ');

            // Store or use the calculated data for each lodge area
            $monthReport = new MonthlyReports([
                'lodge_id' => $lodgeId,
                'report_date' => $reportDate,
                'revenue' => $totalRevenue,
                'occupancy_rate' => $occupancyRate ? : 0,
                'damage_rate' => $damageRate ? : 0,
                'average_rate' => $averageRate ? : 0,
                'total_bookings' => $totalBookings,
                'total_customers_by_gender' => $totalCustomersByGender,
                'total_rooms' => $totalRooms,
                'total_damage' => $totalDamage,
                'event_name' => $eventNames,
            ]);

            $monthReport->save();
            // You can save this data to the MonthlyReports model if you have one
        }
    }
}
