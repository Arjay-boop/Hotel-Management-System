@extends('Admin.layout')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <div class="mt-5">
                    <h4 class="card-title float-left mt-2">Employee</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="row formtype">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Employee Name</label>
                            <input type="search" class="form-control" id="searchInput" placeholder="Search">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lodge Area</label>
                            <select id="lodge" value="" class="form-control">
                                <option value="*">Select</option>
                                @foreach($lodges as $lodge)
                                    <option value="{{ $lodge->lodge_id }}">{{ $lodge->area }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" id="position" name="sellist1">
                                <option value="*">Select</option>
                                <option value="2">Front Desk</option>
                                <option value="3">Houskeepings</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.add-employees') }}" class="btn btn-primary float-right veiwbutton">Add Employee</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-center" id="employeeTable">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Full Name</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Phone No.</th>
                    <th class="text-center">Birthday</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Lodging Area</th>
                    <th class="text-center">Position</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="employeeTableBody">
                @php $counter = 1 @endphp
                @if ($employees->isEmpty())
                <tr>
                    <td colspan="10">
                        <h1>No Records</h1>
                    </td>
                </tr>
                @else
                    @foreach ($employees as $employee)
                        <tr>
                            <td class="text-center">{{ $counter++ }}</td>
                            <td class="text-center">
                                {{ $employee->first_name }}
                                {{ $employee->middle_name }}
                                {{ $employee->last_name }}
                            </td>
                            <td class="text-center">
                                <span class="badge badge-pill bg-success inv-badge">{{ $employee->gender }}</span>
                            </td>
                            <td class="text-center">
                                <div>{{ $employee->phone_no }}</div>
                            </td>
                            <td class="text-center">{{ $employee->birthdate }}</td>
                            <td class="text-center">{{ $employee->email }}</td>
                            <td class="text-center">
                                <span class="badge badge-pill bg-success inv-badge">{{ $employee->LodgeAreas->area }}</span>
                            </td>
                            @php
                                $position = $employee->position;
                                $displayText = '';

                                switch ($position) {
                                    case 3  :
                                        $displayText = 'Housekeepers';
                                        break;
                                    case 1:
                                        $displayText = 'Admin';
                                        break;
                                    case 2:
                                        $displayText = 'Front Desk';
                                        break;
                                    default:
                                        $displayText = 'Unknown Position';
                                        break;
                                }
                            @endphp
                            <td class="text-center">
                                <span class="badge badge-pill bg-success inv-badge">{{ $displayText }}</span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v ellipse_color"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('admin.edit-employee', $employee->user_id) }}">
                                            <i class="fas fa-pencil-alt m-r-5"></i> Edit
                                        </a>
                                        <a class="dropdown-item bookingDelete" href="#" data-toggle="modal" data-target="#deleteConfirmation">
                                            <i class="fas fa-trash-alt m-r-5"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>

    <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">%times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    @isset($employee)
                        <form id="deleteForm" action="{{ route('admin.delete-employee', ['id' => $employee->user_id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
                        </form>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                @isset($employee)
                    <form id="deleteForm" action="{{ route('admin.delete-lodge', $employee->user_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
                    </form>
                @endisset
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#searchInput, #lodge, #position').on('change keyup', function(){
            var searchTerm = $('#searchInput').val().trim();
            var lodgeId = $('#lodge').val().trim();
            var position = $('#position').val().trim();

            $.ajax({
                url: "{{ route('admin.filter.employees') }}",
                method: "GET",
                data: {
                    search: searchTerm,
                    lodgeId: lodgeId,
                    position: position,
                },
                success: function(response) {
                    var employeeTableBody = $('#employeeTableBody');
                    employeeTableBody.empty();

                    response.forEach(function(employee, index) {
                        var counter = index + 1;
                        var fullName = `${employee.first_name} ${employee.middle_name} ${employee.last_name}`.trim();

                        var positionText;
                        switch (employee.position) {
                            case 1:
                                positionText = 'Admin';
                                break;
                            case 2:
                                positionText = 'Front-Desk';
                                break;
                            case 3:
                                positionText = 'Housekeeper';
                                break;
                            default:
                                positionText = 'Unknow Position';
                                break;
                        }
                        var employeeRow = `
                        <tr>
                            <td class="text-center">${counter}</td>
                            <td class="text-center">${fullName}</td>
                            <td class="text-center">
                                <span class="badge badge-pill bg-success inv-badge">${employee.gender}</span>
                            </td>
                            <td class="text-center">${employee.phone_no}</td>
                            <td class="text-center">${employee.birthdate}</td>
                            <td class="text-center">${employee.email}</td>
                            <td class="text-center">
                                <span class="badge badge-pill bg-success inv-badge">${employee.lodge_id}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-pill bg-success inv-badge">${positionText}</span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v ellipse_color"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="${employee.editLink}">
                                            <i class="fas fa-pencil-alt m-r-5"></i> Edit
                                        </a>
                                        <a class="dropdown-item bookingDelete" href="#" data-toggle="modal" data-target="#deleteConfirmation">
                                            <i class="fas fa-trash-alt m-r-5"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>`;

                        employeeTableBody.append(employeeRow);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>

@endsection