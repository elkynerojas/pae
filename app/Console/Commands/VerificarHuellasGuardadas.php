<?php

namespace App\Console\Commands;

use App\Models\Beneficiario;
use Illuminate\Console\Command;

class VerificarHuellasGuardadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'huella:verificar-guardadas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica qué beneficiarios tienen huellas guardadas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando beneficiarios con huellas guardadas...');

        try {
            // Contar beneficiarios con huella
            $conHuella = Beneficiario::whereNotNull('huella_template')
                ->where('huella_template', '!=', '')
                ->count();

            $sinHuella = Beneficiario::whereNull('huella_template')
                ->orWhere('huella_template', '')
                ->count();

            $total = Beneficiario::count();

            $this->line("📊 Total de beneficiarios: {$total}");
            $this->line("✅ Con huella guardada: {$conHuella}");
            $this->line("❌ Sin huella guardada: {$sinHuella}");

            if ($conHuella > 0) {
                $this->newLine();
                $this->info('👥 Beneficiarios con huella guardada:');

                $beneficiarios = Beneficiario::whereNotNull('huella_template')
                    ->where('huella_template', '!=', '')
                    ->get(['id', 'codigo', 'nombres', 'apellidos', 'huella_template']);

                foreach ($beneficiarios as $beneficiario) {
                    $huellaPreview = substr($beneficiario->huella_template, 0, 30) . '...';
                    $this->line("  - ID: {$beneficiario->id} | {$beneficiario->codigo} | {$beneficiario->nombres} {$beneficiario->apellidos}");
                    $this->line("    Huella: {$huellaPreview}");
                }
            }

            // Verificar estructura de la tabla
            $this->newLine();
            $this->info('🔍 Verificando estructura de la tabla...');

            $columns = \Schema::getColumnListing('beneficiarios');
            if (in_array('huella_template', $columns)) {
                $this->info('✅ Campo huella_template existe en la tabla');

                // Verificar tipo de columna
                $columnType = \Schema::getColumnType('beneficiarios', 'huella_template');
                $this->line("📋 Tipo de columna: {$columnType}");
            } else {
                $this->error('❌ Campo huella_template NO existe en la tabla');
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error al verificar huellas: ' . $e->getMessage());
            return 1;
        }
    }
}
