<template>
    <div class="wrapper">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "componentLoader",
}
</script>

<style scoped>
.wrapper {
    /*background-color: #1f6fb2;*/
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 99;
    /*top: 0;*/
    /*bottom: 0;*/
    /*left: 0;*/
    /*right: 0;*/
}
</style>
