<script setup>
import { computed } from 'vue';

// Tag: pill de etiqueta para categorías, claims, filtros.
const props = defineProps({
    color: { type: String, default: 'red' }, // red | blue | celeste | yellow | wheat | neutral
    soft: { type: Boolean, default: true },
});

const map = {
    red: { solid: 'var(--red-500)', softBg: 'var(--red-50)', softFg: 'var(--red-700)' },
    blue: { solid: 'var(--blue-500)', softBg: 'var(--blue-50)', softFg: 'var(--blue-600)' },
    celeste: { solid: 'var(--celeste-500)', softBg: 'var(--celeste-100)', softFg: 'var(--celeste-700)' },
    yellow: { solid: 'var(--yellow-500)', softBg: 'var(--yellow-100)', softFg: 'var(--yellow-700)' },
    wheat: { solid: 'var(--wheat-500)', softBg: 'var(--wheat-100)', softFg: 'var(--wheat-700)' },
    neutral: { solid: 'var(--grey-600)', softBg: 'var(--grey-100)', softFg: 'var(--grey-700)' },
};

const style = computed(() => {
    const c = map[props.color] || map.red;
    const solidFg = props.color === 'yellow' || props.color === 'celeste' ? 'var(--black)' : 'var(--white)';
    return {
        display: 'inline-flex',
        alignItems: 'center',
        gap: '6px',
        fontFamily: 'var(--font-sans)',
        fontWeight: 'var(--fw-extra)',
        fontSize: 'var(--text-xs)',
        letterSpacing: '0.03em',
        lineHeight: 1,
        padding: '7px 14px',
        borderRadius: 'var(--radius-pill)',
        background: props.soft ? c.softBg : c.solid,
        color: props.soft ? c.softFg : solidFg,
    };
});
</script>

<template>
    <span :style="style"><slot /></span>
</template>
