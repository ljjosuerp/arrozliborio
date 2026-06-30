<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { Clock, Users, ChefHat } from 'lucide-vue-next';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Tag from '@/Components/ds/Tag.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

const props = defineProps({
    recetas: { type: Array, default: () => [] },
});

// Categoría según el producto que usa (para filtrar y hacer cross-sell)
const lineaDe = (tipo) => (/frijol/i.test(tipo) ? 'frijol' : /fit/i.test(tipo) ? 'fit' : 'arroz');
const cats = [
    { id: 'todas', label: 'Todas' },
    { id: 'arroz', label: 'Con Arroz' },
    { id: 'frijol', label: 'Con Frijoles' },
    { id: 'fit', label: 'Con Liborio Fit' },
];
const sel = ref('todas');
const filtradas = computed(() =>
    sel.value === 'todas' ? props.recetas : props.recetas.filter((r) => lineaDe(r.tipo) === sel.value)
);

const grads = ['var(--grad-red)', 'var(--grad-blue)', 'var(--grad-harvest)', 'var(--grad-celeste)'];
</script>

<template>
    <Head title="Recetas" />

    <PublicLayout>
        <section style="position:relative;background:var(--grad-harvest);overflow:hidden;">
            <img src="/img/liborio/espiga-mark-red.png" alt="" style="position:absolute;right:-20px;bottom:-30px;width:220px;opacity:0.15;" />
            <div style="position:relative;max-width:1180px;margin:0 auto;padding:60px 28px;">
                <Eyebrow color="var(--wheat-700)" :with-mark="true">Cocina con Liborio</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:var(--text-strong);margin:12px 0 12px;">Recetas</h1>
                <p style="font:var(--body-lg);color:var(--text-body);max-width:540px;margin:0;">
                    Ideas sabrosas y bien ticas para sacarle el máximo a tu arroz, frijoles y aceite Liborio.
                </p>
            </div>
            <Cintillo :height="8" />
        </section>

        <!-- Filtros -->
        <section style="max-width:1180px;margin:0 auto;padding:36px 28px 0;">
            <div style="display:flex;flex-wrap:wrap;gap:10px;">
                <button v-for="c in cats" :key="c.id" @click="sel = c.id"
                    :style="{
                        fontFamily: 'var(--font-sans)', fontWeight: 800, fontSize: '14px',
                        padding: '9px 18px', borderRadius: 'var(--radius-pill)', cursor: 'pointer',
                        border: '1.5px solid ' + (sel === c.id ? 'var(--brand-primary)' : 'var(--border-default)'),
                        background: sel === c.id ? 'var(--brand-primary)' : 'transparent',
                        color: sel === c.id ? '#fff' : 'var(--text-body)',
                    }">
                    {{ c.label }}
                </button>
            </div>
        </section>

        <section style="max-width:1180px;margin:0 auto;padding:32px 28px 80px;">
            <div class="rec-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
                <Link
                    v-for="(r, i) in filtradas"
                    :key="r.id"
                    :href="`/recetas/${r.id}/${r.slug}`"
                    class="rec-card"
                    style="display:block;border-radius:var(--radius-card);overflow:hidden;border:1px solid var(--border-subtle);background:var(--surface-card);box-shadow:var(--shadow-sm);"
                >
                    <!-- Foto real o portada de gradiente -->
                    <div style="position:relative;height:200px;overflow:hidden;">
                        <img v-if="r.imagen" :src="r.imagen" :alt="r.nombre" style="width:100%;height:100%;object-fit:cover;" />
                        <div v-else :style="{ height: '100%', background: grads[i % grads.length], display: 'flex', alignItems: 'center', justifyContent: 'center', padding: '0 18px' }">
                            <span style="font-family:var(--font-display);font-weight:700;font-size:20px;color:rgba(255,255,255,0.95);text-align:center;">{{ r.nombre }}</span>
                        </div>
                        <div style="position:absolute;left:12px;top:12px;"><Tag color="red" :soft="false">{{ r.tipo }}</Tag></div>
                    </div>
                    <div style="padding:18px 20px 20px;">
                        <h3 style="font:var(--fw-bold) var(--text-xl)/1.2 var(--font-display);color:var(--text-strong);margin:0 0 10px;">{{ r.nombre }}</h3>
                        <div style="display:flex;flex-wrap:wrap;gap:14px;color:var(--text-muted);font-family:var(--font-sans);font-size:13px;">
                            <span v-if="r.preparacion" style="display:inline-flex;align-items:center;gap:5px;"><Clock :size="15" /> {{ r.preparacion }}</span>
                            <span v-if="r.porciones" style="display:inline-flex;align-items:center;gap:5px;"><Users :size="15" /> {{ r.porciones }}</span>
                            <span v-if="r.dificultad" style="display:inline-flex;align-items:center;gap:5px;"><ChefHat :size="15" /> {{ r.dificultad }}</span>
                        </div>
                    </div>
                </Link>
            </div>
            <p v-if="!filtradas.length" style="text-align:center;color:var(--text-muted);padding:40px 0;">No hay recetas en esta categoría.</p>
        </section>
    </PublicLayout>
</template>

<style scoped>
.rec-card { transition: box-shadow var(--dur-base) var(--ease-standard), transform var(--dur-base) var(--ease-standard); }
.rec-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-3px); }
.rec-card img { transition: transform var(--dur-slow) var(--ease-standard); }
.rec-card:hover img { transform: scale(1.05); }
@media (max-width: 860px) { .rec-grid { grid-template-columns: repeat(2, 1fr) !important; } }
@media (max-width: 520px) { .rec-grid { grid-template-columns: 1fr !important; } }
</style>
