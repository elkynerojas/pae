<?php

namespace App\Console\Commands;

use App\Models\Beneficiario;
use Illuminate\Console\Command;

class ProbarGuardadoHuella extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'huella:probar-guardado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba si se puede guardar una huella en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Probando guardado de huella en la base de datos...');

        try {
            // Crear una huella de prueba
            $huellaPrueba = base64_encode('HUELLA_DE_PRUEBA_' . time());

            $this->line("📝 Huella de prueba: " . substr($huellaPrueba, 0, 50) . '...');

            // Buscar un beneficiario existente o crear uno de prueba
            $beneficiario = Beneficiario::first();

            if (!$beneficiario) {
                $this->warn('⚠️ No hay beneficiarios en la base de datos. Creando uno de prueba...');

                $beneficiario = Beneficiario::create([
                    'codigo' => 'TEST001',
                    'nombres' => 'Beneficiario',
                    'apellidos' => 'Prueba',
                    'fecha_nacimiento' => '2000-01-01',
                    'genero' => 'masculino',
                    'grado' => 'primero',
                    'grupo' => 1,
                    'observaciones' => 'Beneficiario creado para pruebas',
                    'activo' => true,
                    'huella_template' => $huellaPrueba,
                ]);

                $this->info('✅ Beneficiario de prueba creado con huella');
            } else {
                $this->line("👤 Usando beneficiario existente: {$beneficiario->nombreCompleto}");

                // Actualizar la huella
                $beneficiario->huella_template = $huellaPrueba;
                $beneficiario->save();

                $this->info('✅ Huella actualizada en beneficiario existente');
            }

            // Verificar que se guardó correctamente
            $beneficiario->refresh();

            if ($beneficiario->huella_template === $huellaPrueba) {
                $this->info('✅ Huella guardada correctamente en la base de datos');
                $this->line("📊 ID del beneficiario: {$beneficiario->id}");
                $this->line("📊 Huella guardada: " . substr($beneficiario->huella_template, 0, 50) . '...');
            } else {
                $this->error('❌ La huella no se guardó correctamente');
                $this->line("🔍 Esperado: " . substr($huellaPrueba, 0, 50) . '...');
                $this->line("🔍 Obtenido: " . substr($beneficiario->huella_template ?? 'NULL', 0, 50) . '...');
            }

            // Verificar estructura de la tabla
            $this->newLine();
            $this->info('🔍 Verificando estructura de la tabla...');

            $columns = \Schema::getColumnListing('beneficiarios');
            if (in_array('huella_template', $columns)) {
                $this->info('✅ Campo huella_template existe en la tabla');
            } else {
                $this->error('❌ Campo huella_template NO existe en la tabla');
                $this->line('📋 Columnas disponibles: ' . implode(', ', $columns));
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error al probar el guardado: ' . $e->getMessage());
            $this->line('🔍 Detalles: ' . $e->getTraceAsString());
            return 1;
        }
    }
}
