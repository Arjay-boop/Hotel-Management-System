@extends('Admin.layout')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title mt-5">Add Employee</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('admin.store-employee') }}">
                @csrf
                <div class="row formtype">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>First Name</label>
                            <input id="first_name" name="first_name" class="form-control" type="text" value="" required> </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input id="middle_name" name="middle_name" class="form-control" type="text" value="" required> </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input id="last_name" name="last_name" class="form-control" type="text" value="" required> </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sex</label>
                            <select id="gender" name="gender" class="form-control" id="sel1" name="sellist1" required>
                                <option>Select</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input id="phone_no" name="phone_no" class="form-control" type="text" value="" required> </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Birthday</label>
                            <input id="birthdate" name="birthdate" class="form-control" type="date" value="" required> </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input id="email" name="email" class="form-control" type="email" value="" required autocomplete="off"> </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lodge Area</label>
                            <select id="lodge_id" name="lodge_id" class="form-control" id="sel1" name="sellist1" required>
                                <option>Select</option>
                                @foreach ($lodges as $display)
                                    <option value="{{ $display['area'] }}">{{ $display['area'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Role</label>
                            <select id="position" value="" name="position" class="form-control" id="sel1" name="sellist1" required>
                                <option value="" selected disabled>Select</option>
                                <option value="2">Front Desk</option>
                                <option value="0">Housekeepings</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" name="password" class="form-control" type="password" value="password" required autocomplete="off"> </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary buttonedit">Create Employee</button>
                <a href="{{ route('admin.employee') }}" type="button" class="btn btn-warning">Cancel</a>
            </form>
        </div>
    </div>
</div>


<script>
    window.onload = function() {
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
    }
</script>


@endsection
