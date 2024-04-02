<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="col">
            <div class="col-sm-6 mt-5">
                <h3 class="page-title mt-3">Room</h3>
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
                    <button class="form-select badge badge-pill mb-2" style="width: 65%; <?php echo e($statusClass); ?>;" data-toggle="modal" data-target="#statusModal"><?php echo e($rooms->status); ?></button>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Modal for updating room status and amenities -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Room Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('housekeeper.update-room', ['roomId' => $rooms->room_id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <?php if($rooms->status === 'Occupied Clean' || $rooms->status === 'Occupied Dirty'): ?>
                        <!-- Display form for selecting amenities -->
                        <div class="form-group">
                            <label>Select Amenities:</label>
                            <?php $__currentLoopData = $rooms->Amenity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="<?php echo e($amenity->id); ?>">
                                    <label class="form-check-label"><?php echo e($amenity->name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-primary <?php echo e($rooms->status == 'Inspected' ? 'active' : ''); ?>" style="background-color: #A5DD9B;">
                                <input type="checkbox" name="status" value="Inspected" autocomplete="off"> Inspected
                            </label>
                            <label class="btn btn-primary <?php echo e($rooms->status == 'Vacant Clean' ? 'active' : ''); ?>" style="background-color: #30E3CA;">
                                <input type="checkbox" name="status" value="Vacant Clean" autocomplete="off">Vacant Clean
                            </label>
                            <label class="btn btn-primary <?php echo e($rooms->status == 'Vacant Dirty' ? 'active' : ''); ?>" style="background-color: #F6B132;">
                                <input type="checkbox" name="status" value="Vacant Dirty" autocomplete="off">Vacant Dirty
                            </label>
                            <label class="btn btn-primary <?php echo e($rooms->status == 'Occupied Dirty' ? 'active' : ''); ?>" style="background-color: #FF9843;">
                                <input type="checkbox" name="status" value="Occupied Dirty" autocomplete="off">Occupied Dirty
                            </label>
                            <label class="btn btn-primary <?php echo e($rooms->status == 'Occupied Clean' ? 'active' : ''); ?>" style="background-color: #C1E1C1;">
                                <input type="checkbox" name="status" value="Occupied Clean" autocomplete="off">Occupied Clean
                            </label>
                            <label class="btn btn-primary <?php echo e($rooms->status == 'Out of Order' ? 'active' : ''); ?>" style="background-color: #C1E1C1;">
                                <input type="checkbox" name="status" value="Out of Service" autocomplete="off">Out of Service
                            </label>
                            <label class="btn btn-primary <?php echo e($rooms->status == 'Out of Service' ? 'active' : ''); ?>" style="background-color: #D04848;">
                                <input type="checkbox" name="status" value="Out of Order" autocomplete="off">Out of Order
                            </label>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Housekeeper.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HMS\resources\views/Housekeeper/rooms.blade.php ENDPATH**/ ?>