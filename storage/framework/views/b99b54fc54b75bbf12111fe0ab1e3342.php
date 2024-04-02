<?php $__env->startSection('content'); ?>

<style>
    .container {
        padding-top: 5rem;
        padding: 2rem;
    }
    .slider-wrapper {
        position: relative;
        max-width: 48rem;
        margin: 0 auto;
    }
    .carousel-inner {
        display: flex;
        aspect-ratio: 16/9;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        box-shadow: 0 1.5rem 3rem -0.75rem hsla(0, 0%, 0%, 0.25);
        border-radius: 0.5rem;
    }

    .carousel-inner::-webkit-scrollbar {
        display: none;
    }

    .carousel-inner img {
        flex: 1 0 100%;
        scroll-snap-align: start;
        object-fit: cover;
    }
    .slider-nav {
        display: flex;
        column-gap: 1rem;
        position: absolute;
        bottom: 1.25rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1;
    }
    .slider-nav a {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background-color: #fff;
        opacity: 0.75;
        transition: opacity ease 250ms;
    }
    .slider-nav a:hover {
        opacity: 1;
    }
    .card-title {
        text-align: center;
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
<link rel="stylesheet" href="<?php echo e(asset('assets/css/lightbox.min.css')); ?>">
<div class="container">
    <div class="col-md-12">
        <div class="card" style="width: 65rem;">
            <?php if($roomImages && !$roomImages->isEmpty()): ?>
            <div class="carousel slide" id="carouselExample" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div uk-grid uk-lightbox="animation: scale">
                        <?php $__currentLoopData = $roomImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="carousel-item <?php echo e($key === 0 ? 'active' : ''); ?>">
                                <a href="<?php echo e(asset('room-image/' . $image->img)); ?>" data-lightbox="room-images">
                                    <img src="<?php echo e(asset('room-image/' . $image->img)); ?>" class="img-fluid d-block w-100" alt="Image">
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#carouselExample').carousel({
                        interval: 3000,
                        pause: 'hover',
                        wrap: true
                    });
                });
            </script>
            <?php else: ?>
                <p>No Images</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container">
    <h2 class="text-center mt-4 mb-4">Room <?php echo e($room->room_no); ?></h2>
    <div class="row">
        <div class="col-sm-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <?php if($room->LodgeAreas): ?>
                        <h4 class="card-title"><?php echo e($room->LodgeAreas->area); ?></h4>
                    <?php else: ?>
                        <p>No Lodging Area Found for this Room</p>
                    <?php endif; ?>
                    <ul class="list-unstyled d-grid gap-3">
                        <li><strong class="text-center">Size: <span class="badge badge-pill bg-success inv-badge"><?php echo e($room->size); ?></span></strong></li>
                        <li><strong class="text-center">Occupants: <span class="badge badge-pill bg-success inv-badge"><?php echo e($room->occupants); ?></span></strong></li>
                        <li><strong class="text-center">Bed-Type: <span class="badge badge-pill bg-success inv-badge"><?php echo e($room->bed_type); ?></span></strong></li>
                        <li><strong class="text-center">Room-Type: <span class="badge badge-pill bg-success inv-badge"><?php echo e($room->room_type); ?></span></strong></li>
                        <li><strong class="text-center">Price: <span class="badge badge-pill bg-success inv-badge"><?php echo e($room->price); ?></span></strong></li>
                        <?php
                            $statusClass = '';

                            switch ($room->status) {
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
                        <li><strong class="text-center">Status: <button class="form-select badge badge-pill mb-2" style="width: 65%; <?php echo e($statusClass); ?>;" data-toggle="modal" data-target="#statusModal"><?php echo e($room->status); ?></button></strong></li>
                        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="statusModalLabel">Update Rooms Status</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="<?php echo e(route('admin.update-status', ['roomId' => $room->room_id])); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                            <div class="modal-body">
                                                <div class="btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-primary <?php echo e($room->status == 'Inspected' ? 'active' : ''); ?>" style="background-color: #A5DD9B;">
                                                        <input type="checkbox" name="status" value="Inspected" autocomplete="off"> Inspected
                                                    </label>
                                                    <label class="btn btn-primary <?php echo e($room->status == 'Vacant Clean' ? 'active' : ''); ?>" style="background-color: #30E3CA;">
                                                        <input type="checkbox" name="status" value="Vacant Clean" autocomplete="off">Vacant Clean
                                                    </label>
                                                    <label class="btn btn-primary <?php echo e($room->status == 'Vacant Dirty' ? 'active' : ''); ?>" style="background-color: #F6B132;">
                                                        <input type="checkbox" name="status" value="Vacant Dirty" autocomplete="off">Vacant Dirty
                                                    </label>
                                                    <label class="btn btn-primary <?php echo e($room->status == 'Occupied Dirty' ? 'active' : ''); ?>" style="background-color: #FF9843;">
                                                        <input type="checkbox" name="status" value="Occupied Dirty" autocomplete="off">Occupied Dirty
                                                    </label>
                                                    <label class="btn btn-primary <?php echo e($room->status == 'Occupied Clean' ? 'active' : ''); ?>" style="background-color: #C1E1C1;">
                                                        <input type="checkbox" name="status" value="Occupied Clean" autocomplete="off">Occupied Clean
                                                    </label>
                                                    <label class="btn btn-primary <?php echo e($room->status == 'Out of Order' ? 'active' : ''); ?>" style="background-color: #C1E1C1;">
                                                        <input type="checkbox" name="status" value="Out of Service" autocomplete="off">Out of Service
                                                    </label>
                                                    <label class="btn btn-primary <?php echo e($room->status == 'Out of Service' ? 'active' : ''); ?>" style="background-color: #D04848;">
                                                        <input type="checkbox" name="status" value="Out of Order" autocomplete="off">Out of Order
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn  btn-primary">Save changes</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <li><button id="view" class="badge badge-pill bg-success" data-room-id="<?php echo e($room->room_id); ?>">View Cleaning History</button></li>
                    </ul>
                    <a href="<?php echo e(route('admin.edit-room', $room->room_id)); ?>" class="btn btn-outline-primary p-2 bd-highlight">Edit</a>
                    <button type="button" class="btn btn-outline-danger p-2 bd-highlight" onclick="deleteRoom(<?php echo e($room->room_id); ?>)">Delete</button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="star-rating" style="color: #<?php echo e($room->averageStars ? 'ffcc00' : 'ccc'); ?>; font-size: 50px;">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= $room->averageStars): ?>
                                &#9733; 
                            <?php elseif($i - 0.5 <= $room->averageStars): ?>
                                &#9733; 
                            <?php else: ?>
                                &#9734; 
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <?php if($amenities->isNotEmpty()): ?>
                        <div class="row">
                            <?php $__currentLoopData = $amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-2">
                                    <div class="card">
                                        <h5 class="card-title badge badge-pill bg-success"><?php echo e($amenity->name); ?></h5>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p>No Amenities are found</p>
                    <?php endif; ?>
                    <p class="card-text"><?php echo e($room->description); ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <?php $__currentLoopData = $room->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <div class="card-body">
                    <label class="badge rounded-pill bg-info text-dark"><?php echo e($subject); ?></label><br>
                    <!-- Display Yellow Stars -->
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= $room->stars[$key]): ?>
                            <span style="color: rgb(215, 219, 9);">&#9733;</span> 
                        <?php elseif($i - 0.5 <= $room->stars[$key]): ?>
                            <span style="color: rgb(215, 219, 9);">&#9733;</span> 
                        <?php else: ?>
                            <span style="color: rgb(215, 219, 9);">&#9734;</span> 
                        <?php endif; ?>
                    <?php endfor; ?>
                    <br>
                    <?php echo e($room->comments[$key]); ?>

                </div>
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
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
    document.getElementById('view').addEventListener('click', function() {
        const roomId = this.dataset.roomId;

        // Prompt the user to input the date
        Swal.fire({
            title: 'Search Cleaning History',
            html: '<input id="swal-search-input" class="swal2-input" placeholder="Enter Date (YYYY-MM-DD)">',
            showCancelButton: true,
            confirmButtonText: 'Search',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                // Get the search query from the input field
                const searchQuery = document.getElementById('swal-search-input').value;

                // Send an AJAX request to fetch cleaning history filtered by the date
                return fetch(`/cleaning-history/${roomId}/search?q=${searchQuery}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch data');
                        }
                        return response.json();
                    })
                    .then(data => {
                        let message = "<ul>";
                        if (data && data.length > 0) {
                            data.forEach(entry => {
                                // Process each cleaning history entry
                                let position;
                                switch (entry.users.position) {
                                    case 1:
                                        position = 'Admin';
                                        break;
                                    case 2:
                                        position = 'Front-Desk';
                                        break;
                                    case 3:
                                        position = 'Housekeepers';
                                        break;
                                    default:
                                        position = 'Unknown Position';
                                        break;
                                }
                                message += `<li><strong>${position}</strong> (${entry.users.first_name} ${entry.users.last_name}) changed the status of the room at ${entry.clean_date}</li>`;
                            });
                        } else {
                            message = "<li>No cleaning history available</li>";
                        }
                        message += "</ul>";

                        // Display the cleaning history to the user
                        Swal.fire({
                            title: 'Cleaning History',
                            html: message,
                            icon: 'info'
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching cleaning history:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to fetch cleaning history data. Please try again later.',
                            icon: 'error'
                        });
                    });
            }
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HMS\resources\views/Admin/room_details.blade.php ENDPATH**/ ?>