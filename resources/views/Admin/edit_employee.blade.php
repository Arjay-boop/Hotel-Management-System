@extends('Admin.layout')

@section('content')

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title mt-5">Edit Employee</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @isset($edit)
                <form method="POST" action="{{ route('admin.update-employee', ['edit' => $edit->user_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="row formtype">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name</label>
                                <input id="first_name" name="first_name" class="form-control" type="text" value="{{ old('first_name', $edit->first_name) }}" required> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input id="middle_name" name="middle_name" class="form-control" type="text" value="{{ old('middle_name', $edit->middle_name) }}" required> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input id="last_name" name="last_name" class="form-control" type="text" value="{{ old('last_name', $edit->last_name) }}" required> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sex</label>
                                <select id="gender" name="gender" class="form-control" id="sel1" name="sellist1" required>
                                    <option>Select</option>
                                    <option value="Male" {{ old('gender', $edit->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $edit->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input id="phone_no" name="phone_no" class="form-control" type="text" value="{{ old('phone_no', $edit->phone_no) }}" required> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Birthday</label>
                                <input id="birthdate" name="birthdate" class="form-control" type="date" value="{{ old('birthdate', $edit->birthdate) }}" required> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input id="email" name="email" class="form-control" type="email" value="{{ old('email', $edit->email) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lodge Area</label>
                                <select id="lodge_id" name="lodge_id" class="form-control" id="sel1" name="sellist1" required>
                                    <option value="">Select</option>
                                    @foreach ($lodges as $display)
                                    <option value="{{ $display->lodge_id }}" {{ old('lodge_id', $edit->lodge_id) == $display->lodge_id ? 'selected' : '' }}>{{ $display->area }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Role</label>
                                <select id="position" name="position" class="form-control" id="sel1" name="sellist1" required>
                                    <option>Select</option>
                                    <option value="2" {{ old('position', $edit->position) == '2' ? 'selected' : '' }}>Front Desk</option>
                                    <option value="1" {{ old('position', $edit->position) == '1' ? 'selected' : '' }}>Front Desk</option>
                                    <option value="0" {{ old('position', $edit->position) == '0' ? 'selected' : '' }}>Housekeepings</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" name="password" class="form-control" type="password" value="{{ old('password', $edit->password) }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary buttonedit">Create Employee</button>
                </form>
                @endisset
            </div>
        </div>
    </div>
@endsection
