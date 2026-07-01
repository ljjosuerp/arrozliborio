<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ComprarLinks from '@/Components/ds/ComprarLinks.vue';
import Card from '@/Components/ds/Card.vue';
import Tag from '@/Components/ds/Tag.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import ProductPack from '@/Components/ds/ProductPack.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

const props = defineProps({
    productos: { type: Array, default: () => [] },
});

const lineas = [
    { id: 'todos', label: 'Todos' },
    { id: 'arroz', label: 'Arroz' },
    { id: 'frijol', label: 'Frijoles' },
    { id: 'aceite', label: 'Aceite' },
    { id: 'fit', label: 'Liborio Fit' },
];
const selected = ref('todos');

const packLabel = { arroz: 'Arroz', frijol: 'Frijol', aceite: 'Aceite', fit: 'Liborio Fit' };

const filtrados = computed(() =>
    selected.value === 'todos'
        ? props.productos
        : props.productos.filter((p) => p.linea === selected.value)
);

// Resuelve la URL de la imagen: ruta absoluta tal cual, o disco public (/storage).
const imgSrc = (im) => (!im ? '' : (im.startsWith('http') || im.startsWith('/') ? im : '/storage/' + im));
</script>

<template>
    <Head title="Productos" />

    <PublicLayout>
        <!-- Hero -->
        <section style="position:relative;background:var(--grad-red);overflow:hidden;">
            <img src="/img/liborio/hero-liborio-pattern.webp" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.2;mix-blend-mode:luminosity;" />
            <div style="position:relative;max-width:1180px;margin:0 auto;padding:60px 28px;">
                <Eyebrow color="rgba(255,255,255,0.9)" :with-mark="true">Nuestra cartera</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;margin:12px 0 12px;">Productos Liborio</h1>
                <p style="font:var(--body-lg);color:rgba(255,255,255,0.92);max-width:520px;margin:0;">
                    Arroz, frijoles y aceite 100% costarricenses. Calidad y sabor de nuestra tierra para tu mesa.
                </p>
            </div>
            <Cintillo :height="8" />
        </section>

        <!-- Filtros -->
        <section style="max-width:1180px;margin:0 auto;padding:36px 28px 0;">
            <div style="display:flex;flex-wrap:wrap;gap:10px;">
                <button
                    v-for="l in lineas"
                    :key="l.id"
                    @click="selected = l.id"
                    :style="{
                        fontFamily: 'var(--font-sans)', fontWeight: 800, fontSize: '14px',
                        padding: '9px 18px', borderRadius: 'var(--radius-pill)', cursor: 'pointer',
                        border: '1.5px solid ' + (selected === l.id ? 'var(--brand-primary)' : 'var(--border-default)'),
                        background: selected === l.id ? 'var(--brand-primary)' : 'transparent',
                        color: selected === l.id ? '#fff' : 'var(--text-body)',
                    }"
                >
                    {{ l.label }}
                </button>
            </div>
        </section>

        <!-- Grid -->
        <section style="max-width:1180px;margin:0 auto;padding:32px 28px 80px;">
            <div class="prod-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:22px;">
                <Card v-for="p in filtrados" :key="p.id" elevation="sm" padding="lg" :interactive="true" :style="{ display: 'flex', flexDirection: 'column', alignItems: 'center', textAlign: 'center' }">
                    <Tag v-if="p.tag" :color="p.tag_color || 'red'" :style="{ alignSelf: 'flex-start' }">{{ p.tag }}</Tag>
                    <div :style="{ margin: p.tag ? '12px 0 6px' : '0 0 6px' }">
                        <ProductPack
                            :color="p.pack_color"
                            :label="packLabel[p.linea] || 'Liborio'"
                            :weight="p.presentacion"
                            :kind="p.pack_kind || 'bag'"
                            :highlight="p.linea === 'fit' ? 'Fit' : ''"
                            :image="imgSrc(p.imagen)"
                        />
                    </div>
                    <h3 style="font:var(--fw-bold) var(--text-lg)/1.2 var(--font-display);color:var(--text-strong);margin:10px 0 2px;">{{ p.nombre }}</h3>
                    <p style="font:var(--body-sm);color:var(--text-muted);margin:0 0 14px;">{{ p.presentacion }}</p>
                    <div style="margin-top:auto;width:100%;">
                        <ComprarLinks :enlaces="p.enlaces_compra" :nombre="p.nombre" />
                    </div>
                </Card>
            </div>
            <p v-if="!filtrados.length" style="text-align:center;color:var(--text-muted);padding:40px 0;">No hay productos en esta línea.</p>
        </section>
    </PublicLayout>
</template>

<style scoped>
@media (max-width: 860px) {
    .prod-grid { grid-template-columns: repeat(2, 1fr) !important; }
}
@media (max-width: 480px) {
    .prod-grid { grid-template-columns: 1fr !important; }
}
</style>
