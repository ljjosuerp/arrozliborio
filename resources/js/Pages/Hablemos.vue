<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { MapPin, Clock, Mail, Store, ShoppingBag } from 'lucide-vue-next';
import { shoppingUrl } from '@/shopping';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';
import Input from '@/Components/ds/Input.vue';
import Toast from '@/Components/ds/Toast.vue';
import MapaPuntos from '@/Components/ds/MapaPuntos.vue';

const props = defineProps({
    sede: { type: Object, default: null },
    companias: { type: Array, default: () => [] },
    puntosVenta: { type: Array, default: () => [] },
});

const form = useForm({ nombre: '', email: '', telefono: '', asunto: '', mensaje: '' });
const enviado = ref(false);

const enviar = () => {
    form.post('/hablemos', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            enviado.value = true;
            setTimeout(() => (enviado.value = false), 4000);
        },
    });
};

const mapQuery = encodeURIComponent(
    props.sede ? `${props.sede.nombre}, ${props.sede.provincia?.nombre ?? ''}, Costa Rica` : 'Cañas, Guanacaste, Costa Rica'
);
</script>

<template>
    <Head title="Hablemos" />

    <PublicLayout>
        <!-- Hero -->
        <section style="position:relative;background:var(--grad-blue);overflow:hidden;">
            <img src="/img/liborio/espiga-mark-white.png" alt="" style="position:absolute;right:-10px;bottom:-20px;width:200px;opacity:0.1;" />
            <div style="position:relative;max-width:1180px;margin:0 auto;padding:60px 28px;">
                <Eyebrow color="var(--brand-accent)" :with-mark="true">Estamos para ayudarte</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-5xl)/1.0 var(--font-display);color:#fff;margin:12px 0 12px;">Hablemos</h1>
                <p style="font:var(--body-lg);color:rgba(255,255,255,0.9);max-width:520px;margin:0;">
                    ¿Tenés una consulta, sugerencia o querés saber dónde comprar Liborio? Escribinos.
                </p>
            </div>
            <Cintillo :height="8" />
        </section>

        <!-- Formulario + Sede -->
        <section style="max-width:1180px;margin:0 auto;padding:56px 28px;">
            <div class="hab-grid" style="display:grid;grid-template-columns:1.1fr 0.9fr;gap:44px;align-items:start;">
                <!-- Formulario -->
                <div>
                    <h2 style="font:var(--fw-bold) var(--text-3xl)/1.1 var(--font-display);color:var(--text-strong);margin:0 0 20px;">Escribinos</h2>
                    <form @submit.prevent="enviar" style="display:flex;flex-direction:column;gap:16px;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;" class="hab-row">
                            <Input v-model="form.nombre" label="Nombre" :error="form.errors.nombre" />
                            <Input v-model="form.email" type="email" label="Correo" :error="form.errors.email" />
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;" class="hab-row">
                            <Input v-model="form.telefono" label="Teléfono (opcional)" :error="form.errors.telefono" />
                            <Input v-model="form.asunto" label="Asunto (opcional)" :error="form.errors.asunto" />
                        </div>
                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <label style="font-family:var(--font-sans);font-weight:var(--fw-bold);font-size:var(--text-sm);color:var(--text-strong);">Mensaje</label>
                            <textarea v-model="form.mensaje" rows="5" class="lb-textarea" :data-error="form.errors.mensaje ? 'true' : 'false'"></textarea>
                            <span v-if="form.errors.mensaje" style="font-family:var(--font-sans);font-size:var(--text-xs);color:var(--danger);">{{ form.errors.mensaje }}</span>
                        </div>
                        <div>
                            <Button variant="primary" size="lg" type="submit" :disabled="form.processing">
                                {{ form.processing ? 'Enviando…' : 'Enviar mensaje' }}
                            </Button>
                        </div>
                    </form>
                </div>

                <!-- Sede -->
                <div>
                    <h2 style="font:var(--fw-bold) var(--text-3xl)/1.1 var(--font-display);color:var(--text-strong);margin:0 0 20px;">Nuestra sede</h2>
                    <div style="border-radius:var(--radius-card);overflow:hidden;border:1px solid var(--border-subtle);box-shadow:var(--shadow-sm);">
                        <iframe
                            :src="`https://www.google.com/maps?q=${mapQuery}&output=embed`"
                            width="100%" height="220" style="border:0;display:block;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            title="Ubicación de la sede"></iframe>
                        <div style="padding:20px;background:var(--surface-card);">
                            <div style="display:flex;gap:10px;margin-bottom:10px;">
                                <span style="color:var(--brand-primary);flex:0 0 auto;"><MapPin :size="18" /></span>
                                <span style="font:var(--body-md);color:var(--text-body);">
                                    {{ sede?.nombre || 'Sede principal — Cañas' }}<template v-if="sede?.provincia">, {{ sede.provincia.nombre }}</template>
                                </span>
                            </div>
                            <div v-if="sede?.periodo_dias || sede?.periodo_horas" style="display:flex;gap:10px;margin-bottom:10px;">
                                <span style="color:var(--brand-primary);flex:0 0 auto;"><Clock :size="18" /></span>
                                <span style="font:var(--body-md);color:var(--text-body);">{{ sede?.periodo_dias }} · {{ sede?.periodo_horas }}</span>
                            </div>
                            <div v-if="sede?.email" style="display:flex;gap:10px;">
                                <span style="color:var(--brand-primary);flex:0 0 auto;"><Mail :size="18" /></span>
                                <a :href="`mailto:${sede.email}`" style="font:var(--body-md);color:var(--text-link);">{{ sede.email }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dónde comprar -->
        <section style="background:var(--surface-sunken);border-top:1px solid var(--border-subtle);">
            <div style="max-width:1180px;margin:0 auto;padding:56px 28px;">
                <div style="text-align:center;margin-bottom:32px;">
                    <Eyebrow :with-mark="true">Encontrá Liborio cerca tuyo</Eyebrow>
                    <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 8px;">Dónde comprar</h2>
                    <p style="font:var(--body-md);color:var(--text-body);max-width:560px;margin:0 auto;">
                        Nuestros productos están disponibles en las principales cadenas de supermercados del país.
                    </p>
                </div>
                <div class="comprar-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
                    <div v-for="c in companias" :key="c.id"
                        style="display:flex;align-items:center;gap:12px;background:var(--surface-card);border:1px solid var(--border-subtle);border-radius:var(--radius-md);padding:16px 18px;box-shadow:var(--shadow-xs);">
                        <span style="width:38px;height:38px;flex:0 0 auto;border-radius:50%;background:var(--red-50);color:var(--brand-primary);display:flex;align-items:center;justify-content:center;"><Store :size="18" /></span>
                        <span style="font-family:var(--font-sans);font-weight:700;font-size:15px;color:var(--text-strong);">{{ c.nombre }}</span>
                    </div>
                </div>
                <div style="text-align:center;margin-top:32px;">
                    <p style="font:var(--body-sm);color:var(--text-muted);margin:0 0 14px;">¿Preferís comprar en línea?</p>
                    <Button :href="shoppingUrl('Arroz Liborio')" target="_blank" variant="primary">
                        <template #iconLeft><ShoppingBag :size="18" /></template>
                        Comprar en línea
                    </Button>
                </div>
            </div>
        </section>

        <!-- Mapa de puntos de venta -->
        <section v-if="puntosVenta.length" style="max-width:1180px;margin:0 auto;padding:56px 28px 80px;">
            <div style="text-align:center;margin-bottom:28px;">
                <Eyebrow :with-mark="true">Mapa de tiendas</Eyebrow>
                <h2 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:var(--text-strong);margin:10px 0 8px;">Encontrá tu súper</h2>
                <p style="font:var(--body-md);color:var(--text-body);max-width:560px;margin:0 auto;">
                    Filtrá por producto y tocá un pin para ver la tienda y cómo llegar.
                </p>
            </div>
            <MapaPuntos :puntos="puntosVenta" />
        </section>

        <!-- Toast éxito -->
        <div v-if="enviado" style="position:fixed;right:24px;bottom:24px;z-index:1200;">
            <Toast tone="success" title="¡Mensaje enviado!" @close="enviado = false">Gracias por escribirnos. Te responderemos pronto.</Toast>
        </div>
    </PublicLayout>
</template>

<style scoped>
.lb-textarea {
    font-family: var(--font-sans);
    font-size: var(--text-md);
    color: var(--text-strong);
    background: var(--surface-card);
    border: 1.5px solid var(--border-default);
    border-radius: var(--radius-md);
    padding: 11px 14px;
    outline: none;
    resize: vertical;
    transition: border-color var(--dur-fast) var(--ease-standard), box-shadow var(--dur-fast) var(--ease-standard);
}
.lb-textarea[data-error='true'] { border-color: var(--danger); }
.lb-textarea:focus { border-color: var(--brand-accent); box-shadow: var(--focus-ring); }

@media (max-width: 860px) {
    .hab-grid { grid-template-columns: 1fr !important; }
    .comprar-grid { grid-template-columns: repeat(2, 1fr) !important; }
}
@media (max-width: 480px) {
    .hab-row { grid-template-columns: 1fr !important; }
    .comprar-grid { grid-template-columns: 1fr !important; }
}
</style>
