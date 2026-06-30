<script setup>
import { computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Clock, Users, ChefHat, ArrowLeft, Printer, ShoppingBag } from 'lucide-vue-next';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

const props = defineProps({
    receta: { type: Object, required: true },
});

// Ingredientes: extraer los <li> del HTML a un array (checklist)
const ingredientes = computed(() =>
    [...(props.receta.ingredientes || '').matchAll(/<li>(.*?)<\/li>/gis)].map((m) =>
        m[1].replace(/<[^>]+>/g, '').trim()
    )
);

// Instrucciones: separar pasos de notas/tips (líneas con 💡 o 👉)
const bloques = computed(() => {
    const ls = (props.receta.instrucciones || '').split('\n').map((s) => s.trim()).filter(Boolean);
    const pasos = [];
    const notas = [];
    for (const l of ls) {
        if (/^(💡|👉|tip)/i.test(l)) notas.push(l);
        else pasos.push(l);
    }
    return { pasos, notas };
});

// Cross-link al producto que usa la receta
const lineaDe = (tipo) => (/frijol/i.test(tipo) ? 'frijol' : /fit/i.test(tipo) ? 'fit' : 'arroz');
</script>

<template>
    <Head :title="receta.nombre" />

    <PublicLayout>
        <!-- Hero con foto real -->
        <section v-if="receta.imagen" style="position:relative;height:420px;overflow:hidden;">
            <img :src="receta.imagen" :alt="receta.nombre" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
            <div style="position:absolute;inset:0;background:linear-gradient(to top, rgba(26,23,21,0.85) 0%, rgba(26,23,21,0.25) 55%, rgba(26,23,21,0.35) 100%);"></div>
            <div style="position:absolute;left:0;right:0;bottom:0;">
                <div style="max-width:1180px;margin:0 auto;padding:0 28px 32px;">
                    <Eyebrow color="rgba(255,255,255,0.9)" :with-mark="true">{{ receta.tipo }}</Eyebrow>
                    <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;margin:12px 0 16px;max-width:760px;">{{ receta.nombre }}</h1>
                    <div style="display:flex;flex-wrap:wrap;gap:20px;color:rgba(255,255,255,0.95);font-family:var(--font-sans);font-weight:600;font-size:15px;">
                        <span v-if="receta.preparacion" style="display:inline-flex;align-items:center;gap:7px;"><Clock :size="18" /> {{ receta.preparacion }}</span>
                        <span v-if="receta.porciones" style="display:inline-flex;align-items:center;gap:7px;"><Users :size="18" /> {{ receta.porciones }}</span>
                        <span v-if="receta.dificultad" style="display:inline-flex;align-items:center;gap:7px;"><ChefHat :size="18" /> Dificultad {{ receta.dificultad }}</span>
                    </div>
                </div>
            </div>
            <Cintillo :height="8" />
        </section>
        <!-- Hero sin foto (respaldo) -->
        <section v-else style="position:relative;background:var(--grad-red);overflow:hidden;">
            <div style="position:relative;max-width:1180px;margin:0 auto;padding:56px 28px;">
                <Eyebrow color="rgba(255,255,255,0.9)" :with-mark="true">{{ receta.tipo }}</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;margin:12px 0 16px;">{{ receta.nombre }}</h1>
                <div style="display:flex;flex-wrap:wrap;gap:20px;color:rgba(255,255,255,0.92);font-family:var(--font-sans);font-weight:600;">
                    <span v-if="receta.preparacion" style="display:inline-flex;align-items:center;gap:7px;"><Clock :size="18" /> {{ receta.preparacion }}</span>
                    <span v-if="receta.porciones" style="display:inline-flex;align-items:center;gap:7px;"><Users :size="18" /> {{ receta.porciones }}</span>
                    <span v-if="receta.dificultad" style="display:inline-flex;align-items:center;gap:7px;"><ChefHat :size="18" /> {{ receta.dificultad }}</span>
                </div>
            </div>
            <Cintillo :height="8" />
        </section>

        <!-- Barra de acciones -->
        <section class="rec-actions" style="max-width:1080px;margin:0 auto;padding:24px 28px 0;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
            <Link href="/recetas" style="display:inline-flex;align-items:center;gap:8px;color:var(--brand-primary);font-family:var(--font-sans);font-weight:800;">
                <ArrowLeft :size="18" /> Todas las recetas
            </Link>
            <button onclick="window.print()" style="display:inline-flex;align-items:center;gap:8px;border:1.5px solid var(--border-default);background:var(--surface-card);color:var(--text-body);border-radius:var(--radius-pill);padding:8px 16px;font-family:var(--font-sans);font-weight:700;font-size:14px;cursor:pointer;">
                <Printer :size="16" /> Imprimir
            </button>
        </section>

        <!-- Contenido: ingredientes + pasos -->
        <section class="rec-body" style="max-width:1080px;margin:0 auto;padding:32px 28px 24px;display:grid;grid-template-columns:0.8fr 1.2fr;gap:44px;align-items:start;">
            <!-- Ingredientes (checklist) -->
            <div class="rec-ingredientes" style="background:var(--surface-sunken);border:1px solid var(--border-subtle);border-radius:var(--radius-card);padding:26px;position:sticky;top:90px;">
                <h2 style="font:var(--fw-bold) var(--text-2xl)/1.2 var(--font-display);color:var(--text-strong);margin:0 0 16px;">Ingredientes</h2>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px;">
                    <li v-for="(ing, i) in ingredientes" :key="i">
                        <label style="display:flex;gap:11px;align-items:flex-start;cursor:pointer;font-family:var(--font-sans);font-size:15px;color:var(--text-body);">
                            <input type="checkbox" class="rec-check" />
                            <span>{{ ing }}</span>
                        </label>
                    </li>
                </ul>
            </div>

            <!-- Preparación (pasos numerados) -->
            <div>
                <h2 style="font:var(--fw-bold) var(--text-2xl)/1.2 var(--font-display);color:var(--text-strong);margin:0 0 18px;">Preparación</h2>
                <ol style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:18px;counter-reset:paso;">
                    <li v-for="(paso, i) in bloques.pasos" :key="i" style="display:flex;gap:16px;align-items:flex-start;">
                        <span style="flex:0 0 auto;width:34px;height:34px;border-radius:50%;background:var(--brand-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-family:var(--font-sans);font-weight:800;font-size:15px;">{{ i + 1 }}</span>
                        <p style="font:var(--body-md);color:var(--text-body);margin:0;padding-top:4px;">{{ paso }}</p>
                    </li>
                </ol>

                <!-- Tips / notas -->
                <div v-for="(nota, i) in bloques.notas" :key="i" style="margin-top:18px;display:flex;gap:12px;background:var(--celeste-50);border-left:4px solid var(--brand-accent);border-radius:var(--radius-md);padding:14px 16px;">
                    <p style="font-family:var(--font-sans);font-size:14px;color:var(--blue-700);margin:0;">{{ nota }}</p>
                </div>
            </div>
        </section>

        <!-- Cross-link al producto (motor de cross-sell) -->
        <section class="rec-cross" style="max-width:1080px;margin:0 auto;padding:24px 28px 80px;">
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;background:var(--surface-inverse);border-radius:var(--radius-card);padding:28px 32px;">
                <div style="flex:1;min-width:240px;">
                    <div style="font-family:var(--font-sans);font-weight:800;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--brand-accent);margin-bottom:6px;">Hecho con</div>
                    <div style="font:var(--fw-bold) var(--text-2xl)/1.1 var(--font-display);color:#fff;">{{ receta.tipo }}</div>
                </div>
                <Button href="/productos" variant="primary" :style="{ background: '#fff', color: 'var(--brand-secondary)' }">
                    <template #iconLeft><ShoppingBag :size="18" /></template>
                    Ver el producto
                </Button>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.rec-check { width: 18px; height: 18px; accent-color: var(--brand-primary); margin-top: 1px; flex: 0 0 auto; cursor: pointer; }
.rec-check:checked + span { text-decoration: line-through; color: var(--text-faint); }
@media (max-width: 820px) {
    .rec-body { grid-template-columns: 1fr !important; }
    .rec-ingredientes { position: static !important; }
}
</style>
