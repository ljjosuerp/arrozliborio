<script setup>
import { computed } from 'vue';

// Card: superficie blanca sobre el papel cálido. Esquinas 18px, borde fino, sombra cálida.
const props = defineProps({
    elevation: { type: String, default: 'sm' }, // flat | sm | md | lg
    padding: { type: String, default: 'md' },    // none | sm | md | lg
    interactive: { type: Boolean, default: false },
});

const shadows = { flat: 'none', sm: 'var(--shadow-sm)', md: 'var(--shadow-md)', lg: 'var(--shadow-lg)' };
const pads = { none: '0', sm: 'var(--space-4)', md: 'var(--space-5)', lg: 'var(--space-7)' };

const style = computed(() => ({
    background: 'var(--surface-card)',
    border: '1px solid var(--border-subtle)',
    borderRadius: 'var(--radius-card)',
    boxShadow: shadows[props.elevation] ?? shadows.sm,
    padding: pads[props.padding] ?? pads.md,
    transition: 'box-shadow var(--dur-base) var(--ease-standard), transform var(--dur-base) var(--ease-standard)',
}));
</script>

<template>
    <div class="lb-card" :class="{ 'lb-card--interactive': interactive }" :style="style">
        <slot />
    </div>
</template>

<style scoped>
.lb-card--interactive { cursor: pointer; }
.lb-card--interactive:hover {
    box-shadow: var(--shadow-md) !important;
    transform: translateY(-2px);
}
</style>
