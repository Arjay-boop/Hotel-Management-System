<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title mt-5">Edit Lodge Area</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="<?php echo e(route('admin.update-lodge', ['id' => $lodge->lodge_id])); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row formtype">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lodge Name</label>
                            <input id="area" name="area" class="form-control" type="text" value="<?php echo e($lodge->area); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Numbers of Rooms</label>
                            <input id="total_rooms" name="total_rooms" class="form-control" type="text" value="<?php echo e($lodge->total_rooms); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select id="status" name="status" class="form-control" required>
                                <option>Select</option>
                                <option value="Available" <?php echo e($lodge->status === 'Available' ? 'selected' : ''); ?>>Available</option>
                                <option value="Maintenance" <?php echo e($lodge->status === 'Maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                                <option value="Under Construction" <?php echo e($lodge->status === 'Under Construction' ? 'selected' : ''); ?>>Under Construction</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Location</label>
                            <input id="location" name="location" class="form-control" type="text" value="<?php echo e($lodge->location); ?>" required>
                        </div>
                    </div>
                    <!-- Display existing images -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Choose action for image:</label><br>
                            <input type="radio" name="image_action" id="replaceImages" value="replace">
                            <label for="replaceImages">Replace Images</label><br>
                            <input type="radio" name="image_action" id="appendImages" value="append">
                            <label for="appendImages">Append Images</label><br>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image[]" class="form-control" id="" multiple>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary buttonedit">Update Lodge Area</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HMS\resources\views/Admin/edit_lodge_areas.blade.php ENDPATH**/ ?>