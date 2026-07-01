<script setup>
import { ref, nextTick, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { MessageCircle, X, Send, Sparkles } from 'lucide-vue-next';

const abierto = ref(false);
const cargando = ref(false);
const entrada = ref('');
const scroller = ref(null);

const bienvenida = '¡Hola! 👋 Soy el asistente de Liborio. Puedo recomendarte recetas, contarte de nuestros productos o decirte dónde comprar. ¿En qué te ayudo?';
const mensajes = ref([{ role: 'assistant', text: bienvenida }]);
const sugerencias = ['¿Qué cocino con Fit?', '¿Dónde compro?', 'Ver recetas'];

const mostrarSugerencias = computed(() => mensajes.value.length <= 1 && !cargando.value);

const abrir = () => {
    abierto.value = true;
    nextTick(bajar);
};

const bajar = () => {
    nextTick(() => {
        if (scroller.value) scroller.value.scrollTop = scroller.value.scrollHeight;
    });
};

const xsrf = () => {
    const m = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
    return m ? decodeURIComponent(m[1]) : '';
};

const enviar = async (texto) => {
    const contenido = (texto ?? entrada.value).trim();
    if (!contenido || cargando.value) return;

    mensajes.value.push({ role: 'user', text: contenido });
    entrada.value = '';
    cargando.value = true;
    bajar();

    try {
        const payload = mensajes.value.map((m) => ({ role: m.role, content: m.text }));
        const res = await fetch('/asistente', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-XSRF-TOKEN': xsrf(),
            },
            credentials: 'same-origin',
            body: JSON.stringify({ messages: payload }),
        });
        const data = await res.json();
        mensajes.value.push({ role: 'assistant', text: data.reply || 'Disculpá, no pude responder.' });
    } catch (e) {
        mensajes.value.push({ role: 'assistant', text: 'Uy, tuve un problema de conexión. Probá de nuevo en un momento. 🙏' });
    } finally {
        cargando.value = false;
        bajar();
    }
};

// Convierte texto plano en HTML seguro, con rutas del sitio como enlaces.
const esc = (s) => s.replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
const formatear = (texto) => esc(texto)
    .replace(/(^|[\s(])(\/[a-z0-9\-/]+)/gi, '$1<a href="$2" class="asis-link" data-ruta="$2">$2</a>')
    .replace(/\n/g, '<br>');

// Navegación interna con Inertia al hacer clic en un enlace del bot.
const onClickMensajes = (e) => {
    const a = e.target.closest('a[data-ruta]');
    if (a) {
        e.preventDefault();
        abierto.value = false;
        router.visit(a.getAttribute('data-ruta'));
    }
};
</script>

<template>
    <div class="asis-root">
        <!-- Botón flotante -->
        <button v-if="!abierto" class="asis-fab" aria-label="Abrir asistente" @click="abrir">
            <MessageCircle :size="26" />
            <span class="asis-fab-dot"></span>
        </button>

        <!-- Panel de chat -->
        <transition name="asis-pop">
            <div v-if="abierto" class="asis-panel">
                <header class="asis-head">
                    <div class="asis-head-id">
                        <span class="asis-avatar"><Sparkles :size="16" /></span>
                        <div>
                            <div class="asis-title">Asistente Liborio</div>
                            <div class="asis-sub">Siempre listo para ayudarte</div>
                        </div>
                    </div>
                    <button class="asis-close" aria-label="Cerrar" @click="abierto = false"><X :size="20" /></button>
                </header>

                <div ref="scroller" class="asis-body" @click="onClickMensajes">
                    <div v-for="(m, i) in mensajes" :key="i" class="asis-row" :class="`asis-row--${m.role}`">
                        <div class="asis-bubble" :class="`asis-bubble--${m.role}`" v-html="formatear(m.text)"></div>
                    </div>
                    <div v-if="cargando" class="asis-row asis-row--assistant">
                        <div class="asis-bubble asis-bubble--assistant asis-typing">
                            <span></span><span></span><span></span>
                        </div>
                    </div>

                    <div v-if="mostrarSugerencias" class="asis-sugs">
                        <button v-for="s in sugerencias" :key="s" class="asis-sug" @click="enviar(s)">{{ s }}</button>
                    </div>
                </div>

                <form class="asis-input" @submit.prevent="enviar()">
                    <input v-model="entrada" type="text" placeholder="Escribí tu mensaje…" :disabled="cargando" maxlength="1500" />
                    <button type="submit" :disabled="cargando || !entrada.trim()" aria-label="Enviar"><Send :size="18" /></button>
                </form>
                <div class="asis-foot">Asistente con IA · puede equivocarse. Para temas de salud, consultá a un profesional.</div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.asis-root { position: fixed; right: 22px; bottom: 22px; z-index: 1300; }

.asis-fab {
    width: 60px; height: 60px; border-radius: 50%; border: none; cursor: pointer;
    background: var(--grad-red); color: #fff; box-shadow: var(--shadow-lg);
    display: flex; align-items: center; justify-content: center; position: relative;
    transition: transform var(--dur-base) var(--ease-out);
    animation: asisIn var(--dur-slow) var(--ease-out) both;
}
.asis-fab:hover { transform: translateY(-3px) scale(1.04); }
.asis-fab-dot { position: absolute; top: 12px; right: 13px; width: 10px; height: 10px; border-radius: 50%; background: var(--yellow-500); border: 2px solid #fff; }
@keyframes asisIn { from { opacity: 0; transform: scale(0.6); } to { opacity: 1; transform: none; } }

.asis-panel {
    width: 370px; max-width: calc(100vw - 32px); height: 560px; max-height: calc(100vh - 110px);
    background: var(--surface-card); border: 1px solid var(--border-subtle);
    border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); overflow: hidden;
    display: flex; flex-direction: column;
}

.asis-head { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: var(--grad-red); color: #fff; }
.asis-head-id { display: flex; align-items: center; gap: 10px; }
.asis-avatar { width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; }
.asis-title { font-family: var(--font-display); font-weight: 700; font-size: 16px; line-height: 1.1; }
.asis-sub { font-size: 12px; opacity: 0.85; }
.asis-close { background: none; border: none; color: #fff; cursor: pointer; opacity: 0.85; display: flex; }
.asis-close:hover { opacity: 1; }

.asis-body { flex: 1; overflow-y: auto; padding: 16px; background: var(--surface-page); display: flex; flex-direction: column; gap: 10px; }
.asis-row { display: flex; }
.asis-row--user { justify-content: flex-end; }
.asis-bubble { max-width: 82%; padding: 10px 13px; border-radius: 16px; font-family: var(--font-sans); font-size: 14.5px; line-height: 1.45; }
.asis-bubble--assistant { background: var(--surface-card); border: 1px solid var(--border-subtle); color: var(--text-body); border-top-left-radius: 4px; }
.asis-bubble--user { background: var(--brand-primary); color: #fff; border-top-right-radius: 4px; }
.asis-bubble :deep(.asis-link) { color: inherit; font-weight: 700; text-decoration: underline; }
.asis-bubble--assistant :deep(.asis-link) { color: var(--brand-primary); }

.asis-typing { display: flex; gap: 4px; align-items: center; }
.asis-typing span { width: 7px; height: 7px; border-radius: 50%; background: var(--text-faint); animation: asisBlink 1.2s infinite; }
.asis-typing span:nth-child(2) { animation-delay: 0.2s; }
.asis-typing span:nth-child(3) { animation-delay: 0.4s; }
@keyframes asisBlink { 0%, 60%, 100% { opacity: 0.25; } 30% { opacity: 1; } }

.asis-sugs { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 4px; }
.asis-sug { border: 1px solid var(--border-default); background: var(--surface-card); color: var(--brand-primary); border-radius: 999px; padding: 7px 13px; font-family: var(--font-sans); font-weight: 600; font-size: 13px; cursor: pointer; transition: background var(--dur-fast) var(--ease-standard); }
.asis-sug:hover { background: var(--red-50); }

.asis-input { display: flex; gap: 8px; padding: 12px; border-top: 1px solid var(--border-subtle); background: var(--surface-card); }
.asis-input input { flex: 1; border: 1.5px solid var(--border-default); border-radius: 999px; padding: 10px 15px; font-family: var(--font-sans); font-size: 14px; outline: none; }
.asis-input input:focus { border-color: var(--brand-accent); box-shadow: var(--focus-ring); }
.asis-input button { width: 42px; height: 42px; border-radius: 50%; border: none; background: var(--brand-primary); color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.asis-input button:disabled { opacity: 0.5; cursor: default; }
.asis-foot { padding: 0 14px 10px; font-size: 10.5px; color: var(--text-faint); text-align: center; background: var(--surface-card); }

.asis-pop-enter-active, .asis-pop-leave-active { transition: opacity var(--dur-base) var(--ease-out), transform var(--dur-base) var(--ease-out); transform-origin: bottom right; }
.asis-pop-enter-from, .asis-pop-leave-to { opacity: 0; transform: scale(0.9) translateY(10px); }

@media (max-width: 480px) {
    .asis-root { right: 14px; bottom: 14px; }
    .asis-panel { height: calc(100vh - 90px); }
}
</style>
