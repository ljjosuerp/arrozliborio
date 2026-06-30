<script setup>
import { computed } from 'vue';

// Checkbox con label. Check rojo, anillo celeste.
const props = defineProps({
    label: { type: String, default: '' },
    modelValue: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
});
const emit = defineEmits(['update:modelValue']);

const boxStyle = computed(() => ({
    position: 'relative', width: '20px', height: '20px', flex: '0 0 auto',
    borderRadius: 'var(--radius-xs)',
    border: '1.5px solid ' + (props.modelValue ? 'var(--brand-primary)' : 'var(--border-strong)'),
    background: props.modelValue ? 'var(--brand-primary)' : 'var(--surface-card)',
    transition: 'background var(--dur-fast) var(--ease-standard), border-color var(--dur-fast) var(--ease-standard)',
    display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
}));
</script>

<template>
    <label
        :style="{
            display: 'inline-flex', alignItems: 'center', gap: '10px',
            cursor: disabled ? 'not-allowed' : 'pointer', opacity: disabled ? 0.5 : 1,
            fontFamily: 'var(--font-sans)', fontSize: 'var(--text-md)', color: 'var(--text-body)',
        }"
    >
        <span :style="boxStyle">
            <input
                type="checkbox"
                :checked="modelValue"
                :disabled="disabled"
                style="position:absolute;opacity:0;inset:0;margin:0;cursor:inherit;"
                @change="$emit('update:modelValue', $event.target.checked)"
            />
            <svg v-if="modelValue" width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                <path d="M2.5 6.2l2.4 2.4L9.6 3.6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
        {{ label }}
    </label>
</template>
