<script setup>
import { computed } from 'vue';
import { ShoppingBag } from 'lucide-vue-next';
import { shoppingUrl } from '@/shopping';
import Button from './Button.vue';

// Muestra enlaces directos de compra por tienda; si no hay, cae a Google Shopping.
const props = defineProps({
    enlaces: { type: Array, default: () => [] },
    nombre: { type: String, required: true },
});

const tieneEnlaces = computed(() => Array.isArray(props.enlaces) && props.enlaces.length > 0);
</script>

<template>
    <div style="display:flex;flex-direction:column;gap:8px;width:100%;">
        <template v-if="tieneEnlaces">
            <Button
                v-for="(e, i) in enlaces"
                :key="i"
                :href="e.url"
                target="_blank"
                :variant="i === 0 ? 'primary' : 'outline'"
                size="sm"
                full
            >
                <template #iconLeft><ShoppingBag :size="15" /></template>
                Comprar en {{ e.tienda }}
            </Button>
            <a :href="shoppingUrl(nombre)" target="_blank" rel="noopener noreferrer"
                style="text-align:center;font-family:var(--font-sans);font-size:12px;color:var(--text-muted);text-decoration:none;">
                Ver más tiendas →
            </a>
        </template>

        <Button v-else :href="shoppingUrl(nombre)" target="_blank" variant="outline" size="sm" full>
            <template #iconLeft><ShoppingBag :size="16" /></template>
            Dónde comprar
        </Button>
    </div>
</template>
