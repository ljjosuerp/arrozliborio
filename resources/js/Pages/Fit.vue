<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { ShoppingBasket, HeartPulse, Droplet, WheatOff, Sparkles } from 'lucide-vue-next';
import { shoppingUrl } from '@/shopping';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Card from '@/Components/ds/Card.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import ProductPack from '@/Components/ds/ProductPack.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';
import Input from '@/Components/ds/Input.vue';
import Checkbox from '@/Components/ds/Checkbox.vue';
import Toast from '@/Components/ds/Toast.vue';

const benefits = [
    { icon: HeartPulse, t: 'Sin colesterol', d: 'Cuidá tu corazón en cada plato.' },
    { icon: Droplet, t: 'Bajo en sodio', d: 'Sabor pleno, menos sal.' },
    { icon: WheatOff, t: 'Libre de gluten', d: 'Apto para toda la familia.' },
    { icon: Sparkles, t: '99% menos grasa', d: 'Liviano y lleno de energía.' },
];

const email = ref('');
const acepta = ref(true);
const toast = ref(null);
let timer = null;

const suscribir = () => {
    toast.value = { tone: 'success', title: '¡Listo!', msg: 'Te suscribiste a las recetas de Liborio.' };
    email.value = '';
    clearTimeout(timer);
    timer = setTimeout(() => (toast.value = null), 3500);
};
</script>

<template>
    <Head title="Liborio Fit" />

    <PublicLayout>
        <!-- HERO celeste -->
        <section style="position:relative;background:var(--grad-celeste);overflow:hidden;">
            <img src="/img/liborio/espiga-mark-blue.webp" alt="" style="position:absolute;left:-30px;top:-20px;width:200px;opacity:0.12;" />
            <div class="fit-hero" style="max-width:1180px;margin:0 auto;padding:60px 28px;display:grid;grid-template-columns:1.1fr 0.9fr;gap:36px;align-items:center;">
                <div>
                    <Eyebrow color="var(--blue-600)" :with-mark="true">Vamos al grano</Eyebrow>
                    <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:var(--blue-700);margin:12px 0 16px;">
                        Nuevo año,<br />vida saludable
                    </h1>
                    <p style="font:var(--body-lg);color:var(--blue-700);opacity:0.85;max-width:460px;margin-bottom:24px;">
                        Elegí vivir sano este año con Liborio Fit. Un grano de salud en cada plato, para que vos y
                        tu familia disfruten de lo mejor de nuestra tierra.
                    </p>
                    <Button :href="shoppingUrl('Arroz Liborio Fit')" target="_blank" variant="secondary" size="lg">
                        <template #iconLeft><ShoppingBasket :size="20" /></template>
                        Dónde comprar
                    </Button>
                </div>
                <div style="display:flex;justify-content:center;">
                    <div style="transform:scale(1.25);"><ProductPack color="celeste" label="Liborio Fit" weight="900 g · Integral" highlight="Fit" image="/img/liborio/productos/Arroz-liborio-fit-99-18kg.webp" /></div>
                </div>
            </div>
            <Cintillo :height="8" />
        </section>

        <!-- BENEFICIOS -->
        <section style="max-width:1180px;margin:0 auto;padding:60px 28px;">
            <div style="text-align:center;margin-bottom:36px;">
                <Eyebrow :with-mark="true">Salud en tu mesa</Eyebrow>
                <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 0;">Libre de preocupaciones</h2>
            </div>
            <div class="fit-benefits" style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;">
                <Card v-for="b in benefits" :key="b.t" elevation="sm" padding="lg" :style="{ textAlign: 'center' }">
                    <div style="width:52px;height:52px;border-radius:50%;background:var(--celeste-100);color:var(--blue-600);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                        <component :is="b.icon" :size="24" />
                    </div>
                    <h3 style="font:var(--fw-bold) var(--text-lg)/1.2 var(--font-sans);color:var(--text-strong);margin:0 0 6px;">{{ b.t }}</h3>
                    <p style="font:var(--body-sm);color:var(--text-muted);margin:0;">{{ b.d }}</p>
                </Card>
            </div>
            <p style="text-align:center;font-size:12px;color:var(--text-faint);margin-top:18px;">
                75% más fibra significa que tu digestión te lo va a agradecer. *Comparativa con el arroz blanco.
            </p>
        </section>

        <!-- NEWSLETTER -->
        <section style="background:var(--surface-sunken);border-top:1px solid var(--border-subtle);">
            <div style="max-width:720px;margin:0 auto;padding:52px 28px;text-align:center;">
                <h2 style="font:var(--fw-bold) var(--text-3xl)/1.1 var(--font-display);color:var(--text-strong);margin:0 0 10px;">Recetas Fit, directo a tu correo</h2>
                <p style="font:var(--body-md);color:var(--text-body);margin:0 0 22px;">Explorá las posibilidades con Liborio Fit. Sumate y recibí ideas saludables cada semana.</p>
                <form style="display:flex;gap:12px;max-width:480px;margin:0 auto;align-items:flex-start;" @submit.prevent="suscribir">
                    <Input v-model="email" type="email" placeholder="vos@correo.cr" :container-style="{ flex: 1 }" />
                    <Button variant="primary" type="submit">Suscribirme</Button>
                </form>
                <div style="margin-top:14px;display:flex;justify-content:center;">
                    <Checkbox v-model="acepta" label="Quiero recibir recetas y promos de Liborio" />
                </div>
            </div>
        </section>

        <!-- Toast -->
        <div v-if="toast" style="position:fixed;right:24px;bottom:24px;z-index:1200;">
            <Toast :tone="toast.tone" :title="toast.title" @close="toast = null">{{ toast.msg }}</Toast>
        </div>
    </PublicLayout>
</template>

<style scoped>
@media (max-width: 860px) {
    .fit-hero { grid-template-columns: 1fr !important; }
    .fit-benefits { grid-template-columns: repeat(2, 1fr) !important; }
}
@media (max-width: 480px) {
    .fit-benefits { grid-template-columns: 1fr !important; }
}
</style>
