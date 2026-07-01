<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { MapPin, ArrowLeft, CheckCircle2 } from 'lucide-vue-next';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

const props = defineProps({
    puesto: { type: Object, required: true },
    autenticado: { type: Boolean, default: false },
});

const page = usePage();
const aplicado = computed(() => page.props.flash?.aplicado);

const requisitos = computed(() =>
    (props.puesto.requisitos || '').split('\n').map((r) => r.trim()).filter(Boolean)
);
</script>

<template>
    <Head :title="puesto.titulo" />

    <PublicLayout>
        <section style="position:relative;background:var(--grad-blue);overflow:hidden;">
            <img src="/img/liborio/espiga-mark-white.webp" alt="" style="position:absolute;right:-10px;bottom:-20px;width:200px;opacity:0.1;" />
            <div style="position:relative;max-width:880px;margin:0 auto;padding:56px 28px;">
                <Eyebrow color="var(--brand-accent)" :with-mark="true">Vacante</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;margin:12px 0 12px;">{{ puesto.titulo }}</h1>
                <span v-if="puesto.ubicacion" style="display:inline-flex;align-items:center;gap:7px;color:rgba(255,255,255,0.9);font-family:var(--font-sans);font-weight:600;"><MapPin :size="18" /> {{ puesto.ubicacion }}</span>
            </div>
            <Cintillo :height="8" />
        </section>

        <section style="max-width:880px;margin:0 auto;padding:48px 28px 40px;">
            <!-- Mensaje de éxito -->
            <div v-if="aplicado" style="display:flex;gap:12px;align-items:flex-start;background:var(--success-surface);border:1px solid var(--success);border-radius:var(--radius-md);padding:16px 18px;margin-bottom:28px;">
                <span style="color:var(--success);flex:0 0 auto;"><CheckCircle2 :size="22" /></span>
                <div>
                    <div style="font-family:var(--font-sans);font-weight:800;color:var(--text-strong);">¡Aplicación enviada!</div>
                    <div style="font-family:var(--font-sans);font-size:14px;color:var(--text-body);">Recibimos tu postulación. Te contactaremos si tu perfil avanza en el proceso.</div>
                </div>
            </div>

            <h2 style="font:var(--fw-semibold) var(--text-2xl)/1.2 var(--font-display);color:var(--text-strong);margin:0 0 10px;">Descripción</h2>
            <p style="font:var(--body-md);color:var(--text-body);white-space:pre-line;margin:0 0 28px;">{{ puesto.descripcion }}</p>

            <template v-if="requisitos.length">
                <h2 style="font:var(--fw-semibold) var(--text-2xl)/1.2 var(--font-display);color:var(--text-strong);margin:0 0 10px;">Requisitos</h2>
                <ul style="margin:0 0 32px;padding-left:20px;">
                    <li v-for="(r, i) in requisitos" :key="i" style="font-family:var(--font-sans);color:var(--text-body);margin-bottom:8px;line-height:1.5;">{{ r }}</li>
                </ul>
            </template>

            <div style="display:flex;flex-wrap:wrap;gap:14px;align-items:center;">
                <Link :href="`/trabaje-con-nosotros/puesto/${puesto.id}/aplicar`">
                    <Button variant="primary" size="lg">Aplicar a este puesto</Button>
                </Link>
                <span v-if="!autenticado" style="font-family:var(--font-sans);font-size:14px;color:var(--text-muted);">
                    Necesitás iniciar sesión o registrarte para aplicar.
                </span>
            </div>
        </section>

        <section style="max-width:880px;margin:0 auto;padding:0 28px 80px;">
            <Link href="/trabaje-con-nosotros" style="display:inline-flex;align-items:center;gap:8px;color:var(--brand-primary);font-family:var(--font-sans);font-weight:800;">
                <ArrowLeft :size="18" /> Volver a vacantes
            </Link>
        </section>
    </PublicLayout>
</template>
