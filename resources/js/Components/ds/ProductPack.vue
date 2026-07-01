<script setup>
import { computed } from 'vue';

// Visual estilizado de empaque (sin foto): bolsa/botella en color de marca con logo + espiga.
const props = defineProps({
    color: { type: String, default: 'red' }, // red | blue | celeste | wheat
    label: { type: String, default: 'Arroz' },
    weight: { type: String, default: '1 kg' },
    kind: { type: String, default: 'bag' }, // bag | bottle
    highlight: { type: String, default: '' },
    image: { type: String, default: '' }, // si se da, muestra la foto real del producto
});

const img = (f) => `/img/liborio/${f}`;

const palettes = {
    red: { bg: 'var(--grad-red)', fg: '#fff', logo: 'logo-liborio-white.webp', espiga: 'espiga-mark-white.webp' },
    blue: { bg: 'var(--grad-blue)', fg: '#fff', logo: 'logo-liborio-white.webp', espiga: 'espiga-mark-white.webp' },
    celeste: { bg: 'var(--grad-celeste)', fg: 'var(--blue-700)', logo: 'logo-liborio-blue.webp', espiga: 'espiga-mark-blue.webp' },
    wheat: { bg: 'var(--grad-harvest)', fg: 'var(--wheat-700)', logo: 'logo-liborio-red.webp', espiga: 'espiga-mark-red.webp' },
};

const p = computed(() => palettes[props.color] || palettes.red);
const isBottle = computed(() => props.kind === 'bottle');
</script>

<template>
    <!-- Foto real del producto (renders oficiales de arrozliborio.com) -->
    <div v-if="image" style="display:flex;flex-direction:column;align-items:center;">
        <div style="width:172px;height:210px;display:flex;align-items:center;justify-content:center;">
            <img :src="image" :alt="label" loading="lazy" decoding="async" style="max-width:100%;max-height:100%;object-fit:contain;filter:drop-shadow(0 10px 18px rgba(58,12,14,0.18));" />
        </div>
        <div style="margin-top:10px;font-family:var(--font-sans);font-size:13px;color:var(--text-muted);">{{ weight }}</div>
    </div>

    <!-- Empaque estilizado (respaldo cuando no hay foto) -->
    <div v-else style="display:flex;flex-direction:column;align-items:center;">
        <div
            :style="{
                position: 'relative',
                width: isBottle ? '116px' : '168px',
                height: isBottle ? '240px' : '210px',
                background: p.bg,
                borderRadius: isBottle ? '40px 40px 14px 14px' : '10px 10px 14px 14px',
                boxShadow: 'var(--shadow-md)',
                overflow: 'hidden',
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                paddingTop: isBottle ? '40px' : '26px',
            }"
        >
            <div
                v-if="isBottle"
                :style="{ position: 'absolute', top: '-16px', left: '50%', transform: 'translateX(-50%)', width: '34px', height: '26px', background: p.bg, borderRadius: '6px 6px 0 0' }"
            />
            <div
                v-if="!isBottle"
                style="position:absolute;top:0;left:0;right:0;height:12px;background:rgba(0,0,0,0.12);"
            />
            <img :src="img(p.logo)" :alt="label" :style="{ width: isBottle ? '74%' : '70%', marginTop: isBottle ? '8px' : '6px' }" />
            <span
                v-if="highlight"
                :style="{
                    marginTop: '12px', fontFamily: 'var(--font-sans)', fontWeight: 800, fontSize: '11px',
                    letterSpacing: '.1em', textTransform: 'uppercase', color: p.fg,
                    border: '1.5px solid ' + p.fg, borderRadius: '999px', padding: '4px 10px', opacity: 0.92,
                }"
            >{{ highlight }}</span>
            <img :src="img(p.espiga)" alt="" style="position:absolute;bottom:12px;right:14px;width:30px;opacity:0.9;" />
            <div
                style="position:absolute;bottom:0;left:0;right:0;padding:8px 0;background:rgba(255,255,255,0.92);text-align:center;font-family:var(--font-display);font-weight:700;font-size:15px;color:var(--text-strong);"
            >{{ label }}</div>
        </div>
        <div style="margin-top:10px;font-family:var(--font-sans);font-size:13px;color:var(--text-muted);">{{ weight }}</div>
    </div>
</template>
