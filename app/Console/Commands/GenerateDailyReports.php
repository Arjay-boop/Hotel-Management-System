<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\DailyReports;
use App\Models\Events;
use App\Models\LodgeAreas;
use App\Models\Ratings;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-daily-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Scheduler command executed successfully.');
        //
        $lodgeAreas = LodgeAreas::all();

        $university = Events::whereNull('lodge_id')->get();

        foreach ($lodgeAreas as $lodgeArea)
        {
            $lodgeid = $lodgeArea->lodge_id;
            $revenue = DB::table('bills')->where('lodge_id', $lodgeArea->lodge_id)->sum('total_amount');
            $occupiedRooms = $lodgeArea->Rooms()
                                        ->where('status', 'Occupied Clean')
                                        ->orWhere('status', 'Occupied Dirty')
                                        ->count();
            $damageRooms = $lodgeArea->Rooms()
                                        ->where('status', 'Out of Order')
                                        ->orWhere('status', 'Out of Service')
                                        ->count();
            $totalRooms = $lodgeArea->total_rooms;
            $occupancyRate = ($totalRooms > 0) ? ($occupiedRooms / $totalRooms) * 100 : 0;
            $damageRate = ($totalRooms > 0) ? ($damageRooms / $totalRooms) * 100 : 0;
            $averageRating = Ratings::whereHas('Rooms', function ($query) use ($lodgeArea) {
                $query->where('lodge_id', $lodgeArea->lodge_id);
            })->avg('stars');
            $totalBookings = $lodgeArea->Books()->count();
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
            ->groupBy('users.gender')
            ->get();

            $totalDamage = $lodgeArea->Bills()->sum('damage_charge');
            $events = $lodgeArea->Events->merge($university);

            $eventName = $events->pluck('name')->implode(', ');
            $dailyReport = new DailyReports([
                'lodge_id' => $lodgeid,
                'report_date' => now(),
                'revenue' => $revenue,
                'occupancy_rate' => $occupancyRate,
                'damage_rate' => $damageRate,
                'average_rate' => $averageRating ?: 0,
                'total_bookings' => $totalBookings,
                'total_customers_by_gender' => $totalCustomersByGender,
                'total_rooms' => $totalRooms,
                'total_damage' => $totalDamage,
                'event_name' => $eventName,
            ]);

            $dailyReport->save();
        }
    }
}
