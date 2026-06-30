<script setup>
// Cintillo tricolor (bandera de Costa Rica) — regla de marca azul/blanco/rojo.
defineProps({
    height: { type: [Number, String], default: 8 },
});
</script>

<template>
    <div
        :style="{
            height: typeof height === 'number' ? height + 'px' : height,
            width: '100%',
            background:
                'linear-gradient(to right, var(--cr-blue) 0 33.33%, var(--cr-white) 33.33% 66.66%, var(--cr-red) 66.66% 100%)',
        }"
    />
</template>
