<script setup>
import { computed } from 'vue';

// Toast — notificación inline.
const props = defineProps({
    title: { type: String, default: '' },
    tone: { type: String, default: 'info' }, // info | success | warning | danger | brand
});
defineEmits(['close']);

const tones = {
    info: { bar: 'var(--info)' },
    success: { bar: 'var(--success)' },
    warning: { bar: 'var(--warning)' },
    danger: { bar: 'var(--danger)' },
    brand: { bar: 'var(--brand-primary)' },
};
const bar = computed(() => (tones[props.tone] || tones.info).bar);
</script>

<template>
    <div
        role="status"
        style="display:flex;align-items:flex-start;gap:12px;background:var(--surface-card);border:1px solid var(--border-subtle);border-radius:var(--radius-md);box-shadow:var(--shadow-md);padding:14px 16px;min-width:280px;max-width:420px;position:relative;overflow:hidden;"
    >
        <span :style="{ position: 'absolute', left: 0, top: 0, bottom: 0, width: '4px', background: bar }" />
        <div style="flex:1;padding-left:4px;">
            <div v-if="title" style="font-family:var(--font-sans);font-weight:var(--fw-extra);font-size:var(--text-sm);color:var(--text-strong);margin-bottom:2px;">{{ title }}</div>
            <div style="font-family:var(--font-sans);font-size:var(--text-sm);color:var(--text-body);"><slot /></div>
        </div>
        <button aria-label="Cerrar" style="border:none;background:transparent;cursor:pointer;color:var(--text-muted);font-size:18px;line-height:1;padding:2px;" @click="$emit('close')">×</button>
    </div>
</template>
