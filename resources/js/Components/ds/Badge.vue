<script setup>
import { computed } from 'vue';

// Badge de conteo / estado.
const props = defineProps({
    tone: { type: String, default: 'red' }, // red | blue | success | warning | neutral
});

const tones = {
    red: { bg: 'var(--red-500)', fg: 'var(--white)' },
    blue: { bg: 'var(--blue-500)', fg: 'var(--white)' },
    success: { bg: 'var(--success)', fg: 'var(--white)' },
    warning: { bg: 'var(--warning)', fg: 'var(--white)' },
    neutral: { bg: 'var(--grey-200)', fg: 'var(--grey-700)' },
};

const style = computed(() => {
    const t = tones[props.tone] || tones.red;
    return {
        display: 'inline-flex',
        alignItems: 'center',
        justifyContent: 'center',
        minWidth: '20px',
        height: '20px',
        padding: '0 7px',
        fontFamily: 'var(--font-sans)',
        fontWeight: 'var(--fw-bold)',
        fontSize: 'var(--text-2xs)',
        lineHeight: 1,
        borderRadius: 'var(--radius-pill)',
        background: t.bg,
        color: t.fg,
    };
});
</script>

<template>
    <span :style="style"><slot /></span>
</template>
