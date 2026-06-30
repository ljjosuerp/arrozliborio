<script setup>
import { Head, router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

defineProps({
    titulo: { type: String, required: true },
    fase: { type: String, default: '' },
});
</script>

<template>
    <Head :title="titulo" />

    <PublicLayout>
        <section style="position:relative;background:var(--grad-red);overflow:hidden;">
            <img src="/img/liborio/hero-liborio-pattern.jpg" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.18;mix-blend-mode:luminosity;" />
            <div style="position:relative;max-width:1180px;margin:0 auto;padding:56px 28px;">
                <Eyebrow color="rgba(255,255,255,0.9)" :with-mark="true">Arrocera Liborio</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;margin:12px 0 0;">{{ titulo }}</h1>
            </div>
            <Cintillo :height="8" />
        </section>

        <section style="max-width:680px;margin:0 auto;padding:90px 28px;text-align:center;">
            <div style="margin:0 auto 22px;width:64px;height:64px;border-radius:50%;background:var(--surface-sunken);display:flex;align-items:center;justify-content:center;font-size:30px;">🌾</div>
            <h2 style="font:var(--fw-bold) var(--text-3xl)/1.1 var(--font-display);color:var(--text-strong);margin:0 0 12px;">Sección en construcción</h2>
            <p style="font:var(--body-md);color:var(--text-body);margin:0 0 28px;">
                Esta página forma parte del rebuild de arrozliborio.com y se construirá
                <template v-if="fase">en la <strong>{{ fase }}</strong></template>
                <template v-else>en una próxima fase</template>
                del blueprint.
            </p>
            <Button variant="primary" @click="router.visit('/')">Volver al inicio</Button>
        </section>
    </PublicLayout>
</template>
