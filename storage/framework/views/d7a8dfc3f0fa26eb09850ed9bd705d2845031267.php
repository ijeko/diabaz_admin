<?php $__env->startSection('content'); ?>
    <div id="app">
      <home-wrapper-component
      :user="<?php echo e(\Illuminate\Support\Facades\Auth::id()); ?>"
      ></home-wrapper-component>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/evgeny/PhpstormProjects/diabaz/admin/resources/views/inputdata.blade.php ENDPATH**/ ?>