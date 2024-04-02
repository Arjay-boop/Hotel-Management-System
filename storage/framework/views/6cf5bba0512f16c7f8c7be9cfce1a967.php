<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title mt-5">Add Lodge Area</h3> </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="<?php echo e(route('store-lodge')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row formtype">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lodge Name</label>
                            <input id="area" name="area" class="form-control" type="text" value="" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Numbers of Rooms</label>
                            <input id="total_rooms" name="total_rooms" class="form-control" type="text" value="" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select id="status" name="status" class="form-control" id="sel1" name="sellist1" required>
                                <option>Select</option>
                                <option>Available</option>
                                <option>Maintenance</option>
                                <option>Under Construction</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Location</label>
                            <input id="location" name="location" class="form-control" type="text" value="" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image[]" class="form-control" id="" multiple>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary buttonedit">Create Lodge Area</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HMS\resources\views/Admin/add_lodge_areas.blade.php ENDPATH**/ ?>