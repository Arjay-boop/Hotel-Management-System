@extends('Admin.layout')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title mt-5">Add Amenities</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('admin.store-amenity') }}" method="POST">
                    @csrf
                    <div class="row formtype">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Items</label>
                                <input type="text" name="name" id="name" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" name="price" id="price" class="form-control" value="" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary buttonedit">Add Amenities</button>
                </form>
            </div>
        </div>
    </div>
@endsection
