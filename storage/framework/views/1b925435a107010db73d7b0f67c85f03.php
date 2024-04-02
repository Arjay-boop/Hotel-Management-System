<?php $__env->startSection('content'); ?>

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
            <form action="<?php echo e(route('admin.update-room', ['id' => $room->room_id])); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row formtype">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Room Number</label>
                            <input type="text" name="room_no" id="room_no" class="form-control" value="<?php echo e(old('room_no', $room->room_no)); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="room_type" id="room_type" class="form-control" required>
                                <option disabled>Select</option>
                                <option value="Single Room" <?php echo e(old('room_type', $room->room_type) == 'Single Room' ? 'selected' : ''); ?>>Single Room</option>
                                <option value="Double Bed Room" <?php echo e(old('room_type', $room->room_type) == 'Double Bed Room' ? 'selected' : ''); ?>>Double Bed Room</option>
                                <option value="Deluxe" <?php echo e(old('room_type', $room->room_type) == 'Deluxe' ? 'selected' : ''); ?>>Deluxe</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bed</label>
                            <select name="bed_type" id="bed_type" class="form-control" required>
                                <option disabled>Select</option>
                                <option value="Queen Bed" <?php echo e(old('bed_type', $room->bed_type) == 'Queen Bed' ? 'selected' : ''); ?>>Queen Bed</option>
                                <option value="King Bed" <?php echo e(old('bed_type', $room->bed_type) == 'King Bed' ? 'selected' : ''); ?>>King Bed</option>
                                <option value="Twin Size Bed" <?php echo e(old('bed_type', $room->bed_type) == 'Twin Size Bed' ? 'selected' : ''); ?>>Twin Size Bed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" id="price" class="form-control" value="<?php echo e(old('price', $room->price)); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Occupants</label>
                            <input type="text" name="occupants" id="occupants" class="form-control" value="<?php echo e(old('occupants', $room->occupants)); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option disabled>Select</option>
                                <option value="Inspected" <?php echo e(old('status', $room->status) == 'Inspected' ? 'selected' : ''); ?>>Inspected</option>
                                <option value="Vacant Clean" <?php echo e(old('status', $room->status) == 'Vacant Clean' ? 'selected' : ''); ?>>Vacant Clean</option>
                                <option value="Vacant Dirty" <?php echo e(old('status', $room->status) == 'Vacant Dirty' ? 'selected' : ''); ?>>Vacant Dirty</option>
                                <option value="Occupied Clean" <?php echo e(old('status', $room->status) == 'Occupied Clean' ? 'selected' : ''); ?>>Occupied Clean</option>
                                <option value="Occupied Dirty" <?php echo e(old('status', $room->status) == 'Occupied Dirty' ? 'selected' : ''); ?>>Occupied Dirty</option>
                                <option value="Out of Service" <?php echo e(old('status', $room->status) == 'Out of Service' ? 'selected' : ''); ?>>Out of Service</option>
                                <option value="Out of Order" <?php echo e(old('status', $room->status) == 'Out of Order' ? 'selected' : ''); ?>>Out of Order</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Size</label>
                            <input type="text" name="size" id="size" class="form-control" value="<?php echo e(old('size', $room->size)); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lodge Area</label>
                            <select name="lodge_id" id="lodge_id" class="form-control" required>
                                <option disabled>Select</option>
                                <?php $__currentLoopData = $lodges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lodge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lodge->lodge_id); ?>" <?php echo e(old('lodge_id', $room->lodge_id) == $lodge->lodge_id ? 'selected' : ''); ?>><?php echo e($lodge->area); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="container">
                            <label>Amenities</label>
                            <div class="card">
                                <div class="form-group row">
                                    <?php
                                        $count = 0;
                                    ?>
                                    <?php $__currentLoopData = $amenity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenities): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input type="checkbox" name="amenities[]" id="amenity_<?php echo e($amenities->amenity_id); ?>" class="form-check-input" value="<?php echo e($amenities->amenity_id); ?>"
                                                    <?php echo e(in_array($amenities->amenity_id, $room->Amenity->pluck('amenity_id')->toArray()) ? 'checked' : ''); ?>>
                                                <label for="amenity_<?php echo e($amenities->amenity_id); ?>" class="form-check-label"><?php echo e($amenities->name); ?></label>
                                            </div>
                                        </div>
                                        <?php
                                            $count++;
                                        ?>
                                        <?php if($count % 2 === 0): ?>
                                            <div class="w-100"></div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <textarea name="description" id="description" class="form-control" rows="10"><?php echo e(old('description', $room->description)); ?></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary buttonedit">Update Room</button>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HMS\resources\views/Admin/edit_room.blade.php ENDPATH**/ ?>