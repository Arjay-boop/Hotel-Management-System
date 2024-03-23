<?php

namespace App\Http\Controllers;

use App\Models\CleanHistory;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HousekeeperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function housekeeperHome()
    {
        $name = Auth::user();
        $fullname = $name->first_name . ' ' . $name->middle_name . ' ' . $name->last_name;

        return view('Housekeeper.housekeeper-dashboard', ['fullname' => $fullname]);
    }

    public function Rooms()
    {
        // Retrieve the authenticated user (housekeeper)
        $housekeeper = Auth::user();

        // Check if the user's position is a housekeeper
        if ($housekeeper->position === 3) {
            // Retrieve the lodge area associated with the housekeeper
            $lodgeArea = $housekeeper->LodgeAreas;

            // Retrieve the rooms associated with the lodge area
            $room = $lodgeArea->Rooms;

            // Return the view with the rooms data
            return view('Housekeeper.rooms', ['room' => $room]);
        } else {
            // If the user's position is not a housekeeper, handle accordingly
            // For example, redirect to another page or display an error message
            return redirect()->back()->with('error', 'You are not authorized to view this page.');
        }
    }
    public function updateRoomStatusAndAmenities(Request $request, $roomId)
    {
        // Retrieve the room
        $room = Rooms::findOrFail($roomId);

        // Update room status if provided
        if ($request->has('status')) {
            $room->status = $request->status;
            $room->save();

            // Log room status change
            $user = Auth::user();
            $userName = $user->first_name . ' ' . $user->last_name;
            // Store clean history
            $cleanHistory = new CleanHistory();
            $cleanHistory->room_id = $roomId;
            $cleanHistory->user_id = $user->user_id;
            $cleanHistory->clean_date = now(); // Assuming clean_date is a timestamp
            $cleanHistory->save();
        }

        // Update room amenities
        if ($request->has('amenities')) {
            // Sync amenities with the room
            $room->Amenity()->sync($request->amenities);
        }

        // Redirect back or to a specific route
        return redirect()->back()->with('success', 'Room status and amenities updated successfully.');
    }
}
