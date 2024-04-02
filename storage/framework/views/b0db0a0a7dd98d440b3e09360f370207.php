<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title mt-5">Add Room</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="<?php echo e(route('admin.store-room')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row formtype">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Room Number</label>
                                <input id="room_no" name="room_no" class="form-control" type="text" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Room Type</label>
                                <select name="room_type" id="types" class="form-control" required>
                                    <option selected>Select</option>
                                    <option value="Single Room">Single Room</option>
                                    <option value="Double Bed Room">Double Bed Room</option>
                                    <option value="Deluxe">Deluxe</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bed</label>
                                <select name="bed_type" id="bed_type" class="form-control" required>
                                    <option selected>Select</option>
                                    <option value="Queen Bed">Queen Bed</option>
                                    <option value="King Bed">King Bed</option>
                                    <option value="Twin Size Bed">Twin Size Bed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Price</label>
                                <input id="price" name="price" type="text" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Occupants</label>
                                <input type="text" name="occupants" id="occupants" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option selected>Select</option>
                                    <option value="Inspected">Inspected</option>
                                    <option value="Vacant Clean">Vacant Clean</option>
                                    <option value="Vacant Dirty">Vacant Dirty</option>
                                    <option value="Occupied Dirty">Occupied Dirty</option>
                                    <option value="Occupied Clean">Occupied Clean</option>
                                    <option value="Out of Order">Out of Order</option>
                                    <option value="Out of Service">Out of Service</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Size</label>
                                <input type="text" name="size" id="size" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lodge Area</label>
                                <select name="lodge_id" id="lodge_id" class="form-control">
                                    <option selected>Select</option>
                                    <?php $__currentLoopData = $lodges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lodge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lodge->area); ?>"><?php echo e($lodge->area); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="container">
                                <label>Amenities</label>
                                <div class="card">
                                    <div class="form-group row" style="max-height: 100px; overflow-y: auto;">
                                        <?php $count = 0; ?>
                                        <?php $__currentLoopData = $amenity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenities): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <input type="checkbox" name="amenities[]" class="form-check-input" value="<?php echo e($amenities->amenity_id); ?>" id="amenity_<?php echo e($amenities->amenity_id); ?>">
                                                    <label class="form-check-label" for="amenity_<?php echo e($amenities->amenity_id); ?>">
                                                        <?php echo e($amenities->name); ?>

                                                    </label>
                                                </div>
                                            </div>
                                            <?php $count++; ?>
                                            <?php if($count % 2 === 0): ?>
                                                <div class="w-100"></div> <!-- Add a new row after every 2 columns -->
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Image</label>
                                <input type="file" name="img[]" id="formFile" class="form-control" multiple required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary buttonedit">Create Room</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HMS\resources\views/Admin/add_room.blade.php ENDPATH**/ ?>