<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { MapPin, ArrowRight, Briefcase } from 'lucide-vue-next';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

defineProps({
    vacantes: { type: Array, default: () => [] },
});
</script>

<template>
    <Head title="Trabajá con nosotros" />

    <PublicLayout>
        <section style="position:relative;background:var(--grad-blue);overflow:hidden;">
            <img src="/img/liborio/espiga-mark-white.png" alt="" style="position:absolute;right:-10px;bottom:-20px;width:200px;opacity:0.1;" />
            <div style="position:relative;max-width:1180px;margin:0 auto;padding:60px 28px;">
                <Eyebrow color="var(--brand-accent)" :with-mark="true">Sumate a Liborio</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;margin:12px 0 12px;">Trabajá con nosotros</h1>
                <p style="font:var(--body-lg);color:rgba(255,255,255,0.9);max-width:520px;margin:0;">
                    Crecé con una marca 100% costarricense. Conocé nuestras vacantes disponibles.
                </p>
            </div>
            <Cintillo :height="8" />
        </section>

        <section style="max-width:880px;margin:0 auto;padding:56px 28px 80px;">
            <div style="display:flex;flex-direction:column;gap:18px;">
                <Link
                    v-for="v in vacantes"
                    :key="v.id"
                    :href="`/trabaje-con-nosotros/puesto/${v.id}`"
                    class="vac-card"
                    style="display:flex;align-items:center;gap:18px;background:var(--surface-card);border:1px solid var(--border-subtle);border-radius:var(--radius-card);padding:22px 24px;box-shadow:var(--shadow-sm);"
                >
                    <span style="flex:0 0 auto;width:52px;height:52px;border-radius:var(--radius-md);background:var(--red-50);color:var(--brand-primary);display:flex;align-items:center;justify-content:center;"><Briefcase :size="24" /></span>
                    <div style="flex:1;">
                        <h3 style="font:var(--fw-bold) var(--text-xl)/1.2 var(--font-display);color:var(--text-strong);margin:0 0 4px;">{{ v.titulo }}</h3>
                        <span v-if="v.ubicacion" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);font-family:var(--font-sans);font-size:14px;"><MapPin :size="15" /> {{ v.ubicacion }}</span>
                    </div>
                    <span style="color:var(--brand-primary);flex:0 0 auto;"><ArrowRight :size="22" /></span>
                </Link>
            </div>
            <p v-if="!vacantes.length" style="text-align:center;color:var(--text-muted);padding:40px 0;">
                Por el momento no tenemos vacantes abiertas. ¡Volvé pronto!
            </p>
        </section>
    </PublicLayout>
</template>

<style scoped>
.vac-card { transition: box-shadow var(--dur-base) var(--ease-standard), transform var(--dur-base) var(--ease-standard); }
.vac-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
</style>
