<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

// Comparador animado. Las barras se llenan al entrar en pantalla.
// Marco honesto: "barra más larga = mejor para vos".
const props = defineProps({
    titulo: { type: String, default: 'Liborio Fit vs. arroz blanco' },
    color: { type: String, default: 'var(--celeste-600)' },
    filas: {
        type: Array,
        default: () => ([
            { etiqueta: 'Más fibra', fit: 90, blanco: 51, nota: '+75% más fibra' },
            { etiqueta: 'Menos grasa', fit: 99, blanco: 15, nota: '99% menos grasa' },
            { etiqueta: 'Menos sodio', fit: 88, blanco: 45, nota: 'Bajo en sodio' },
            { etiqueta: 'Sin colesterol', fit: 100, blanco: 35, nota: '0 mg de colesterol' },
        ]),
    },
});

const root = ref(null);
const filled = ref(false);
let observer = null;

onMounted(() => {
    if (!('IntersectionObserver' in window)) { filled.value = true; return; }
    observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) { filled.value = true; observer.unobserve(entry.target); }
        });
    }, { threshold: 0.3 });
    observer.observe(root.value);
});
onBeforeUnmount(() => observer && observer.disconnect());
</script>

<template>
    <div ref="root" class="cmp">
        <div class="cmp-head">
            <h3>{{ titulo }}</h3>
            <div class="cmp-legend">
                <span><i class="dot" :style="{ background: color }"></i> Liborio Fit</span>
                <span><i class="dot" style="background: var(--grey-300)"></i> Arroz blanco</span>
            </div>
        </div>

        <div v-for="fila in filas" :key="fila.etiqueta" class="cmp-row">
            <div class="cmp-label">
                <strong>{{ fila.etiqueta }}</strong>
                <em v-if="fila.nota">{{ fila.nota }}</em>
            </div>
            <div class="cmp-bars">
                <div class="cmp-track">
                    <div class="cmp-fit lb-bar-fill" :class="{ 'is-filled': filled }"
                        :style="{ '--fill': fila.fit + '%', background: color }"></div>
                </div>
                <div class="cmp-track cmp-track--thin">
                    <div class="cmp-blanco lb-bar-fill" :class="{ 'is-filled': filled }"
                        :style="{ '--fill': fila.blanco + '%' }"></div>
                </div>
            </div>
        </div>

        <p class="cmp-foot">*Comparativa con el arroz blanco. Barra más larga = mejor para vos.</p>
    </div>
</template>

<style scoped>
.cmp {
    background: var(--surface-card);
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-sm);
    padding: var(--space-7);
}
.cmp-head { display: flex; flex-wrap: wrap; gap: 12px; justify-content: space-between; align-items: center; margin-bottom: 22px; }
.cmp-head h3 { font: var(--fw-bold) var(--text-xl)/1.1 var(--font-display); color: var(--text-strong); margin: 0; }
.cmp-legend { display: flex; gap: 16px; font-family: var(--font-sans); font-size: 13px; color: var(--text-muted); }
.cmp-legend span { display: inline-flex; align-items: center; gap: 6px; }
.dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }

.cmp-row { margin-bottom: 18px; }
.cmp-label { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 6px; }
.cmp-label strong { font-family: var(--font-sans); font-weight: 700; font-size: 15px; color: var(--text-strong); }
.cmp-label em { font-style: normal; font-size: 12px; color: var(--text-muted); }

.cmp-bars { display: flex; flex-direction: column; gap: 5px; }
.cmp-track { background: var(--surface-sunken); border-radius: 999px; height: 14px; overflow: hidden; }
.cmp-track--thin { height: 8px; }
.cmp-fit, .cmp-blanco { height: 100%; border-radius: 999px; }
.cmp-blanco { background: var(--grey-300); }

.cmp-foot { font-size: 11px; color: var(--text-faint); margin: 14px 0 0; }
</style>
