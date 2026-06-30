<script setup>
// Eyebrow / overline — etiqueta ExtraBold en mayúsculas, roja por defecto.
defineProps({
    color: { type: String, default: 'var(--brand-primary)' },
    withMark: { type: Boolean, default: false },
});
</script>

<template>
    <span
        class="lb-eyebrow"
        :style="{
            display: 'inline-flex',
            alignItems: 'center',
            gap: '8px',
            fontFamily: 'var(--font-sans)',
            fontWeight: 'var(--fw-extra)',
            fontSize: 'var(--text-xs)',
            letterSpacing: 'var(--tracking-caps)',
            textTransform: 'uppercase',
            color,
        }"
    >
        <span
            v-if="withMark"
            :style="{ width: '22px', height: '2px', borderRadius: '2px', background: 'currentColor', opacity: 0.7 }"
        />
        <slot />
    </span>
</template>
