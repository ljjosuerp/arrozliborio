<?php

namespace App\Http\Controllers;

use Anthropic\Client;
use App\Models\Producto;
use App\Models\PuntoVenta;
use App\Models\Receta;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AsistenteController extends Controller
{
    // Recibe la conversación y responde con el Asistente Liborio (Claude Haiku).
    public function chat(Request $request)
    {
        $data = $request->validate([
            'messages' => ['required', 'array', 'min:1', 'max:24'],
            'messages.*.role' => ['required', 'in:user,assistant'],
            'messages.*.content' => ['required', 'string', 'max:1500'],
        ]);

        // Solo mandamos los últimos turnos para controlar costo/latencia.
        $mensajes = array_slice($data['messages'], -14);

        // Sin API key configurada: respuesta amable sin romper el sitio.
        if (! config('services.anthropic.key')) {
            return response()->json([
                'reply' => 'Por ahora el asistente no está disponible. Escribinos por WhatsApp o desde la página de Contacto y con gusto te ayudamos. 🙂',
            ]);
        }

        try {
            $client = new Client(apiKey: config('services.anthropic.key'));

            $message = $client->messages->create(
                model: config('services.anthropic.model'),
                maxTokens: 700,
                system: $this->systemPrompt(),
                messages: $mensajes,
            );

            $texto = '';
            foreach ($message->content as $block) {
                if ($block->type === 'text') {
                    $texto .= $block->text;
                }
            }

            return response()->json([
                'reply' => trim($texto) ?: 'Disculpá, no entendí bien. ¿Me lo repetís de otra forma?',
            ]);
        } catch (\Throwable $e) {
            \Log::error('Asistente Liborio falló: '.$e->getMessage());

            return response()->json([
                'reply' => 'Uy, tuve un problema para responder. Probá de nuevo en un momento, o escribinos por WhatsApp / Contacto y te ayudamos directo. 🙏',
            ], 200);
        }
    }

    // Prompt del sistema: personalidad + datos reales + reglas. Se cachea 10 min.
    private function systemPrompt(): string
    {
        $contexto = Cache::remember('asistente_contexto', now()->addMinutes(10), function () {
            $productos = Producto::where('estado', true)->orderBy('orden')
                ->get(['nombre', 'presentacion', 'tag'])
                ->map(fn ($p) => "- {$p->nombre} ({$p->presentacion}".($p->tag ? ", {$p->tag}" : '').')')
                ->implode("\n");

            $recetas = Receta::where('estado', true)->orderBy('nombre')
                ->get(['id', 'nombre'])
                ->map(fn ($r) => "- {$r->nombre} → /recetas/{$r->id}")
                ->implode("\n");

            $regiones = PuntoVenta::where('estado', true)
                ->whereNotNull('region')
                ->distinct()->orderBy('region')->pluck('region')->implode(', ');
            $totalTiendas = PuntoVenta::where('estado', true)->count();

            $sede = Ubicacion::orderBy('orden')->first();
            $sedeTxt = $sede ? "{$sede->nombre} — {$sede->direccion}" : 'Costa Rica';

            return "PRODUCTOS:\n{$productos}\n\nRECETAS (enlace del sitio):\n{$recetas}\n\n"
                ."DÓNDE COMPRAR: se vende en ~{$totalTiendas} puntos de venta en: {$regiones}. "
                ."El mapa filtrable por producto está en /hablemos.\n"
                ."SEDE / PRODUCCIÓN: {$sedeTxt}.\n";
        });

        return <<<PROMPT
Sos el "Asistente Liborio", el conserje virtual del sitio web de Arrocera Liborio (Costa Rica).
Marca 100% costarricense de arroz, frijoles y aceite; apoya al productor nacional.

TU ESTILO:
- Hablás en español de Costa Rica, con "vos", cálido, cercano y breve (2-4 frases).
- Sos útil y concreto: guiás a la persona a lo que busca en el sitio.

QUÉ PODÉS HACER:
- Recomendar recetas y dar el enlace del sitio (ej: "Mirá esta receta: /recetas/3").
- Explicar los productos y sus diferencias (ej. Liborio Fit es semi integral).
- Indicar dónde comprar (mandá a /hablemos, que tiene el mapa por producto).
- Orientar sobre empleo (/trabaje-con-nosotros) y contacto (/hablemos).

REGLAS IMPORTANTES:
- Hablá SOLO de Arrocera Liborio, sus productos, recetas, tiendas, empleo y marca. Si te preguntan algo ajeno (política, tareas, otros temas), decilo con amabilidad y reencaminá a Liborio.
- NO das consejos médicos, nutricionales personalizados ni de salud. Podés mencionar características del producto (ej. "bajo en sodio"), pero para temas de salud sugerí consultar a un profesional.
- No inventes datos. Si no sabés un precio, disponibilidad exacta o algo puntual, decí que no lo tenés y sugerí escribir por Contacto/WhatsApp.
- Nunca inventes recetas ni tiendas que no estén en la lista de abajo.
- Cuando des un enlace, usá solo rutas del sitio (ej. /recetas/2, /productos, /hablemos, /liborio-fit, /trabaje-con-nosotros).

DATOS REALES DEL SITIO (única fuente de verdad):
{$contexto}
PROMPT;
    }
}
