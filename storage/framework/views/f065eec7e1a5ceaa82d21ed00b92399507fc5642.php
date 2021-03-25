<?php $__env->startSection('content'); ?>
    <div id="app">
      <admin-wrapper-component
      :user="<?php echo e(\Illuminate\Support\Facades\Auth::id()); ?>"
      ></admin-wrapper-component>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/evgeny/PhpstormProjects/diabaz/admin/resources/views/admin.blade.php ENDPATH**/ ?>