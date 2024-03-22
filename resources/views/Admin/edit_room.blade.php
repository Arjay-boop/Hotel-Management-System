@extends('Admin.layout')

@section('content')

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title mt-5">Edit Room</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('admin.update-room', ['id' => $room->room_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row formtype">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Room Number</label>
                            <input type="text" name="room_no" id="room_no" class="form-control" value="{{ old('room_no', $room->room_no) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="room_type" id="room_type" class="form-control" required>
                                <option disabled>Select</option>
                                <option value="Single Room" {{ old('room_type', $room->room_type) == 'Single Room' ? 'selected' : '' }}>Single Room</option>
                                <option value="Double Bed Room" {{ old('room_type', $room->room_type) == 'Double Bed Room' ? 'selected' : '' }}>Double Bed Room</option>
                                <option value="Deluxe" {{ old('room_type', $room->room_type) == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bed</label>
                            <select name="bed_type" id="bed_type" class="form-control" required>
                                <option disabled>Select</option>
                                <option value="Queen Bed" {{ old('bed_type', $room->bed_type) == 'Queen Bed' ? 'selected' : '' }}>Queen Bed</option>
                                <option value="King Bed" {{ old('bed_type', $room->bed_type) == 'King Bed' ? 'selected' : '' }}>King Bed</option>
                                <option value="Twin Size Bed" {{ old('bed_type', $room->bed_type) == 'Twin Size Bed' ? 'selected' : '' }}>Twin Size Bed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $room->price) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Occupants</label>
                            <input type="text" name="occupants" id="occupants" class="form-control" value="{{ old('occupants', $room->occupants) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option disabled>Select</option>
                                <option value="Inspected" {{ old('status', $room->status) == 'Inspected' ? 'selected' : '' }}>Inspected</option>
                                <option value="Vacant Clean" {{ old('status', $room->status) == 'Vacant Clean' ? 'selected' : '' }}>Vacant Clean</option>
                                <option value="Vacant Dirty" {{ old('status', $room->status) == 'Vacant Dirty' ? 'selected' : '' }}>Vacant Dirty</option>
                                <option value="Occupied Clean" {{ old('status', $room->status) == 'Occupied Clean' ? 'selected' : '' }}>Occupied Clean</option>
                                <option value="Occupied Dirty" {{ old('status', $room->status) == 'Occupied Dirty' ? 'selected' : '' }}>Occupied Dirty</option>
                                <option value="Out of Service" {{ old('status', $room->status) == 'Out of Service' ? 'selected' : '' }}>Out of Service</option>
                                <option value="Out of Order" {{ old('status', $room->status) == 'Out of Order' ? 'selected' : '' }}>Out of Order</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Size</label>
                            <input type="text" name="size" id="size" class="form-control" value="{{ old('size', $room->size) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lodge Area</label>
                            <select name="lodge_id" id="lodge_id" class="form-control" required>
                                <option disabled>Select</option>
                                @foreach ($lodges as $lodge)
                                    <option value="{{ $lodge->lodge_id }}" {{ old('lodge_id', $room->lodge_id) == $lodge->lodge_id ? 'selected' : '' }}>{{ $lodge->area }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="container">
                            <label>Amenities</label>
                            <div class="card">
                                <div class="form-group row">
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($amenity as $amenities)
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input type="checkbox" name="amenities[]" id="amenity_{{ $amenities->amenity_id }}" class="form-check-input" value="{{ $amenities->amenity_id }}"
                                                    {{ in_array($amenities->amenity_id, $room->Amenity->pluck('amenity_id')->toArray()) ? 'checked' : '' }}>
                                                <label for="amenity_{{ $amenities->amenity_id }}" class="form-check-label">{{ $amenities->name }}</label>
                                            </div>
                                        </div>
                                        @php
                                            $count++;
                                        @endphp
                                        @if ($count % 2 === 0)
                                            <div class="w-100"></div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Choose Action for Image:</label><br>
                            <input type="radio" name="image_action" id="replaceImages" value="replace">
                            <label for="replaceImages">Replace Images</label>
                            <input type="radio" name="image_action" id="appendImages" value="append">
                            <label for="appendImages">Append Images</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Image</label>
                            <input type="file" name="img[]" id="formFile" class="form-control" multiple>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="description" class="form-control" rows="10">{{ old('description', $room->description) }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary buttonedit">Update Room</button>
            </form>
        </div>
    </div>
</div>

@endsection
