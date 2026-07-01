<script setup>
import { Head, router } from '@inertiajs/vue3';
import { Sprout, Recycle, Users, Wheat } from 'lucide-vue-next';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Card from '@/Components/ds/Card.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

const compromisos = [
    { icon: Sprout, t: 'Apoyo al productor nacional', d: 'Compramos y trabajamos con familias agricultoras costarricenses, fortaleciendo el campo.' },
    { icon: Recycle, t: 'Procesos responsables', d: 'Buscamos eficiencia y menor impacto en cada etapa de producción y empaque.' },
    { icon: Users, t: 'Comunidad', d: 'Generamos empleo y desarrollo en Guanacaste y las regiones donde operamos.' },
    { icon: Wheat, t: 'Calidad del grano', d: 'Cuidamos la cadena desde el cultivo para garantizar un producto fresco y confiable.' },
];
</script>

<template>
    <Head title="Sostenibilidad" />

    <PublicLayout>
        <section style="position:relative;background:var(--grad-harvest);overflow:hidden;">
            <img src="/img/liborio/espiga-mark-red.webp" alt="" style="position:absolute;right:-20px;bottom:-30px;width:220px;opacity:0.15;" />
            <div style="position:relative;max-width:1180px;margin:0 auto;padding:64px 28px;">
                <Eyebrow color="var(--wheat-700)" :with-mark="true">Sostenibilidad</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:var(--text-strong);max-width:680px;margin:12px 0 16px;">Apoyamos al productor nacional</h1>
                <p style="font:var(--body-lg);color:var(--text-body);max-width:560px;margin:0;">
                    Cada grano de Liborio nace en los campos de Costa Rica. Creemos en un crecimiento que
                    respeta a las personas, las comunidades y nuestra tierra.
                </p>
            </div>
            <Cintillo :height="8" />
        </section>

        <section style="max-width:1180px;margin:0 auto;padding:64px 28px;">
            <div style="text-align:center;margin-bottom:36px;">
                <Eyebrow :with-mark="true">Nuestro compromiso</Eyebrow>
                <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 0;">Responsabilidad en cada grano</h2>
            </div>
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:22px;" class="sost-grid">
                <Card v-for="c in compromisos" :key="c.t" elevation="sm" padding="lg" :style="{ display: 'flex', gap: '16px', alignItems: 'flex-start' }">
                    <div style="flex:0 0 auto;width:52px;height:52px;border-radius:50%;background:var(--celeste-100);color:var(--blue-600);display:flex;align-items:center;justify-content:center;">
                        <component :is="c.icon" :size="24" />
                    </div>
                    <div>
                        <h3 style="font:var(--fw-bold) var(--text-lg)/1.2 var(--font-sans);color:var(--text-strong);margin:0 0 6px;">{{ c.t }}</h3>
                        <p style="font:var(--body-sm);color:var(--text-muted);margin:0;">{{ c.d }}</p>
                    </div>
                </Card>
            </div>
        </section>

        <section style="background:var(--surface-inverse);">
            <div style="max-width:880px;margin:0 auto;padding:60px 28px;text-align:center;">
                <h2 style="font:var(--fw-bold) var(--text-3xl)/1.1 var(--font-display);color:#fff;margin:0 0 14px;">"¡Conocé de dónde viene tu arroz!"</h2>
                <p style="font:var(--body-md);color:rgba(255,255,255,0.85);margin:0 0 24px;">Conocé la historia detrás de cada producto Liborio.</p>
                <Button variant="primary" size="lg" :style="{ background: '#fff', color: 'var(--brand-secondary)' }" @click="router.visit('/conocenos')">Nuestra historia</Button>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
@media (max-width: 760px) {
    .sost-grid { grid-template-columns: 1fr !important; }
}
</style>
