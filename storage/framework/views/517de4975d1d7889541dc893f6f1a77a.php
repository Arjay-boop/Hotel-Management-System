<?php $__env->startSection('content'); ?>
<style>
    .star.rating {
        font-size: 2rem;
    }

    .star.rating::before {
        content: '\2605';
        color: #ffcc00;
    }
    .btn-group-toggle label {
        margin-right: 8px;
        margin-top: 4px;
        border: none;
        color: black;
    }
    button {
        border: none;
    }
    button:hover {
        color: white;
    }
</style>

<div class="content container-fluid">
    <div class="page-header">
        <div class="col">
            <div class="col-sm-6 mt-5">
                <h3 class="page-title mt-3">Room</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="">
                    <div class="row formtype">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Room Number</label>
                                <input type="search" placeholder="search" id="searchInput" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Lodge Area</label>
                                <select class="form-control" name="lodge_id" id="lodge_id">
                                    <option value="*">Select</option>
                                    <?php $__currentLoopData = $lodges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lodge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lodge->lodge_id); ?>"><?php echo e($lodge->area); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="*">Select</option>
                                    <option value="Single Room">Single Room</option>
                                    <option value="Double Bed Room">Double Bed Room</option>
                                    <option value="Deluxe">Deluxe</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <a href="<?php echo e(route('admin.add-room')); ?>" class="btn btn-primary viewbutton">Add Rooms</a>
                                </div>
                                <div class="col-md-8 mt-3">
                                    <a href="<?php echo e(route('admin.add-amenity')); ?>" class="btn btn-primary viewbutton">Add Amenities</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <?php $__currentLoopData = $room; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rooms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4 mb-3">
            <div class="card" id="card" style="width: 18rem;">
                <?php if($rooms->Images->isNotEmpty()): ?>
                <div class="carouselExample<?php echo e($loop->iteration); ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php $__currentLoopData = $rooms->Images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="carousel-item <?php echo e($key === 0 ? 'active' : ''); ?>">
                                <img src="<?php echo e(asset('room-image/' .$image->img)); ?>" class="d-block w-100 img-fluid" style="height: 200px;" alt="Image">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <script>
                    $(document).ready(function (){
                        $('#carouselExample<?php echo e($loop->iteration); ?>').carousel({
                            interval: 3000,
                            pause: 'hover',
                            wrap: true
                        });
                    });
                </script>
                <?php endif; ?>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Room <?php echo e($rooms->room_no); ?></h5>
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v ellipse_color"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?php echo e(route('admin.edit-room', $rooms->room_id)); ?>">
                                    <i class="fas fa-pencil-alt m-r-5"></i> Edit
                                </a>
                                <a class="dropdown-item bookingDelete" onclick="deleteRoom(<?php echo e($rooms->room_id); ?>)">
                                    <i class="fas fa-trash-alt m-r-5"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                    <span class="badge badge-pill bg-success inv-badge"><?php echo e($rooms->LodgeAreas->area); ?></span><br>
                    <?php
                        $statusClass = '';

                        switch ($rooms->status) {
                            case 'Inspected':
                                # code...
                                $statusClass = 'background-color: #A5DD9B;';
                                break;

                            case 'Vacant Clean':
                                # code...
                                $statusClass = 'background-color: #30E3CA;';
                                break;

                            case 'Vacant Dirty':
                                # code...
                                $statusClass = 'background-color: #F6B132;';
                                break;

                            case 'Occupied Dirty':
                                #code...
                                $statusClass = 'background-color: #FF9843;';
                                break;

                            case 'Occupied Clean':
                                #code...
                                $statusClass = 'background-color: #40A2E3;';
                                break;

                            case 'Out of Order':
                                #code...
                                $statusClass = 'background-color: #D04848;';
                                break;

                            case 'Out of Service':
                                #code...
                                $statusClass = 'background-color: #C1E1C1;';
                                break;

                            default:
                                # code...
                                $statusClass = 'background-color: #023020;';
                                break;
                        }
                    ?>
                    <div class="star-rating" style="color: #<?php echo e($rooms->averageRating ? 'ffcc00' : 'ccc'); ?>">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= $rooms->averageRating): ?>
                                &#9733;
                            <?php elseif($i - 0.5 <= $rooms->averageRating): ?>
                                &#9733;
                            <?php else: ?>
                                &#9734;
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <br>
                    <span class="form-select badge badge-pill mb-2" style="width: 65%; <?php echo e($statusClass); ?>;">
                        <?php echo e($rooms->status); ?>

                    </span>

                    <a href="<?php echo e(route('admin.details-room', ['room_id' => $rooms->room_id])); ?>" class="btn btn-primary">Details</a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btn-group-toggle input[type="checkbox"]').on('change', function() {
            $('.btn-group-toggle input[type="checkbox"]').not(this).prop('checked', false).parent().removeClass('active');
            $(this).parent().toggleClass('active', $(this).is(':checked'));
        });
    });
    function deleteRoom(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/Admin/Delete-Room/" + id, // Make sure the URL includes the room ID
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>"
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            'Room has been deleted.',
                            'success'
                        )
                        location.reload();
                    }
                });
            }
        })
    }
    $(document).ready(function() {
        $('#searchInput, #lodge, #type').on('change keyup', function(){
            var searchTerm = $('#searchInput').val().trim();
            var lodgeId = $('#lodge_id').val().trim();
            var roomType = $('#type').val().trim();

            $.ajax({
                url: "<?php echo e(route('admin.filter-room')); ?>",
                method: "GET",
                data: {
                    search: searchTerm,
                    lodgeId: lodgeId,
                    roomType: roomType,
                },
                success: function(response) {
                    var roomCards = $('#card');
                    roomCards.empty();

                    response.forEach(function(room, index) {
                        var counter = index + 1;
                        var roomTypeText;
                        switch (room.room_type) {
                            case 1:
                                roomTypeText = 'Single';
                                break;
                            case 2:
                                roomTypeText = 'Double';
                                break;
                            case 3:
                                roomTypeText = 'Suite';
                                break;
                            default:
                                roomTypeText = 'Unknown';
                                break;
                        }
                        var roomCard = `
                        <div class="col-md-4 mb-3">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Room ${room.room_no}</h5>
                                    <p class="card-text">Lodge Area: ${room.LodgeAreas.area}</p>
                                    <p class="card-text">Room Type: ${roomTypeText}</p>
                                    <p class="card-text">Price: ${room.price}</p>
                                    <a href="${room.editLink}" class="btn btn-primary">Edit</a>
                                    <button type="button" class="btn btn-danger" onclick="deleteRoom(${room.room_id})">Delete</button>
                                </div>
                            </div>
                        </div>`;

                        roomCards.append(roomCard);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HMS\resources\views/Admin/room.blade.php ENDPATH**/ ?>