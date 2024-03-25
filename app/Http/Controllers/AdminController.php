<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Books;
use App\Models\CleanHistory;
use App\Models\DailyReports;
use App\Models\Events;
use App\Models\LodgeAreas;
use App\Models\LodgeAreasImages;
use App\Models\Ratings;
use App\Models\RoomImages;
use App\Models\Rooms;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminHome()
    {
        $name = Auth::user();

        $fullname = $name->first_name . ' ' . $name->middle_name . ' ' . $name->last_name;

        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $daysInMonth = Carbon::now()->daysInMonth;

        $dailyReport = DailyReports::whereMonth('report_date', $currentMonth)
                                    ->whereYear('report_date', $currentYear)
                                    ->get();
        $lodges = LodgeAreas::with('DailyReports')
            ->get();

            // Fetch total guests data for each lodge
        $totalGuestsData = $lodges->map(function ($lodge) use ($currentMonth) {
            return $lodge->DailyReports()
                ->whereMonth('report_date', $currentMonth)
                ->sum('total_customers_by_gender'); // Assuming this represents total guests
        });

        // Prepare data for the pie chart
        $guestsChartData = [
            'labels' => $lodges->map(function ($lodge) {
                return $lodge->area;
            }),
            'datasets' => [
                [
                    'label' => 'Total Guests',
                    'data' => $totalGuestsData->toArray(),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];

        // Prepare the data for the chart
        $data = [
            'labels' => $lodges->map(function ($lodge) {
                return $lodge->area;
            }),
            'datasets' => $lodges->map(function ($lodge) use ($currentMonth) {
                return [
                    'label' => $lodge->area,
                    'data' => $lodge->DailyReports()
                        ->whereMonth('report_date', $currentMonth)
                        ->pluck('occupancy_rate')
                        ->toArray(),
                    'borderColor' => $this->randomColor(),
                    'backgroundColor' => $this->randomColor(),
                ];
            }),
        ];

        $datas = [
            'labels' => range(1, $daysInMonth), // Array containing days of the month
            'datasets' => $lodges->map(function ($lodge) use ($currentMonth, $daysInMonth) {
                $color = $this->randomColor();
                return [
                    'label' => $lodge->area,
                    'data' => $this->getOccupancyDataForLodge($lodge, $currentMonth, $daysInMonth),
                    'borderColor' => $color,
                    'backgroundColor' => $color,
                ];
            }),
        ];

        $revenueData = $dailyReport->pluck('revenue');
        $bookingsData = $dailyReport->pluck('total_bookings');
        $occupancyData = $dailyReport->pluck('occupancy_rate');
        $averageRateData = $dailyReport->pluck('average_rate');

        $totalRevenue = $dailyReport->sum('revenue');
        $totalOccupancy = $dailyReport->sum('occupancy_rate');
        $totalBookings = $dailyReport->sum('total_bookings');

        $totalReports = $dailyReport->count();
        $totalAverageRate = $dailyReport->sum('average_rate');
        $averageRate = ($totalReports > 0) ? $totalAverageRate / $totalReports : 0;

        return view('Admin.admin-dashboard', ['fullname' => $fullname,
                                            'revenueData' => $revenueData,
                                            'bookingsData' => $bookingsData,
                                            'occupancyData' => $occupancyData,
                                            'averageRateData' => $averageRateData,
                                            'totalRevenue' => $totalRevenue,
                                            'totalOccupancy' => $totalOccupancy,
                                            'totalBookings' => $totalBookings,
                                            'averageRate' => $averageRate,
                                            'guestsChartData' => $guestsChartData,
                                            'data' => $data,
                                            'datas' => $datas,
                                            'daysInMonth' => $daysInMonth, // Passing $daysInMonth to the view
                                        ]);
    }

    private function getOccupancyDataForLodge($lodge, $currentMonth, $daysInMonth)
    {
        $occupancyData = [];
        $dailyReports = $lodge->DailyReports()
            ->whereMonth('report_date', $currentMonth)
            ->orderBy('report_date')
            ->get();

        foreach (range(1, $daysInMonth) as $day) {
            $report = $dailyReports->where('report_date', Carbon::create(null, $currentMonth, $day)->toDateString())->first();
            if ($report) {
                $occupancyData[] = $report->occupancy_rate;
            } else {
                $occupancyData[] = null; // No data for this day
            }
        }

        return $occupancyData;
    }

    private function randomColor()
    {
        $red = rand(100, 255); // Ensure red component is not too dark (range: 100-255)
        $green = rand(100, 255); // Ensure green component is not too dark (range: 100-255)
        $blue = rand(100, 255); // Ensure blue component is not too dark (range: 100-255)

        // Convert RGB values to hexadecimal format
        $hexColor = sprintf("#%02x%02x%02x", $red, $green, $blue);

        return $hexColor;
    }

    public function ViewLodge()
    {
        $lodgingArea = LodgeAreas::with('Images')->get();
        return view('Admin.lodge_areas', compact('lodgingArea'));
    }

    public function AddLodge()
    {
        return view('Admin.add_lodge_areas');
    }

    public function StoreLodge(Request $request)
    {
        $lodge = LodgeAreas::create([
            'area' => $request->area,
            'total_rooms' => $request->total_rooms,
            'status' => $request->status,
            'location' => $request->location,
        ]);

        if ($files = $request->file('image')) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $file->move('lodge-image', $name);

                LodgeAreasImages::create([
                    'lodge_id' => $lodge->lodge_id,
                    'img' => $name,
                ]);
            }
        }

        return redirect()->route('admin.lodges')->with('success', 'Lodge Area Saved Successfully');
    }

    public function EditLodge(string $id)
    {
        $lodge = LodgeAreas::findOrFail($id);
        $lodgeImages = $lodge->Images;
        return view('Admin.edit_lodge_areas', compact('lodge', 'lodgeImages'));
    }

    public function DeleteLodge(string $id)
    {
        $lodge = LodgeAreas::findOrFail($id);

        $lodge->Images()->delete();

        $lodge->delete();

        return redirect()->back()->with('success', 'Lodge Area Successfully Deleted');
    }

    public function UpdateLodge(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'area' => 'required',
            'total_rooms' => 'required|numeric',
            'status' => 'required',
            'location' => 'required',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validation for new images
        ]);

        $lodge = LodgeAreas::findOrFail($id);

        $lodge->area = $validatedData['area'];
        $lodge->total_rooms = $validatedData['total_rooms'];
        $lodge->status = $validatedData['status'];
        $lodge->location = $validatedData['location'];

        if($request->has('image_action') && $request->input('image_action') === 'replace') {
            $existingImages = LodgeAreasImages::where('lodge_id', $lodge->lodge_id)->get();

            foreach ($existingImages as $existingImage) {
                # code...
                $imagePath = public_path('lodge-image/' . $existingImage->image);

                if (File::exists($imagePath)) {
                    # code...
                    File::delete($imagePath);
                }
                $existingImage->delete();
            }
        }
        $images = $request->file('image');

        if ($images) {
            foreach ($images as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move('lodge-image/', $imageName);

                LodgeAreasImages::create([
                    "lodge_id" => $lodge->lodge_id,
                    "img" => $imageName,
                ]);
            }
        }

        $lodge->save();

        return redirect()->route('admin.lodges')->with('success', 'Lodge Area Updated Successfully');
    }

    public function ViewEmployee()
    {
        // Retrieve all employees with a non-null lodge_id
        $employees = User::whereNotNull('lodge_id')->get();

        // Retrieve distinct lodge areas
        $lodgeAreas = LodgeAreas::query()
                                ->select('area')
                                ->distinct()
                                ->get()
                                ->toArray();

        // Retrieve distinct lodges
        $lodges = LodgeAreas::distinct()->get(['lodge_id', 'area']);

        // Pass the variables to the view
        return view('Admin.employee', compact('employees', 'lodgeAreas', 'lodges'));
    }

    public function LodgeEmployee(Request $request)
    {
        $lodgeId = $request->input('lodgeId');

        if ($lodgeId == '*') {
            $users = User::whereNotNull('lodge_id')
                            ->with('LodgeAreas')
                            ->get();
        } else {
            $users = User::where('lodge_id', $lodgeId)
                            ->with('LodgeAreas')
                            ->get();
        }

        $filteredDate = $users->map(function ($employee) {
            return [
                'first_name' => $employee->first_name,
                'middle_name' => $employee->middle_name,
                'last_name' => $employee->last_name,
                'gender' => $employee->gender,
                'birthdate' => $employee->birthdate,
                'phone_no' => $employee->phone_no,
                'email' => $employee->email,
                'lodge_id' => $employee->LodgeAreas->area,
                'position' => $employee->position,
                'editLink' => route('admin.edit-employee', $employee->user_id),
            ];
        });

        return response()->json($filteredDate);
    }

    public function SearchEmployee(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::where('lodge_id', '!=', null)
                        ->where(function ($query) use ($searchTerm) {
                            $query->where('first_name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('middle_name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                        })->get();

        $filteredDate = $users->map(function ($employee) {
            return [
                'first_name' => $employee->first_name,
                'middle_name' => $employee->middle_name,
                'last_name' => $employee->last_name,
                'gender' => $employee->gender,
                'birthdate' => $employee->birthdate,
                'phone_no' => $employee->phone_no,
                'email' => $employee->email,
                'lodge_id' => $employee->LodgeAreas->area,
                'position' => $employee->position,
                'editLink' => route('admin.edit-employee', $employee->user_id),
            ];
        });

        return response()->json(['filteredData' => $filteredDate]);
    }

    public function PositionEmployee(Request $request)
    {
        $position = $request->input('position');

        if ($position == '*') {
            $employees = User::whereNotNull('lodge_id')
                            ->with('LodgeAreas')
                            ->get();
        } else {
            $employees = User::where('position', $position)
                                ->whereNotNull('lodge_id')
                                ->with('LodgeAreas')
                                ->get();
        }
        $filteredData = $employees->map(function ($employee) {
            return [
                'first_name' => $employee->first_name,
                'middle_name' => $employee->middle_name,
                'last_name' => $employee->last_name,
                'gender' => $employee->gender,
                'birthdate' => $employee->birthdate,
                'phone_no' => $employee->phone_no,
                'email' => $employee->email,
                'lodge_id' => $employee->LodgeAreas->area,
                'position' => $employee->position,
                'editLink' => route('admin.edit-employee', $employee->user_id),
            ];
        });
        //dd($filteredData);

        return response()->json($filteredData)->header('Content-Type', 'application/json');
    }

    public function FilterEmployee(Request $request)
    {
        $searchTerm = $request->input('search');
        $lodgeId = $request->input('lodgeId');
        $positions = $request->input('position');

        $query = User::whereNotNull('lodge_id');

        if (!empty($lodgeId) && $lodgeId != '*') {
            $query->where('lodge_id', $lodgeId);
        }

        if (!empty($positions) && $positions != '*') {
            $query->where('position', $positions);
        }

        if (!empty($searchTerm)) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like' , '%'.$searchTerm.'%')
                    ->orWhere('middle_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('last_name', 'like',  '%'.$searchTerm.'%');
            });
        }



        $users = $query->with('LodgeAreas')->get();

        $filteredData = $users->map(function ($employee){
            return [
                'first_name' => $employee->first_name,
                'middle_name' => $employee->middle_name,
                'last_name' => $employee->last_name,
                'gender' => $employee->gender,
                'birthdate' => $employee->birthdate,
                'phone_no' => $employee->phone_no,
                'email' => $employee->email,
                'lodge_id' => $employee->LodgeAreas->area,
                'position' => $employee->position,
                'editLink' => route('admin.edit-employee', $employee->user_id),
            ];
        });

        return response()->json($filteredData);
    }

    public function AddEmployee()
    {
        $employees = User::query()
                        ->whereNotNull('lodge_id')
                        ->get();
        $lodges = LodgeAreas::query()
                            ->select('area')
                            ->distinct()
                            ->get()->toArray();
        return view('Admin.add_employee', compact('employees'))->with(compact('lodges'));
    }

    public function StoreEmployee(Request $request)
    {
        $validatedRules = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'phone_no' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'password' => 'required|min:6'
        ]);

        $lodge = LodgeAreas::query()
                            ->where('area', $request->lodge_id)
                            ->first();

        $user = User::create([
            'lodge_id' => $lodge->lodge_id,
            'first_name' => $validatedRules[ 'first_name'],
            'middle_name' => $validatedRules['middle_name'] ,
            'last_name'  => $validatedRules['last_name'],
            'gender' => $validatedRules['gender'],
            'birthdate' => $validatedRules['birthdate'],
            'phone_no' => $validatedRules['phone_no'],
            'email' => $validatedRules['email'],
            'position' => $validatedRules['position'],
            'password' => Hash::make($validatedRules['password']),
        ]);

        return redirect()->route('admin.employee')->with('success', 'Employee Successfully Added');
    }

    public function EditEmployee(string $id)
    {
        $employees = User::query()
                    ->whereNotNull('lodge_id')
                    ->get();

        $lodgingAreas = LodgeAreas::query()
                        ->with('users')
                        ->select('area')
                        ->distinct()
                        ->get()->toArray();

        $lodges = LodgeAreas::all();
        $edit = User::find($id);

        return  view('Admin.edit_employee', compact('edit', 'employees'))->with(compact('lodges'));
    }

    public function UpdateEmployee(Request $request, string $id)
    {
        $validationData = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone_no' => 'required',
            'birthdate' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'password' => 'required',
        ]);

        $employee = User::findOrFail($id);
        $lodgeId = $request->has('lodge_id') ? $request->lodge_id : null;

        $lodge = LodgeAreas::where('lodge_id', $lodgeId)->first();

        $employee->update([
            'lodge_id' => $lodge->lodge_id,
            'first_name' => $validationData['first_name'],
            'middle_name' => $validationData['middle_name'],
            'last_name' => $validationData['last_name'],
            'gender' => $validationData['gender'],
            'phone_no' => $validationData['phone_no'],
            'birthdate' => $validationData['birthdate'],
            'email' => $validationData['email'],
            'position' => $validationData[ 'position'],
            'password' => Hash::make($validationData['password']),
        ]);

        return redirect()->route('admin.employee')->with('success', 'Employee Saved Successfully');
    }

    public function DeleteEmployee(string $id)
    {
        $employee = User::find($id);

        $employee->delete();

        return redirect()->back()->with('success', 'Employee deleted');
    }

    public function ViewRoom()
    {
        $room = Rooms::all();
        $rating = Ratings::all();
        $amenities = [];
        $lodges = LodgeAreas::all();

        foreach ($room as $rooms) {
            $roomRatings = $rating->where('room_id', $rooms->room_id);
            $averageRating = $roomRatings->isEmpty() ? 0 : $roomRatings->avg('stars');

            $roomAmenities = $rooms->Amenity->take(4);
            $rooms->averageRatings = $averageRating;

            $amenities[$rooms->room_id] = $roomAmenities;
        }

        return view('Admin.room', compact('room', 'amenities', 'rating', 'lodges'));
    }

    public function AddRoom()
    {
        $lodges = LodgeAreas::all();

        $amenity = Amenity::all();

        return view('Admin.add_room', compact(['amenity', 'lodges']));
    }

    public function StoreRoom(Request $request)
    {
        $lodge = LodgeAreas::where('area', $request->lodge_id)->first();

        $room = Rooms::create([
            'lodge_id' => $lodge->lodge_id,
            'room_no' => $request->room_no,
            'room_type' => $request->room_type,
            'bed_type' => $request->bed_type,
            'status' => $request->status,
            'price' => $request->price,
            'occupants' => $request->occupants,
            'size' => $request->size,
            'description' => $request->description,
        ]);

        if ($files = $request->file('img')) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $file->move('room-image', $name);

                RoomImages::create([
                    'room_id' => $room->room_id,
                    'img' => $name,
                ]);
            }
        }

        if ($request->has('amenities')) {
            $room->Amenity()->attach($request->input('amenities'));
        }

        return redirect()->route('admin.room')->with('success', 'Room Successfully Added');
    }

    public function AddAmenity()
    {
        return view('Admin.add_amenity');
    }

    public function StoreAmenity(Request $request)
    {
        $validationRules = $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        $amenity = Amenity::create([
            'name' => $validationRules['name'],
            'price' => $validationRules['price'],
        ]);

        return redirect()->route('admin.room')->with('success', 'Amenity Successfully Created!');
    }

    public function UpdateStatus(Request $request, $roomId)
    {
        // Update room status
        $room = Rooms::findOrFail($roomId);
        $room->status = $request->input('status');
        $room->save();

        // Log status change
        CleanHistory::create([
            'room_id' => $room->room_id,
            'user_id' => Auth::id(),
            'clean_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Room status updated successfully.');
    }

    public function EditRoom(string $id)
    {
        $room = Rooms::find($id);
        $lodges = LodgeAreas::all();
        $amenity = Amenity::all();

        return view('Admin.edit_room', compact('room', 'lodges', 'amenity'));
    }

    public function UpdateRoom(Request $request, string $id)
    {
        $room = Rooms::findOrFail($id);
        $lodgeId = $request->has('lodge_id') ? $request->lodge_id : null;
        $lodge = LodgeAreas::where('lodge_id', $lodgeId)->first();

        $room->update([
            'lodge_id' => $lodge->lodge_id,
            'room_no' => $request->room_no,
            'room_type' => $request->room_type,
            'bed_type' => $request->bed_type,
            'status' => $request->status,
            'price' => $request->price,
            'occupants' => $request->price,
            'size' => $request->size,
            'description' => $request->description,
        ]);

        if ($request->has('image_action') && $request->input('image_action') === 'replace') {
            $existingRoomImages = RoomImages::where('room_id', $room->room_id)->get();

            foreach ($existingRoomImages as $existingRoomImage) {
                $imagePath = public_path('room-image/' . $existingRoomImage->img);

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }

                $existingRoomImage->delete();
            }
        }

        $images = $request->file('img');

        if ($images) {
            foreach ($images as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move('room-image', $imageName);

                RoomImages::create([
                    'room_id' => $room->room_id,
                    'img' => $imageName,
                ]);
            }
        }

        if ($request->has('amenities')) {
            $room->Amenity()->sync($request->input('amenities'));
        } else {
            $room->Amenity()->detach();
        }

        return redirect()->route('admin.room')->with('success', 'Room Successfully Updated');
    }

    public function DeleteRoom(string $id)
    {
        $room = Rooms::findOrFail($id);

        //dd($room);

        $roomImages = RoomImages::where('room_id', $room->room_id)->get();

        foreach ($roomImages as $image) {
            $imagePath = public_path('room-image/' . $image->img);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $image->delete();
        }

        $room->Amenity()->detach();
        $room->delete();

        return response()->json([
            'success' => true,
            'message' => 'Room Successfully Deleted'
        ]);
    }

    public function DetailsRoom($room_id)
    {
        $room = Rooms::findOrFail($room_id);
        $amenities = $room->Amenity;
        $roomImages = $room->Images;
        $ratings = Ratings::where('room_id', $room_id)->get();
        $averageStars = $ratings->isEmpty() ? 0 : $ratings->avg('stars');
        $room->averageStars = $averageStars;

        $subjects = $ratings->pluck('subjects')->toArray();
        $stars = $ratings->pluck('stars')->toArray();
        $comments = $ratings->pluck('comments')->toArray();

        $room->subjects = $subjects;
        $room->stars = $stars;
        $room->comments = $comments;

        return view('Admin.room_details', compact('room', 'roomImages', 'amenities', 'ratings'));
    }

    public function CleanHistory($room_id)
    {
        $cleaningHistory = CleanHistory::with('Users')
                                        ->where('room_id', $room_id)
                                        ->latest()
                                        ->take(5)
                                        ->get();

        return response()->json($cleaningHistory);
    }

    public function searchCleaningHistory($room_id, Request $request)
    {
        $searchQuery = $request->input('q');

        $searchDate = Carbon::parse($searchQuery)->toDateString();

        // Query to fetch cleaning history filtered by the search query
        $cleaningHistory = CleanHistory::with('Users')
                                        ->where('room_id', $room_id)
                                        ->whereDate('clean_date', $searchDate)
                                        ->get();

        return response()->json($cleaningHistory);
    }

    public function filterRooms(Request $request)
    {
        $searchTerm = $request->input('search');
        $lodgeId = $request->input('lodgeId');
        $roomType = $request->input('roomType');

        $query = Rooms::query();

        if ($searchTerm) {
            $query->where('room_no', 'like', "%{$searchTerm}%");
        }

        if ($lodgeId != '*') {
            $query->where('lodge_id', $lodgeId);
        }

        if ($roomType != '*') {
            $query->where('room_type', $roomType);
        }

        $rooms = $query->get();

        return response()->json($rooms);
    }

    public function calendar()
    {
        $events = Events::all();
        $bookings = Books::all();
        $lodge = LodgeAreas::all();

        return view('Admin.calendar', compact('events', 'bookings', 'lodge'));
    }

    public function StoreEvent(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $event = new Events;
        $event->name = $validatedData['name'];
        $event->description = $validatedData['description'];
        $event->start_date = $validatedData['start_date'];
        $event->end_date = $validatedData['end_date'];
        $event->lodge_id = $request->input('lodge_id');

        $event->save();

        // Retrieve all events (including the newly added event)
        $events = Events::all();

        // Return a JSON response indicating success and the updated list of events
        return response()->json([
            'success' => true,
            'events' => $events
        ]);
    }

    public function Analytics()
    {
        $lodges = LodgeAreas::all(); // Fetch all lodges

        // Fetch revenue data for each lodge
        $revenues = [];
        foreach ($lodges as $lodge) {
            $dailyReports = DailyReports::where('lodge_id', $lodge->lodge_id)->get();
            $revenues[$lodge->area] = $dailyReports->pluck('revenue')->toArray();
        }

        // Fetch occupancy rate data for each lodge
        $occupancyRates = [];
        foreach ($lodges as $lodge) {
            $dailyReports = DailyReports::where('lodge_id', $lodge->lodge_id)->get();
            $occupancyRates[$lodge->area] = $dailyReports->pluck('occupancy_rate')->toArray();
        }

        // Fetch damage rate data for each lodge
        $damageRates = [];
        foreach ($lodges as $lodge) {
            $dailyReports = DailyReports::where('lodge_id', $lodge->lodge_id)->get();
            $damageRates[$lodge->area] = $dailyReports->pluck('damage_rate')->toArray();
        }

        // Fetch average rate data for each lodge
        $averageRates = [];
        foreach ($lodges as $lodge) {
            $dailyReports = DailyReports::where('lodge_id', $lodge->lodge_id)->get();
            $averageRates[$lodge->area] = $dailyReports->pluck('average_rate')->avg();
        }

        $totalGuests = [];
        foreach ($lodges as $lodge) {
            $dailyReports = DailyReports::where('lodge_id', $lodge->lodge_id)->get();

            // Decode JSON and sum values, ensuring they are numeric
            $total_customers_by_gender = collect($dailyReports->pluck('total_customers_by_gender')->filter())->flatten()->reduce(function ($carry, $item) {
                // Check if item is numeric before adding
                return is_numeric($item) ? $carry + $item : $carry;
            }, 0);

            $totalGuests[$lodge->area] = $total_customers_by_gender;
        }



        $damageCosts = [];
        foreach ($lodges as $lodge) {
            $dailyReports = DailyReports::where('lodge_id', $lodge->lodge_id)->get();
            $damageCosts[$lodge->area] = $dailyReports->sum('total_damage');
        }

        // Fetch total rooms data for each lodge
        $totalRooms = [];
        foreach ($lodges as $lodge) {
            $totalRooms[$lodge->area] = $lodge->total_rooms;
        }

        // Fetch total customer data for each lodge and gender
        $totalCustomers = [];
        foreach ($lodges as $lodge) {
            $dailyReports = DailyReports::where('lodge_id', $lodge->lodge_id)->get();
            $maleCustomers = $dailyReports->sum('total_customers_male');
            $femaleCustomers = $dailyReports->sum('total_customers_female');
            $totalCustomers[$lodge->area] = [
                'male' => $maleCustomers,
                'female' => $femaleCustomers
            ];
        }

        return view('Admin.analytics', compact(
                                        'lodges',
                                        'revenues',
                                        'occupancyRates',
                                        'dailyReports',
                                        'damageRates',
                                        'averageRates',
                                        'totalGuests',
                                        'damageCosts',
                                        'totalRooms',
                                        'totalCustomers'
                                    ));
    }

    public function generatePDF(Request $request)
    {
        // Get selected parameters from the request
        $reportType = $request->input('type_report');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $lodgeId = $request->input('lodge_id');

        // Validate report type
        $validReportTypes = ['revenue', 'occupancy_rate', 'damage_rate', 'average_rate', 'total_bookings', 'total_customers_by_gender', 'total_damage'];
        if (!in_array($reportType, $validReportTypes)) {
            return response()->json(['error' => 'Invalid report type.'], 400);
        }

        // Query the DailyReports table based on the selected parameters
        $query = DailyReports::query()->whereBetween('report_date', [$startDate, $endDate]);

        // Optionally, filter by lodge ID if provided
        if ($lodgeId) {
            $query->where('lodge_id', $lodgeId);
        }

        // Get the report data based on the selected parameters
        $reports = $query->get();

        // Check if reports are empty
        if ($reports->isEmpty()) {
            return response()->json(['message' => 'No data found for the selected parameters.'], 404);
        }

        // Generate HTML content for the PDF
        $html = '<h1>' . ucfirst($reportType) . ' Report</h1>';
        $html .= '<p>Start Date: ' . $startDate . '</p>';
        $html .= '<p>End Date: ' . $endDate . '</p>';
        $html .= '<table>';
        $html .= '<thead><tr><th>Date</th><th>' . ucfirst($reportType) . '</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($reports as $report) {
            $html .= '<tr>';
            $html .= '<td>' . $report->report_date . '</td>';
            $html .= '<td>' . $report->$reportType . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        // Generate PDF using Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Download the generated PDF file
        return $dompdf->stream('report.pdf');
    }

}
