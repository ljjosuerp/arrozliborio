<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import { ShoppingBasket, HeartPulse, Droplet, WheatOff, Sparkles, Leaf, ShieldCheck } from 'lucide-vue-next';
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

// Contenido editable desde el panel de admin (Filament → Contenido → Páginas).
// Si la base de datos aún no tiene el registro, se usan los valores por defecto.
const props = defineProps({
    contenido: { type: Object, default: null },
});

// Mapa nombre-de-ícono (guardado en la BD) → componente de lucide.
const iconMap = {
    corazon: HeartPulse,
    gota: Droplet,
    trigo: WheatOff,
    chispa: Sparkles,
    hoja: Leaf,
    escudo: ShieldCheck,
};
const iconFor = (nombre) => iconMap[nombre] || Sparkles;

const defaults = {
    hero: {
        eyebrow: 'Vamos al grano',
        titulo: 'Nuevo año, vida saludable',
        texto: 'Elegí vivir sano este año con Liborio Fit. Un grano de salud en cada plato, para que vos y tu familia disfruten de lo mejor de nuestra tierra.',
        cta: 'Dónde comprar',
        tema: 'celeste',
    },
    beneficios_eyebrow: 'Salud en tu mesa',
    beneficios_titulo: 'Libre de preocupaciones',
    beneficios: [
        { icono: 'corazon', titulo: 'Sin colesterol', texto: 'Cuidá tu corazón en cada plato.' },
        { icono: 'gota', titulo: 'Bajo en sodio', texto: 'Sabor pleno, menos sal.' },
        { icono: 'trigo', titulo: 'Libre de gluten', texto: 'Apto para toda la familia.' },
        { icono: 'chispa', titulo: '99% menos grasa', texto: 'Liviano y lleno de energía.' },
    ],
    nota: '75% más fibra significa que tu digestión te lo va a agradecer. *Comparativa con el arroz blanco.',
    newsletter: {
        titulo: 'Recetas Fit, directo a tu correo',
        texto: 'Explorá las posibilidades con Liborio Fit. Sumate y recibí ideas saludables cada semana.',
    },
};

// Fusiona lo que venga de la BD con los valores por defecto (por si algún campo queda vacío).
const c = computed(() => {
    const src = props.contenido || {};
    return {
        hero: { ...defaults.hero, ...(src.hero || {}) },
        beneficios_eyebrow: src.beneficios_eyebrow || defaults.beneficios_eyebrow,
        beneficios_titulo: src.beneficios_titulo || defaults.beneficios_titulo,
        beneficios: (Array.isArray(src.beneficios) && src.beneficios.length) ? src.beneficios : defaults.beneficios,
        nota: src.nota || defaults.nota,
        newsletter: { ...defaults.newsletter, ...(src.newsletter || {}) },
    };
});

// Temas de color del hero (elegibles desde el admin). Todos con buen contraste.
const temas = {
    celeste: { grad: 'linear-gradient(135deg,#B7E6F2 0%,#87D1E6 100%)', texto: 'var(--blue-700)', eyebrow: 'var(--blue-600)', marca: '/img/liborio/espiga-mark-blue.webp' },
    verde: { grad: 'linear-gradient(135deg,#D3ECC2 0%,#8DC63F 100%)', texto: '#1B4B21', eyebrow: '#2E7D32', marca: '/img/liborio/espiga-mark-blue.webp' },
    amarillo: { grad: 'linear-gradient(135deg,#FBF4BF 0%,#F0E25C 100%)', texto: 'var(--blue-700)', eyebrow: '#8A7A00', marca: '/img/liborio/espiga-mark-blue.webp' },
    trigo: { grad: 'linear-gradient(135deg,#F6EADB 0%,#D7A461 100%)', texto: '#5A3D18', eyebrow: '#A9762F', marca: '/img/liborio/espiga-mark-blue.webp' },
};
const tema = computed(() => temas[c.value.hero.tema] || temas.celeste);

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
        <!-- HERO (color editable desde el admin) -->
        <section :style="{ position: 'relative', background: tema.grad, overflow: 'hidden' }">
            <img :src="tema.marca" alt="" style="position:absolute;left:-30px;top:-20px;width:200px;opacity:0.12;" />
            <div class="fit-hero" style="max-width:1180px;margin:0 auto;padding:60px 28px;display:grid;grid-template-columns:1.1fr 0.9fr;gap:36px;align-items:center;">
                <div>
                    <Eyebrow :color="tema.eyebrow" :with-mark="true">{{ c.hero.eyebrow }}</Eyebrow>
                    <h1 :style="{ font: 'var(--fw-bold) var(--text-5xl)/1.0 var(--font-display)', color: tema.texto, margin: '12px 0 16px' }">
                        {{ c.hero.titulo }}
                    </h1>
                    <p :style="{ font: 'var(--body-lg)', color: tema.texto, opacity: 0.85, maxWidth: '460px', marginBottom: '24px' }">
                        {{ c.hero.texto }}
                    </p>
                    <Button :href="shoppingUrl('Arroz Liborio Fit')" target="_blank" variant="secondary" size="lg">
                        <template #iconLeft><ShoppingBasket :size="20" /></template>
                        {{ c.hero.cta }}
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
                <Eyebrow :with-mark="true">{{ c.beneficios_eyebrow }}</Eyebrow>
                <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 0;">{{ c.beneficios_titulo }}</h2>
            </div>
            <div class="fit-benefits" :style="{ display: 'grid', gridTemplateColumns: `repeat(${Math.min(c.beneficios.length, 4)}, 1fr)`, gap: '20px' }">
                <Card v-for="(b, i) in c.beneficios" :key="i" elevation="sm" padding="lg" :style="{ textAlign: 'center' }">
                    <div style="width:52px;height:52px;border-radius:50%;background:var(--celeste-100);color:var(--blue-600);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                        <component :is="iconFor(b.icono)" :size="24" />
                    </div>
                    <h3 style="font:var(--fw-bold) var(--text-lg)/1.2 var(--font-sans);color:var(--text-strong);margin:0 0 6px;">{{ b.titulo }}</h3>
                    <p style="font:var(--body-sm);color:var(--text-muted);margin:0;">{{ b.texto }}</p>
                </Card>
            </div>
            <p v-if="c.nota" style="text-align:center;font-size:12px;color:var(--text-faint);margin-top:18px;">
                {{ c.nota }}
            </p>
        </section>

        <!-- NEWSLETTER -->
        <section style="background:var(--surface-sunken);border-top:1px solid var(--border-subtle);">
            <div style="max-width:720px;margin:0 auto;padding:52px 28px;text-align:center;">
                <h2 style="font:var(--fw-bold) var(--text-3xl)/1.1 var(--font-display);color:var(--text-strong);margin:0 0 10px;">{{ c.newsletter.titulo }}</h2>
                <p style="font:var(--body-md);color:var(--text-body);margin:0 0 22px;">{{ c.newsletter.texto }}</p>
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
