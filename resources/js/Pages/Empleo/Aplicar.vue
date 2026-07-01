<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Paperclip } from 'lucide-vue-next';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Button from '@/Components/ds/Button.vue';
import Eyebrow from '@/Components/ds/Eyebrow.vue';
import Cintillo from '@/Components/ds/Cintillo.vue';
import Input from '@/Components/ds/Input.vue';

const props = defineProps({
    puesto: { type: Object, required: true },
});

const form = useForm({
    nombre: '',
    email: '',
    telefono: '',
    mensaje: '',
    cv: null,
});

const onFile = (e) => {
    form.cv = e.target.files[0] || null;
};

const enviar = () => {
    form.post(`/trabaje-con-nosotros/puesto/${props.puesto.id}/aplicar`, {
        forceFormData: true,
    });
};
</script>

<template>
    <Head :title="`Aplicar — ${puesto.titulo}`" />

    <PublicLayout>
        <section style="position:relative;background:var(--grad-red);overflow:hidden;">
            <div style="position:relative;max-width:720px;margin:0 auto;padding:48px 28px;">
                <Eyebrow color="rgba(255,255,255,0.9)" :with-mark="true">Aplicación</Eyebrow>
                <h1 style="font:var(--fw-bold) var(--text-4xl)/1.05 var(--font-display);color:#fff;margin:12px 0 6px;">{{ puesto.titulo }}</h1>
                <p style="font:var(--body-md);color:rgba(255,255,255,0.9);margin:0;">{{ puesto.ubicacion }}</p>
            </div>
            <Cintillo :height="8" />
        </section>

        <section style="max-width:720px;margin:0 auto;padding:48px 28px 80px;">
            <form @submit.prevent="enviar" style="display:flex;flex-direction:column;gap:18px;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;" class="apl-row">
                    <Input v-model="form.nombre" label="Nombre completo" :error="form.errors.nombre" />
                    <Input v-model="form.email" type="email" label="Correo" :error="form.errors.email" />
                </div>
                <Input v-model="form.telefono" label="Teléfono" :error="form.errors.telefono" />

                <div style="display:flex;flex-direction:column;gap:6px;">
                    <label style="font-family:var(--font-sans);font-weight:var(--fw-bold);font-size:var(--text-sm);color:var(--text-strong);">Mensaje (opcional)</label>
                    <textarea v-model="form.mensaje" rows="4" class="lb-textarea" placeholder="Contanos por qué te interesa el puesto…"></textarea>
                    <span v-if="form.errors.mensaje" style="font-family:var(--font-sans);font-size:var(--text-xs);color:var(--danger);">{{ form.errors.mensaje }}</span>
                </div>

                <!-- CV -->
                <div style="display:flex;flex-direction:column;gap:6px;">
                    <label style="font-family:var(--font-sans);font-weight:var(--fw-bold);font-size:var(--text-sm);color:var(--text-strong);">Currículum (PDF o Word)</label>
                    <label class="cv-drop">
                        <Paperclip :size="18" />
                        <span style="font-family:var(--font-sans);font-size:14px;">
                            {{ form.cv ? form.cv.name : 'Seleccioná tu archivo (máx. 4 MB)' }}
                        </span>
                        <input type="file" accept=".pdf,.doc,.docx" style="display:none;" @change="onFile" />
                    </label>
                    <span v-if="form.errors.cv" style="font-family:var(--font-sans);font-size:var(--text-xs);color:var(--danger);">{{ form.errors.cv }}</span>
                    <span v-if="form.progress" style="font-family:var(--font-sans);font-size:var(--text-xs);color:var(--text-muted);">Subiendo… {{ form.progress.percentage }}%</span>
                </div>

                <div style="display:flex;gap:14px;align-items:center;">
                    <Button variant="primary" size="lg" type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Enviando…' : 'Enviar aplicación' }}
                    </Button>
                    <Link :href="`/trabaje-con-nosotros/puesto/${puesto.id}`" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);font-family:var(--font-sans);font-weight:600;">
                        <ArrowLeft :size="16" /> Cancelar
                    </Link>
                </div>
            </form>
        </section>
    </PublicLayout>
</template>

<style scoped>
.lb-textarea {
    font-family: var(--font-sans); font-size: var(--text-md); color: var(--text-strong);
    background: var(--surface-card); border: 1.5px solid var(--border-default);
    border-radius: var(--radius-md); padding: 11px 14px; outline: none; resize: vertical;
    transition: border-color var(--dur-fast) var(--ease-standard), box-shadow var(--dur-fast) var(--ease-standard);
}
.lb-textarea:focus { border-color: var(--brand-accent); box-shadow: var(--focus-ring); }

.cv-drop {
    display: flex; align-items: center; gap: 10px; cursor: pointer;
    border: 1.5px dashed var(--border-default); border-radius: var(--radius-md);
    padding: 16px 18px; color: var(--text-body); background: var(--surface-sunken);
    transition: border-color var(--dur-fast) var(--ease-standard), background var(--dur-fast) var(--ease-standard);
}
.cv-drop:hover { border-color: var(--brand-accent); background: var(--celeste-50); }

@media (max-width: 560px) {
    .apl-row { grid-template-columns: 1fr !important; }
}
</style>
