<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class VerificarServicioHuella extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'huella:verificar-servicio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica la conexión con el servicio de huella digital SecuGen';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando servicio de huella digital...');

        $url = config('huella_digital.secugen.url');
        $verificarSsl = config('huella_digital.secugen.verificar_ssl');

        $this->line("📍 URL del servicio: {$url}");
        $this->line("🔒 Verificar SSL: " . ($verificarSsl ? 'Sí' : 'No'));

        try {
            // Intentar conectar al servicio
            $response = Http::timeout(10)
                ->withOptions([
                    'verify' => $verificarSsl,
                ])
                ->get($url);

            if ($response->successful()) {
                $this->info('✅ Servicio de huella digital está funcionando correctamente');
                $this->line("📊 Estado HTTP: {$response->status()}");
                return 0;
            } else {
                $this->error("❌ Servicio respondió con error: {$response->status()}");
                return 1;
            }

        } catch (\Exception $e) {
            $this->error("❌ No se pudo conectar con el servicio de huella digital");
            $this->line("🔍 Error: " . $e->getMessage());

            $this->newLine();
            $this->warn('💡 Posibles soluciones:');
            $this->line('1. Verificar que el SDK de SecuGen esté instalado');
            $this->line('2. Verificar que el servicio esté ejecutándose en el puerto 8443');
            $this->line('3. Verificar que el lector biométrico esté conectado');
            $this->line('4. Verificar los certificados SSL');

            return 1;
        }
    }
}

