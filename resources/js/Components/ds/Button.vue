<script setup>
import { computed } from 'vue';

// Botón de marca: rojo lleno = CTA principal; azul = institucional; outline/ghost = secundarios.
const props = defineProps({
    variant: { type: String, default: 'primary' }, // primary | secondary | outline | ghost
    size: { type: String, default: 'md' },          // sm | md | lg
    full: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    href: { type: String, default: '' },            // si se da, el botón es un enlace <a>
    target: { type: String, default: '' },
});

const sizes = {
    sm: { padding: '8px 16px', font: 'var(--text-sm)', radius: 'var(--radius-sm)', gap: '6px' },
    md: { padding: '12px 24px', font: 'var(--text-md)', radius: 'var(--radius-md)', gap: '8px' },
    lg: { padding: '16px 34px', font: 'var(--text-lg)', radius: 'var(--radius-md)', gap: '10px' },
};
const s = computed(() => sizes[props.size] || sizes.md);
</script>

<template>
    <component
        :is="href ? 'a' : 'button'"
        class="lb-btn"
        :data-variant="variant"
        :href="href || undefined"
        :target="target || undefined"
        :rel="target === '_blank' ? 'noopener noreferrer' : undefined"
        :disabled="!href && disabled ? true : undefined"
        :style="{
            gap: s.gap,
            fontSize: s.font,
            padding: s.padding,
            borderRadius: s.radius,
            width: full ? '100%' : 'auto',
            opacity: disabled ? 0.45 : 1,
        }"
    >
        <slot name="iconLeft" />
        <slot />
        <slot name="iconRight" />
    </component>
</template>

<style scoped>
.lb-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-sans);
    font-weight: var(--fw-extra);
    line-height: 1;
    letter-spacing: 0.01em;
    cursor: pointer;
    text-decoration: none;
    border: 1px solid transparent;
    transition: background var(--dur-fast) var(--ease-standard),
        transform var(--dur-fast) var(--ease-standard),
        box-shadow var(--dur-fast) var(--ease-standard);
}
.lb-btn:active { transform: scale(0.98); }
.lb-btn:disabled { cursor: not-allowed; }
.lb-btn[data-variant='primary'] { background: var(--brand-primary); color: var(--text-on-brand); box-shadow: var(--shadow-brand); }
.lb-btn[data-variant='primary']:hover { background: var(--brand-primary-hover); }
.lb-btn[data-variant='secondary'] { background: var(--brand-secondary); color: var(--text-on-brand); box-shadow: var(--shadow-sm); }
.lb-btn[data-variant='secondary']:hover { background: var(--brand-secondary-hover); }
.lb-btn[data-variant='outline'] { background: transparent; color: var(--brand-primary); border: 1.5px solid var(--brand-primary); }
.lb-btn[data-variant='outline']:hover { background: var(--red-50); }
.lb-btn[data-variant='ghost'] { background: transparent; color: var(--brand-secondary); }
.lb-btn[data-variant='ghost']:hover { background: var(--grey-50); }
</style>
