<script setup>
// Input de texto con label/helper/error opcionales. Focus: anillo celeste.
defineProps({
    label: { type: String, default: '' },
    helper: { type: String, default: '' },
    error: { type: String, default: '' },
    placeholder: { type: String, default: '' },
    type: { type: String, default: 'text' },
    modelValue: { type: String, default: '' },
    containerStyle: { type: Object, default: () => ({}) },
});
defineEmits(['update:modelValue']);
</script>

<template>
    <div :style="{ display: 'flex', flexDirection: 'column', gap: '6px', ...containerStyle }">
        <label v-if="label" style="font-family:var(--font-sans);font-weight:var(--fw-bold);font-size:var(--text-sm);color:var(--text-strong);">{{ label }}</label>
        <input
            class="lb-input"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            :data-error="error ? 'true' : 'false'"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <span v-if="helper || error" :style="{ fontFamily: 'var(--font-sans)', fontSize: 'var(--text-xs)', color: error ? 'var(--danger)' : 'var(--text-muted)' }">
            {{ error || helper }}
        </span>
    </div>
</template>

<style scoped>
.lb-input {
    font-family: var(--font-sans);
    font-size: var(--text-md);
    color: var(--text-strong);
    background: var(--surface-card);
    border: 1.5px solid var(--border-default);
    border-radius: var(--radius-md);
    padding: 11px 14px;
    outline: none;
    transition: border-color var(--dur-fast) var(--ease-standard), box-shadow var(--dur-fast) var(--ease-standard);
}
.lb-input[data-error='true'] { border-color: var(--danger); }
.lb-input:focus { border-color: var(--brand-accent); box-shadow: var(--focus-ring); }
.lb-input[data-error='true']:focus { border-color: var(--danger); }
</style>
