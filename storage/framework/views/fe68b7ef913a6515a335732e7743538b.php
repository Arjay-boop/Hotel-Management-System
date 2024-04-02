<?php $__env->startSection('content'); ?>
<style>
    /* Style for carousel images */
    .carousel-inner img {
        width: 100%;
        height: 300px; /* Set a fixed height for consistency */
        object-fit: cover; /* Ensure the image covers the specified dimensions */
    }

</style>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12 mt-5">
                <h3 class="page-title mt-3">Lodge Areas</h3>
                <a href="<?php echo e(route('admin.add-lodge')); ?>" class="btn btn-primary">Add Lodge Area</a>
            </div>
        </div>
    </div>
    <div class="row">
        <?php $__currentLoopData = $lodgingArea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lodge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 col-lg-6">
                <div class="card card-chart">
                    <?php if($lodge->Images->isNotEmpty()): ?>
                    <div id="carouselExample<?php echo e($loop->iteration); ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $lodge->Images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($key === 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e(asset('lodge-image/' . $image->img)); ?>" class="d-block w-100" alt="Image">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <script>
                        // JavaScript to enable automatic slideshow for each carousel
                        $(document).ready(function () {
                                $('#carouselExample<?php echo e($loop->iteration); ?>').carousel({
                                    interval: 3000,
                                    pause: 'hover',
                                    wrap: true
                                });
                            });
                    </script>
                    <?php endif; ?>
                    <div class="card-header d-flex bd-highlight align-items-center">
                        <h4 class="card-title p-2 flex-grow-1 bd-highlight"><?php echo e($lodge->area); ?></h4>
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v ellipse_color"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?php echo e(route('admin.edit-lodge', $lodge->lodge_id)); ?>">
                                    <i class="fas fa-pencil-alt m-r-5"></i> Edit
                                </a>
                                <a class="dropdown-item bookingDelete" href="#" data-toggle="modal" data-target="#deleteConfirmation">
                                    <i class="fas fa-trash-alt m-r-5"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-title">Total Rooms <?php echo e($lodge->total_rooms); ?></p>
                        <p class="card-title">Location <?php echo e($lodge->location); ?></p>
                        <span class="badge badge-pill bg-success inv-badge"><?php echo e($lodge->status); ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php if(isset($lodge)): ?>
                    <form id="deleteForm" action="<?php echo e(route('admin.delete-lodge', $lodge->lodge_id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HMS\resources\views/Admin/lodge_areas.blade.php ENDPATH**/ ?>