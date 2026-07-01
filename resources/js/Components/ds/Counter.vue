<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

// Contador que anima de `from` a `to` cuando entra en pantalla.
const props = defineProps({
    to: { type: Number, required: true },
    from: { type: Number, default: 0 },
    duration: { type: Number, default: 1600 },
    prefix: { type: String, default: '' },
    suffix: { type: String, default: '' },
    decimals: { type: Number, default: 0 },
});

const el = ref(null);
const value = ref(props.from);
let observer = null;
let raf = null;

const fmt = (n) => props.prefix + n.toLocaleString('es-CR', {
    minimumFractionDigits: props.decimals,
    maximumFractionDigits: props.decimals,
}) + props.suffix;

const run = () => {
    const start = performance.now();
    const tick = (now) => {
        const t = Math.min((now - start) / props.duration, 1);
        const eased = 1 - Math.pow(1 - t, 3); // easeOutCubic
        value.value = props.from + (props.to - props.from) * eased;
        if (t < 1) raf = requestAnimationFrame(tick);
        else value.value = props.to;
    };
    raf = requestAnimationFrame(tick);
};

onMounted(() => {
    const reduce = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
    if (reduce || !('IntersectionObserver' in window)) {
        value.value = props.to;
        return;
    }
    observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                run();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });
    observer.observe(el.value);
});

onBeforeUnmount(() => {
    if (observer) observer.disconnect();
    if (raf) cancelAnimationFrame(raf);
});
</script>

<template>
    <span ref="el">{{ fmt(value) }}</span>
</template>
