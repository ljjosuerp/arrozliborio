<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue';
import { ChevronLeft, ChevronRight, Star, Quote } from 'lucide-vue-next';

// Carrusel de testimonios. Rota solo y también con flechas/puntos.
const props = defineProps({
    items: { type: Array, default: () => [] },
    intervalo: { type: Number, default: 6000 },
});

const i = ref(0);
const n = computed(() => props.items.length);
let timer = null;

const ir = (idx) => { i.value = (idx + n.value) % n.value; };
const siguiente = () => ir(i.value + 1);
const anterior = () => ir(i.value - 1);

const arrancar = () => {
    detener();
    if (n.value > 1) timer = setInterval(siguiente, props.intervalo);
};
const detener = () => { if (timer) { clearInterval(timer); timer = null; } };

onMounted(arrancar);
onBeforeUnmount(detener);
</script>

<template>
    <div v-if="n" class="tst" @mouseenter="detener" @mouseleave="arrancar">
        <button class="tst-nav tst-prev" aria-label="Anterior" @click="anterior"><ChevronLeft :size="22" /></button>

        <div class="tst-stage">
            <Quote class="tst-quote" :size="40" />
            <transition name="tst-fade" mode="out-in">
                <div :key="i" class="tst-card">
                    <div class="tst-stars">
                        <Star v-for="s in (items[i].estrellas || 5)" :key="s" :size="18" fill="currentColor" stroke="none" />
                    </div>
                    <p class="tst-text">“{{ items[i].texto }}”</p>
                    <div class="tst-author">
                        <span class="tst-name">{{ items[i].autor }}</span>
                        <span v-if="items[i].lugar" class="tst-place">{{ items[i].lugar }}</span>
                    </div>
                </div>
            </transition>
        </div>

        <button class="tst-nav tst-next" aria-label="Siguiente" @click="siguiente"><ChevronRight :size="22" /></button>

        <div class="tst-dots">
            <button v-for="(t, idx) in items" :key="idx" class="tst-dot" :class="{ 'is-active': idx === i }"
                :aria-label="`Ir al testimonio ${idx + 1}`" @click="ir(idx)"></button>
        </div>
    </div>
</template>

<style scoped>
.tst { position: relative; max-width: 760px; margin: 0 auto; padding: 0 44px; }
.tst-stage { position: relative; text-align: center; }
.tst-quote { position: absolute; top: -10px; left: 50%; transform: translateX(-50%); color: var(--brand-primary); opacity: 0.14; }

.tst-card { padding: 26px 8px 4px; }
.tst-stars { display: flex; justify-content: center; gap: 3px; color: var(--yellow-500); margin-bottom: 14px; }
.tst-text { font: var(--fw-medium) var(--text-2xl)/1.4 var(--font-display); color: var(--text-strong); margin: 0 0 18px; text-wrap: balance; }
.tst-author { display: flex; flex-direction: column; gap: 2px; }
.tst-name { font-family: var(--font-sans); font-weight: 800; color: var(--text-strong); }
.tst-place { font-family: var(--font-sans); font-size: 13px; color: var(--text-muted); }

.tst-nav {
    position: absolute; top: 42%; transform: translateY(-50%);
    width: 40px; height: 40px; border-radius: 50%; cursor: pointer;
    border: 1px solid var(--border-default); background: var(--surface-card); color: var(--text-body);
    display: flex; align-items: center; justify-content: center;
    transition: background var(--dur-fast) var(--ease-standard), color var(--dur-fast) var(--ease-standard), border-color var(--dur-fast) var(--ease-standard);
}
.tst-nav:hover { background: var(--brand-primary); color: #fff; border-color: var(--brand-primary); }
.tst-prev { left: 0; }
.tst-next { right: 0; }

.tst-dots { display: flex; justify-content: center; gap: 8px; margin-top: 20px; }
.tst-dot { width: 8px; height: 8px; border-radius: 50%; border: none; cursor: pointer; padding: 0; background: var(--border-strong); transition: background var(--dur-fast) var(--ease-standard), width var(--dur-fast) var(--ease-standard); }
.tst-dot.is-active { background: var(--brand-primary); width: 22px; border-radius: 999px; }

.tst-fade-enter-active, .tst-fade-leave-active { transition: opacity var(--dur-base) var(--ease-out), transform var(--dur-base) var(--ease-out); }
.tst-fade-enter-from { opacity: 0; transform: translateY(10px); }
.tst-fade-leave-to { opacity: 0; transform: translateY(-10px); }

@media (max-width: 560px) {
    .tst { padding: 0 8px; }
    .tst-nav { display: none; }
    .tst-text { font-size: var(--text-xl); }
}
</style>
