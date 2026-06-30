<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';

const secciones = [
    {
        h: '1. Información general',
        p: 'Este sitio es operado por Arrocera Liborio. Al acceder y utilizarlo, usted acepta los presentes términos. El contenido tiene fines informativos sobre nuestros productos y la marca.',
    },
    {
        h: '2. Propiedad intelectual',
        p: 'Las marcas, logotipos, nombres comerciales, textos e imágenes presentes en este sitio son propiedad de Arrocera Liborio o se usan con autorización. Queda prohibida su reproducción sin consentimiento previo.',
    },
    {
        h: '3. Privacidad y datos personales',
        p: 'Los datos que usted nos brinde mediante formularios (contacto, empleo, suscripciones) se utilizan únicamente para los fines indicados y se tratan conforme a la legislación costarricense de protección de datos.',
    },
    {
        h: '4. Uso del sitio',
        p: 'El usuario se compromete a utilizar el sitio de forma lícita. Arrocera Liborio no se hace responsable por usos indebidos ni por interrupciones temporales del servicio.',
    },
    {
        h: '5. Contacto',
        p: 'Para consultas sobre estos términos puede escribirnos a info@arrozliborio.com.',
    },
];
</script>

<template>
    <Head title="Apartado legal" />

    <PublicLayout>
        <section style="position:relative;background:var(--surface-inverse);overflow:hidden;">
            <div style="max-width:1180px;margin:0 auto;padding:56px 28px;">
                <Eyebrow color="var(--brand-accent)" :with-mark="true">Arrocera Liborio</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;margin:12px 0 0;">Apartado legal</h1>
            </div>
            <Cintillo :height="8" />
        </section>

        <section style="max-width:760px;margin:0 auto;padding:64px 28px;">
            <div v-for="s in secciones" :key="s.h" style="margin-bottom:32px;">
                <h2 style="font:var(--fw-semibold) var(--text-2xl)/1.2 var(--font-display);color:var(--text-strong);margin:0 0 8px;">{{ s.h }}</h2>
                <p style="font:var(--body-md);color:var(--text-body);margin:0;">{{ s.p }}</p>
            </div>
            <p style="font:var(--body-sm);color:var(--text-faint);margin-top:8px;">Última actualización: {{ new Date().getFullYear() }}.</p>
        </section>
    </PublicLayout>
</template>
