<script setup>
import { ref, onMounted, onBeforeUnmount, watch, computed } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    puntos: { type: Array, default: () => [] },
});

const cats = ['Todos', 'Arroz', 'Frijoles', 'Aceite'];
const sel = ref('Todos');
const mapEl = ref(null);
let map = null;
let layer = null;

const filtrados = computed(() =>
    sel.value === 'Todos' ? props.puntos : props.puntos.filter((p) => (p.productos || []).includes(sel.value))
);

const exactas = computed(() => props.puntos.filter((p) => p.precision === 'exacta').length);

const pinIcon = (precision) => {
    const color = precision === 'exacta' ? '#B2292E' : '#D7A461';
    return L.divIcon({
        className: 'lb-pin',
        html: `<svg width="26" height="36" viewBox="0 0 28 38" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 0C6.3 0 0 6.3 0 14c0 9.5 14 24 14 24s14-14.5 14-24C28 6.3 21.7 0 14 0z" fill="${color}"/>
            <circle cx="14" cy="14" r="5" fill="#fff"/></svg>`,
        iconSize: [26, 36],
        iconAnchor: [13, 36],
        popupAnchor: [0, -32],
    });
};

const esc = (s) => (s || '').replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));

const popupHtml = (p) => {
    const maps = `https://www.google.com/maps/search/?api=1&query=${p.lat},${p.lng}`;
    const waze = `https://waze.com/ul?ll=${p.lat},${p.lng}&navigate=yes`;
    const linkS = 'flex:1;text-align:center;text-decoration:none;font-weight:700;font-size:12px;padding:7px 8px;border-radius:8px;';
    return `<div style="font-family:'Nunito Sans',sans-serif;min-width:210px;">
        <div style="font-weight:800;color:#0F206C;font-size:15px;line-height:1.25;margin-bottom:3px;">${esc(p.nombre)}</div>
        <div style="font-size:12px;color:#6E665B;">${esc(p.region)}</div>
        ${p.direccion ? `<div style="font-size:12px;color:#6E665B;margin-top:3px;">${esc(p.direccion)}</div>` : ''}
        <div style="font-size:12px;color:#3A352F;margin-top:7px;"><b>Vende:</b> ${(p.productos || []).join(', ')}</div>
        ${p.precision === 'aproximada' ? '<div style="font-size:11px;color:#A9762F;margin-top:5px;">📍 Ubicación aproximada (zona)</div>' : ''}
        <div style="display:flex;gap:8px;margin-top:10px;">
            <a href="${maps}" target="_blank" rel="noopener" style="${linkS}background:#0F206C;color:#fff;">Google Maps</a>
            <a href="${waze}" target="_blank" rel="noopener" style="${linkS}background:#87D1E6;color:#0F206C;">Waze</a>
        </div>
    </div>`;
};

const render = () => {
    if (!map) return;
    if (layer) layer.remove();
    layer = L.layerGroup().addTo(map);
    const pts = [];
    for (const p of filtrados.value) {
        if (p.lat == null || p.lng == null) continue;
        L.marker([p.lat, p.lng], { icon: pinIcon(p.precision) }).bindPopup(popupHtml(p)).addTo(layer);
        pts.push([p.lat, p.lng]);
    }
    if (pts.length) map.fitBounds(pts, { padding: [40, 40], maxZoom: 11 });
};

onMounted(() => {
    map = L.map(mapEl.value, { scrollWheelZoom: false }).setView([9.93, -84.08], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap',
    }).addTo(map);
    render();
});
onBeforeUnmount(() => {
    if (map) { map.remove(); map = null; }
});
watch(sel, render);
</script>

<template>
    <div>
        <!-- Filtros -->
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px;">
            <button v-for="c in cats" :key="c" @click="sel = c"
                :style="{
                    fontFamily: 'var(--font-sans)', fontWeight: 800, fontSize: '13px',
                    padding: '8px 16px', borderRadius: 'var(--radius-pill)', cursor: 'pointer',
                    border: '1.5px solid ' + (sel === c ? 'var(--brand-primary)' : 'var(--border-default)'),
                    background: sel === c ? 'var(--brand-primary)' : 'transparent',
                    color: sel === c ? '#fff' : 'var(--text-body)',
                }">
                {{ c }}
            </button>
        </div>

        <!-- Mapa -->
        <div ref="mapEl" style="position:relative;z-index:0;height:480px;border-radius:var(--radius-card);overflow:hidden;border:1px solid var(--border-subtle);box-shadow:var(--shadow-sm);"></div>

        <!-- Leyenda -->
        <div style="display:flex;flex-wrap:wrap;gap:18px;margin-top:12px;font-family:var(--font-sans);font-size:12px;color:var(--text-muted);">
            <span style="display:inline-flex;align-items:center;gap:6px;"><span style="width:11px;height:11px;border-radius:50%;background:#B2292E;display:inline-block;"></span> Ubicación exacta ({{ exactas }})</span>
            <span style="display:inline-flex;align-items:center;gap:6px;"><span style="width:11px;height:11px;border-radius:50%;background:#D7A461;display:inline-block;"></span> Aproximada por zona ({{ puntos.length - exactas }})</span>
            <span>· {{ puntos.length }} puntos de venta</span>
        </div>
    </div>
</template>
