<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ShoppingBasket, Instagram, Facebook, Youtube, Menu } from 'lucide-vue-next';
import Cintillo from '@/Components/ds/Cintillo.vue';

// Nav del design system, mapeado a las rutas reales del proyecto.
const links = [
    { label: 'Inicio', href: '/' },
    { label: 'Productos', href: '/productos' },
    { label: 'Liborio Fit', href: '/liborio-fit' },
    { label: 'Nuestra historia', href: '/conocenos' },
    { label: 'Recetas', href: '/recetas' },
];

const footerCols = [
    { h: 'Productos', items: [['Arroz Liborio', '/productos'], ['Frijoles', '/productos'], ['Aceite', '/productos'], ['Liborio Fit', '/liborio-fit']] },
    { h: 'Marca', items: [['Nuestra historia', '/conocenos'], ['Productor nacional', '/sostenibilidad'], ['Recetas', '/recetas'], ['Sostenibilidad', '/sostenibilidad']] },
    { h: 'Ayuda', items: [['Dónde comprar', '/hablemos'], ['Contacto', '/hablemos'], ['Trabajá con nosotros', '/trabaje-con-nosotros']] },
];

const page = usePage();
const current = computed(() => page.url.split('?')[0]);
const isActive = (href) => (href === '/' ? current.value === '/' : current.value.startsWith(href));

const mobileOpen = ref(false);
</script>

<template>
    <div style="min-height:100vh;display:flex;flex-direction:column;background:var(--surface-page);">
        <!-- ─── Header ─── -->
        <header style="position:sticky;top:0;z-index:100;background:rgba(251,248,243,0.9);backdrop-filter:blur(8px);border-bottom:1px solid var(--border-subtle);">
            <Cintillo :height="4" />
            <div style="max-width:1180px;margin:0 auto;padding:14px 28px;display:flex;align-items:center;gap:28px;">
                <Link href="/" style="display:flex;flex-shrink:0;">
                    <img src="/img/liborio/logo-liborio-red.png" alt="Arroz Liborio" style="height:42px;" />
                </Link>

                <!-- Nav desktop -->
                <nav class="lb-nav" style="display:flex;gap:22px;margin-left:8px;">
                    <Link
                        v-for="l in links"
                        :key="l.href"
                        :href="l.href"
                        class="lb-navlink"
                        :style="{
                            fontFamily: 'var(--font-sans)',
                            fontSize: '15px',
                            fontWeight: isActive(l.href) ? 800 : 600,
                            color: isActive(l.href) ? 'var(--brand-primary)' : 'var(--text-body)',
                            padding: '6px 0',
                            position: 'relative',
                        }"
                    >
                        {{ l.label }}
                        <span v-if="isActive(l.href)" style="position:absolute;left:0;right:0;bottom:-2px;height:2px;background:var(--brand-primary);border-radius:2px;" />
                    </Link>
                </nav>

                <div style="margin-left:auto;display:flex;align-items:center;gap:14px;">
                    <Link href="/hablemos" class="lb-donde" style="display:inline-flex;align-items:center;gap:8px;border:1.5px solid var(--brand-primary);color:var(--brand-primary);border-radius:var(--radius-pill);padding:8px 16px;font-family:var(--font-sans);font-weight:800;font-size:14px;">
                        <ShoppingBasket :size="18" />
                        <span class="lb-donde-text">Dónde comprar</span>
                    </Link>
                    <!-- Toggle móvil -->
                    <button class="lb-burger" aria-label="Menú" style="border:none;background:none;cursor:pointer;color:var(--text-body);display:none;" @click="mobileOpen = !mobileOpen">
                        <Menu :size="24" />
                    </button>
                </div>
            </div>

            <!-- Nav móvil -->
            <nav v-show="mobileOpen" class="lb-mobile-nav" style="border-top:1px solid var(--border-subtle);background:var(--paper);">
                <div style="padding:8px 28px 14px;display:flex;flex-direction:column;">
                    <Link
                        v-for="l in links"
                        :key="l.href"
                        :href="l.href"
                        :style="{ padding: '10px 0', fontFamily: 'var(--font-sans)', fontWeight: isActive(l.href) ? 800 : 600, color: isActive(l.href) ? 'var(--brand-primary)' : 'var(--text-body)' }"
                        @click="mobileOpen = false"
                    >
                        {{ l.label }}
                    </Link>
                </div>
            </nav>
        </header>

        <!-- ─── Contenido ─── -->
        <div style="flex:1;">
            <slot />
        </div>

        <!-- ─── Footer ─── -->
        <footer style="background:var(--blue-700);color:rgba(255,255,255,0.8);">
            <Cintillo :height="6" />
            <div class="lb-footer-grid" style="max-width:1180px;margin:0 auto;padding:48px 28px 28px;display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:32px;">
                <div>
                    <img src="/img/liborio/logo-liborio-white.png" alt="Arroz Liborio" style="height:46px;margin-bottom:14px;" />
                    <p style="font-size:14px;line-height:1.6;max-width:240px;margin:0;">
                        Arroz, frijoles y aceite 100% costarricenses. De la pampa a tu mesa.
                    </p>
                    <div style="display:flex;gap:12px;margin-top:18px;">
                        <span v-for="(Icon, i) in [Instagram, Facebook, Youtube]" :key="i"
                            style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:#fff;cursor:pointer;">
                            <component :is="Icon" :size="18" />
                        </span>
                    </div>
                </div>
                <div v-for="col in footerCols" :key="col.h">
                    <div style="font-family:var(--font-sans);font-weight:800;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#fff;margin-bottom:14px;">{{ col.h }}</div>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                        <li v-for="(it, i) in col.items" :key="i">
                            <Link :href="it[1]" style="color:rgba(255,255,255,0.8);font-size:14px;font-family:var(--font-sans);">{{ it[0] }}</Link>
                        </li>
                    </ul>
                </div>
            </div>
            <div style="border-top:1px solid rgba(255,255,255,0.12);padding:18px 28px;text-align:center;font-size:13px;color:rgba(255,255,255,0.6);">
                © {{ new Date().getFullYear() }} Arrocera Liborio · Hecho en Costa Rica · Apoyamos al productor nacional
            </div>
        </footer>
    </div>
</template>

<style scoped>
.lb-navlink:hover { color: var(--brand-primary) !important; }
.lb-donde { transition: background var(--dur-fast) var(--ease-standard); }
.lb-donde:hover { background: var(--red-50); }

/* En pantallas chicas el botón queda solo con el ícono */
@media (max-width: 520px) {
    .lb-donde-text { display: none; }
}

/* Responsive: oculta el nav desktop y muestra el burger en móvil */
@media (max-width: 860px) {
    .lb-nav { display: none !important; }
    .lb-burger { display: flex !important; }
    .lb-footer-grid { grid-template-columns: 1fr 1fr !important; }
}
@media (min-width: 861px) {
    .lb-mobile-nav { display: none !important; }
}
</style>
