<template>
    <div class="card w-100 mt-2">
        <div class="card-body">
            <h2 class="card-title">{{ title }}</h2>
            <p class="card-text">{{ message }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'post',
    props: ['title', 'message'],
}
</script>
