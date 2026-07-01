// v-reveal: hace aparecer un elemento con fade + slide cuando entra en pantalla.
// Uso:  <div v-reveal>…</div>   o con retraso:  <div v-reveal="150">…</div>  (ms)
// Respeta prefers-reduced-motion (el CSS deja el elemento visible sin animar).

const supportsIO = typeof window !== 'undefined' && 'IntersectionObserver' in window;

const observer = supportsIO
    ? new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -6% 0px' }
    )
    : null;

export default {
    mounted(el, binding) {
        el.classList.add('lb-reveal');

        const delay = Number(binding.value) || 0;
        if (delay) el.style.transitionDelay = `${delay}ms`;

        // Sin IntersectionObserver (o SSR): mostrar de una vez.
        if (!observer) {
            el.classList.add('is-visible');
            return;
        }
        observer.observe(el);
    },
    unmounted(el) {
        if (observer) observer.unobserve(el);
    },
};
