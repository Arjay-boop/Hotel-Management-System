@extends('Housekeeper.layout')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12 mt-5">
                <h3 class="page-title mt-3">Good Morning {{ $fullname }}!</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header"></h3>
                            <h6 class="text-muted">Occupied Room</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0"> <i class="fas fa-briefcase"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header"></h3>
                            <h6 class="text-muted">Total Rooms</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0"><i class="fas fa-key"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header"></h3>
                            <h6 class="text-muted">Arrival Today</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0"> <i class="fas fa-door-open"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header"></h3>
                            <h6 class="text-muted">Total of Dirty Rooms</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <i class="fas fa-broom"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
