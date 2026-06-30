<script setup>
import { Head, router } from '@inertiajs/vue3';
import { Sprout, HandHeart, Factory, MapPin } from 'lucide-vue-next';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Card from '@/Components/ds/Card.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

const valores = [
    { icon: Sprout, t: 'Productor nacional', d: 'Trabajamos junto a familias agricultoras de Costa Rica.' },
    { icon: Factory, t: 'Planta propia', d: 'Procesamos y empacamos con control de calidad en Cañas, Guanacaste.' },
    { icon: HandHeart, t: 'Compromiso social', d: 'Aportamos al desarrollo de nuestras comunidades.' },
    { icon: MapPin, t: 'En toda Costa Rica', d: 'Llevamos nuestros productos de la pampa a tu mesa.' },
];

const hitos = [
    ['Origen', 'Nacimos en los campos de Guanacaste con una misión: llevar el mejor grano a cada hogar tico.'],
    ['Crecimiento', 'Ampliamos nuestra línea con frijoles y aceite, siempre con la misma calidad.'],
    ['Hoy', 'Somos parte de la mesa costarricense, apoyando al productor nacional en cada paso.'],
];
</script>

<template>
    <Head title="Nuestra historia" />

    <PublicLayout>
        <section style="position:relative;background:var(--grad-red);overflow:hidden;">
            <img src="/img/liborio/hero-liborio-pattern.jpg" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.2;mix-blend-mode:luminosity;" />
            <div style="position:relative;max-width:1180px;margin:0 auto;padding:64px 28px;">
                <Eyebrow color="rgba(255,255,255,0.9)" :with-mark="true">Conócenos</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;max-width:680px;margin:12px 0 16px;">El grano que une a Costa Rica</h1>
                <p style="font:var(--body-lg);color:rgba(255,255,255,0.92);max-width:560px;margin:0;">
                    Desde nuestra tierra guanacasteca, Arrocera Liborio nació para llevar calidad, sabor y
                    compromiso a la mesa de cada familia costarricense.
                </p>
            </div>
            <Cintillo :height="8" />
        </section>

        <!-- Historia -->
        <section style="max-width:1180px;margin:0 auto;padding:64px 28px;">
            <div style="text-align:center;margin-bottom:36px;">
                <Eyebrow :with-mark="true">Nuestra historia</Eyebrow>
                <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 0;">De la pampa a tu mesa</h2>
            </div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:22px;" class="conocenos-grid">
                <Card v-for="(h, i) in hitos" :key="i" elevation="sm" padding="lg">
                    <div style="font-family:var(--font-sans);font-weight:800;font-size:13px;letter-spacing:.1em;text-transform:uppercase;color:var(--brand-primary);margin-bottom:10px;">{{ h[0] }}</div>
                    <p style="font:var(--body-md);color:var(--text-body);margin:0;">{{ h[1] }}</p>
                </Card>
            </div>
        </section>

        <!-- Valores -->
        <section style="background:var(--surface-sunken);border-top:1px solid var(--border-subtle);border-bottom:1px solid var(--border-subtle);">
            <div style="max-width:1180px;margin:0 auto;padding:60px 28px;">
                <div style="text-align:center;margin-bottom:36px;">
                    <Eyebrow :with-mark="true">Lo que nos mueve</Eyebrow>
                    <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 0;">Nuestros valores</h2>
                </div>
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;" class="conocenos-grid">
                    <Card v-for="v in valores" :key="v.t" elevation="sm" padding="lg" :style="{ textAlign: 'center' }">
                        <div style="width:52px;height:52px;border-radius:50%;background:var(--red-50);color:var(--brand-primary);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                            <component :is="v.icon" :size="24" />
                        </div>
                        <h3 style="font:var(--fw-bold) var(--text-lg)/1.2 var(--font-sans);color:var(--text-strong);margin:0 0 6px;">{{ v.t }}</h3>
                        <p style="font:var(--body-sm);color:var(--text-muted);margin:0;">{{ v.d }}</p>
                    </Card>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section style="max-width:1180px;margin:0 auto;padding:64px 28px;text-align:center;">
            <h2 style="font:var(--fw-bold) var(--text-3xl)/1.1 var(--font-display);color:var(--text-strong);margin:0 0 16px;">Conocé nuestros productos</h2>
            <Button variant="primary" size="lg" @click="router.visit('/productos')">Ver productos</Button>
        </section>
    </PublicLayout>
</template>

<style scoped>
@media (max-width: 860px) {
    .conocenos-grid { grid-template-columns: 1fr 1fr !important; }
}
@media (max-width: 480px) {
    .conocenos-grid { grid-template-columns: 1fr !important; }
}
</style>
