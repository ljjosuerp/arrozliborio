<script setup>
import { Head, router } from '@inertiajs/vue3';
import { Sprout, Award, Truck, Wheat, ArrowRight, ShoppingBag } from 'lucide-vue-next';
import { shoppingUrl } from '@/shopping';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Card from '@/Components/ds/Card.vue';
import Tag from '@/Components/ds/Tag.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import ProductPack from '@/Components/ds/ProductPack.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';
import Counter from '@/Components/ds/Counter.vue';
import Testimonios from '@/Components/ds/Testimonios.vue';

const go = (href) => router.visit(href);

// Cifras de marca (datos reales: 7 provincias, ~80 puntos de venta, 100% CR, 4 líneas).
const cifras = [
    { to: 100, suffix: '%', label: 'Costarricense' },
    { to: 80, suffix: '+', label: 'Puntos de venta' },
    { to: 7, suffix: '', label: 'Provincias' },
    { to: 4, suffix: '', label: 'Líneas de producto' },
];

// TODO: reemplazar con reseñas REALES de clientes antes de depender de ellas.
const testimonios = [
    { texto: 'El arroz que siempre queda suelto y en su punto. En mi casa no falta.', autor: 'María Fernández', lugar: 'San José', estrellas: 5 },
    { texto: 'Con Liborio Fit por fin encontré un semi integral que a los chiquitos les gusta.', autor: 'Carlos Jiménez', lugar: 'Alajuela', estrellas: 5 },
    { texto: 'Producto tico de calidad. Apoyo al productor nacional en cada compra.', autor: 'Ana Rodríguez', lugar: 'Guanacaste', estrellas: 5 },
];

const P = '/img/liborio/productos/';
const products = [
    { color: 'red', label: 'Arroz Liborio 99%', weight: '1.8 kg / 1 kg', tag: 'Más vendido', tagColor: 'red', image: P + 'Arroz-liborio-99-18kg.webp' },
    { color: 'blue', label: 'Frijoles', weight: '700 g', tag: 'Negro y rojo', tagColor: 'blue', image: P + 'Frijoles-negros-liborio-700g.webp' },
    { color: 'wheat', label: 'Aceite', weight: '900 ml', kind: 'bottle', tag: 'Vegetal', tagColor: 'wheat', image: P + 'Aceite-Liborio.webp' },
    { color: 'celeste', label: 'Liborio Fit', weight: '1.8 kg', tag: 'Semi Integral', tagColor: 'celeste', image: P + 'Arroz-liborio-fit-99-18kg.webp' },
];

const trust = [
    { icon: Wheat, t: '100% Costarricense' },
    { icon: Sprout, t: 'Apoyo al productor nacional' },
    { icon: Award, t: 'Calidad Pantone-perfecta' },
    { icon: Truck, t: 'En toda Costa Rica' },
];

const fitClaims = ['Sin colesterol', 'Bajo en sodio', 'Libre de gluten', '99% menos grasa', '+75% más fibra*'];
</script>

<template>
    <Head title="Inicio" />

    <PublicLayout>
        <!-- HERO -->
        <section style="position:relative;background:var(--grad-red);overflow:hidden;">
            <img src="/img/liborio/hero-liborio-pattern.webp" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.22;mix-blend-mode:luminosity;" />
            <div class="hero-grid" style="position:relative;max-width:1180px;margin:0 auto;padding:70px 28px 84px;display:grid;grid-template-columns:1.1fr 0.9fr;gap:40px;align-items:center;">
                <div>
                    <Eyebrow color="rgba(255,255,255,0.9)" :with-mark="true">Arroz de Costa Rica</Eyebrow>
                    <h1 style="font:var(--fw-bold) var(--text-6xl)/0.98 var(--font-display);color:#fff;letter-spacing:-0.02em;margin:14px 0 18px;">
                        El grano que une<br />a Costa Rica
                    </h1>
                    <p style="font:var(--body-lg);color:rgba(255,255,255,0.92);max-width:460px;margin-bottom:28px;">
                        Arroz, frijoles y aceite cultivados y empacados con el alma de nuestra tierra.
                        De la pampa a tu mesa, apoyando siempre al productor nacional.
                    </p>
                    <div style="display:flex;gap:14px;flex-wrap:wrap;">
                        <Button variant="primary" size="lg" :style="{ background: '#fff', color: 'var(--brand-primary)', boxShadow: 'var(--shadow-lg)' }" @click="go('/productos')">Ver productos</Button>
                        <Button variant="outline" size="lg" :style="{ color: '#fff', borderColor: 'rgba(255,255,255,0.7)' }" @click="go('/conocenos')">Nuestra historia</Button>
                    </div>
                </div>
                <div style="display:flex;justify-content:center;gap:8px;">
                    <div class="lb-float" style="margin-top:30px;"><ProductPack color="red" label="Arroz" weight="1.8 kg" :image="P + 'Arroz-liborio-99-18kg.webp'" /></div>
                    <div class="lb-float" style="animation-delay:-3s;"><ProductPack color="celeste" label="Liborio Fit" weight="1.8 kg" highlight="Fit" :image="P + 'Arroz-liborio-fit-99-18kg.webp'" /></div>
                </div>
            </div>
            <Cintillo :height="8" />
        </section>

        <!-- TRUST STRIP -->
        <section style="background:var(--surface-card);border-bottom:1px solid var(--border-subtle);">
            <div style="max-width:1180px;margin:0 auto;padding:20px 28px;display:flex;flex-wrap:wrap;gap:30px;justify-content:space-between;">
                <div v-for="item in trust" :key="item.t" style="display:flex;align-items:center;gap:10px;color:var(--text-body);font-family:var(--font-sans);font-weight:600;font-size:14px;">
                    <span style="color:var(--brand-primary);display:flex;"><component :is="item.icon" :size="20" /></span>{{ item.t }}
                </div>
            </div>
        </section>

        <!-- CIFRAS -->
        <section style="max-width:1180px;margin:0 auto;padding:56px 28px 8px;">
            <div v-reveal class="cifras-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:22px;text-align:center;">
                <div v-for="c in cifras" :key="c.label">
                    <div style="font:var(--fw-bold) var(--text-5xl)/1 var(--font-display);color:var(--brand-primary);">
                        <Counter :to="c.to" :suffix="c.suffix" />
                    </div>
                    <div style="font-family:var(--font-sans);font-weight:600;color:var(--text-muted);margin-top:6px;">{{ c.label }}</div>
                </div>
            </div>
        </section>

        <!-- PRODUCTS -->
        <section style="max-width:1180px;margin:0 auto;padding:48px 28px 40px;">
            <div v-reveal style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:30px;">
                <div>
                    <Eyebrow :with-mark="true">Nuestra cartera</Eyebrow>
                    <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 0;">Productos Liborio</h2>
                </div>
                <button @click="go('/productos')" style="border:none;background:none;color:var(--brand-primary);font-weight:800;font-size:15px;cursor:pointer;display:flex;align-items:center;gap:6px;font-family:var(--font-sans);">
                    Ver todo <ArrowRight :size="18" />
                </button>
            </div>
            <div class="products-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:22px;">
                <Card v-for="(p, idx) in products" :key="p.label" v-reveal="idx * 90" elevation="sm" padding="lg" :interactive="true" :style="{ display: 'flex', flexDirection: 'column', alignItems: 'center', textAlign: 'center' }">
                    <Tag :color="p.tagColor" :style="{ alignSelf: 'flex-start' }">{{ p.tag }}</Tag>
                    <div style="margin:18px 0 6px;">
                        <ProductPack :color="p.color" :label="p.label" :weight="p.weight" :kind="p.kind || 'bag'" :highlight="p.label === 'Liborio Fit' ? 'Fit' : ''" :image="p.image" />
                    </div>
                    <Button :href="shoppingUrl(p.label)" target="_blank" variant="outline" size="sm" :style="{ marginTop: '14px' }">
                        <template #iconLeft><ShoppingBag :size="16" /></template>
                        Dónde comprar
                    </Button>
                </Card>
            </div>
        </section>

        <!-- FIT BAND -->
        <section style="background:var(--surface-inverse);position:relative;overflow:hidden;margin:40px 0;">
            <img src="/img/liborio/espiga-mark-white.webp" alt="" class="lb-breathe" style="position:absolute;right:-20px;bottom:-20px;width:220px;opacity:0.08;transform-origin:bottom right;" />
            <div class="fit-grid" style="max-width:1180px;margin:0 auto;padding:60px 28px;display:grid;grid-template-columns:0.8fr 1.2fr;gap:44px;align-items:center;">
                <div v-reveal class="lb-float" style="display:flex;justify-content:center;gap:10px;">
                    <ProductPack color="celeste" label="Liborio Fit" weight="1.8 kg · Semi Integral" highlight="Fit" :image="P + 'Arroz-liborio-fit-99-18kg.webp'" />
                </div>
                <div v-reveal="120">
                    <Eyebrow color="var(--brand-accent)" :with-mark="true">Vamos al grano</Eyebrow>
                    <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:#fff;margin:12px 0 14px;">Salud en tu mesa,<br />libre de preocupaciones</h2>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:22px;">
                        <Tag v-for="c in fitClaims" :key="c" color="celeste" :soft="false">{{ c }}</Tag>
                    </div>
                    <Button variant="primary" size="lg" :style="{ background: '#fff', color: 'var(--brand-secondary)' }" @click="go('/liborio-fit')">Descubrí Liborio Fit</Button>
                    <p style="font-size:12px;color:rgba(255,255,255,0.6);margin-top:14px;">*Comparativa con el arroz blanco</p>
                </div>
            </div>
        </section>

        <!-- TESTIMONIOS -->
        <section style="max-width:1180px;margin:0 auto;padding:56px 28px;">
            <div v-reveal style="text-align:center;margin-bottom:34px;">
                <Eyebrow :with-mark="true">Lo que dicen las familias</Eyebrow>
                <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 0;">Parte de tu mesa</h2>
            </div>
            <div v-reveal="100">
                <Testimonios :items="testimonios" />
            </div>
        </section>

        <!-- PRODUCER STORY -->
        <section style="max-width:1180px;margin:0 auto;padding:20px 28px 80px;">
            <div v-reveal class="story-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center;">
                <div>
                    <Eyebrow :with-mark="true">Apoyamos al productor nacional</Eyebrow>
                    <h2 style="font:var(--fw-bold) var(--text-3xl)/1.1 var(--font-display);color:var(--text-strong);margin:12px 0 16px;">
                        "¡Conocé de dónde viene tu arroz!"
                    </h2>
                    <p style="font:var(--body-md);color:var(--text-body);margin-bottom:14px;">
                        Cada grano de Liborio nace en los campos de Costa Rica. Trabajamos de la mano con familias
                        productoras para llevar a tu cocina lo mejor de nuestra tierra — con la calidad y el sabor
                        que nos hacen parte de tu mesa.
                    </p>
                    <Button variant="ghost" @click="go('/conocenos')">
                        Leé nuestra historia
                        <template #iconRight><ArrowRight :size="18" /></template>
                    </Button>
                </div>
                <div style="position:relative;border-radius:var(--radius-lg);overflow:hidden;height:280px;background:var(--grad-harvest);box-shadow:var(--shadow-md);">
                    <img src="/img/liborio/hero-liborio-pattern.webp" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.3;mix-blend-mode:multiply;" />
                    <div style="position:absolute;inset:0;display:flex;align-items:flex-end;padding:22px;background:var(--grad-protect-bottom);">
                        <div style="color:#fff;">
                            <div style="font-family:var(--font-display);font-weight:700;font-size:22px;">De la pampa a su mesa</div>
                            <div style="font-size:13px;opacity:0.85;">Productores · Costa Rica</div>
                        </div>
                    </div>
                    <div style="position:absolute;top:16px;left:16px;width:6px;height:64px;background:linear-gradient(to bottom,var(--cr-blue) 0 33.33%,var(--cr-white) 33.33% 66.66%,var(--cr-red) 66.66% 100%);border-radius:4px;" />
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
@media (max-width: 860px) {
    .hero-grid { grid-template-columns: 1fr !important; }
    .products-grid { grid-template-columns: repeat(2, 1fr) !important; }
    .fit-grid { grid-template-columns: 1fr !important; }
    .story-grid { grid-template-columns: 1fr !important; }
    .cifras-grid { grid-template-columns: repeat(2, 1fr) !important; row-gap: 28px !important; }
}
@media (max-width: 480px) {
    .products-grid { grid-template-columns: 1fr !important; }
}
</style>
