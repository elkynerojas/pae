<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckColorContrast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:check-contrast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica los contrastes de color del tema personalizado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando contrastes de color del tema personalizado...');
        $this->newLine();

        // Definir las combinaciones de colores a verificar (versión mejorada)
        $colorCombinations = [
            // Headers y elementos principales con colores mejorados
            ['background' => '#E91E63', 'text' => '#FFFFFF', 'context' => 'Header Principal (Tab activo)'],
            ['background' => '#FF5722', 'text' => '#FFFFFF', 'context' => 'Header Secundario'],
            ['background' => '#FF9800', 'text' => '#000000', 'context' => 'Header Terciario'],
            
            // Botones principales
            ['background' => '#E91E63', 'text' => '#FFFFFF', 'context' => 'Botón Crear Beneficiario'],
            ['background' => '#FF5722', 'text' => '#FFFFFF', 'context' => 'Botón Secundario'],
            ['background' => '#FF9800', 'text' => '#000000', 'context' => 'Botón Terciario'],
            
            // Enlaces sobre fondos claros
            ['background' => '#FFFFFF', 'text' => '#E91E63', 'context' => 'Enlaces Ver/Editar'],
            ['background' => '#FCE4EC', 'text' => '#4A0E2A', 'context' => 'Texto sobre fondo primario claro'],
            ['background' => '#FBE9E7', 'text' => '#6B1F0A', 'context' => 'Texto sobre fondo secundario claro'],
            ['background' => '#FFF3E0', 'text' => '#8B2C00', 'context' => 'Texto sobre fondo terciario claro'],
            
            // Texto sobre fondos oscuros
            ['background' => '#880E4F', 'text' => '#FFFFFF', 'context' => 'Texto sobre fondo primario oscuro'],
            ['background' => '#BF360C', 'text' => '#FFFFFF', 'context' => 'Texto sobre fondo secundario oscuro'],
            ['background' => '#E65100', 'text' => '#FFFFFF', 'context' => 'Texto sobre fondo terciario oscuro'],
            
            // Estados y badges
            ['background' => '#D81B60', 'text' => '#FFFFFF', 'context' => 'Badge Primario'],
            ['background' => '#F4511E', 'text' => '#FFFFFF', 'context' => 'Badge Secundario'],
            ['background' => '#FB8C00', 'text' => '#000000', 'context' => 'Badge Terciario'],
        ];

        $this->table(
            ['Contexto', 'Fondo', 'Texto', 'Ratio', 'Nivel WCAG', 'Estado'],
            $this->checkContrasts($colorCombinations)
        );

        $this->newLine();
        $this->info('📋 Recomendaciones:');
        $this->line('• Ratio 4.5:1 o superior = Cumple WCAG AA (texto normal)');
        $this->line('• Ratio 7:1 o superior = Cumple WCAG AAA (texto normal)');
        $this->line('• Ratio 3:1 o superior = Cumple WCAG AA (texto grande)');
        $this->newLine();

        return Command::SUCCESS;
    }

    private function checkContrasts($combinations)
    {
        $results = [];

        foreach ($combinations as $combo) {
            $ratio = $this->calculateContrastRatio($combo['background'], $combo['text']);
            $level = $this->getWCAGLevel($ratio);
            $status = $this->getStatus($ratio);

            $results[] = [
                $combo['context'],
                $combo['background'],
                $combo['text'],
                number_format($ratio, 2),
                $level,
                $status
            ];
        }

        return $results;
    }

    private function calculateContrastRatio($hex1, $hex2)
    {
        $rgb1 = $this->hexToRgb($hex1);
        $rgb2 = $this->hexToRgb($hex2);

        $luminance1 = $this->getLuminance($rgb1);
        $luminance2 = $this->getLuminance($rgb2);

        $lighter = max($luminance1, $luminance2);
        $darker = min($luminance1, $luminance2);

        return ($lighter + 0.05) / ($darker + 0.05);
    }

    private function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    private function getLuminance($rgb)
    {
        $r = $rgb['r'] / 255;
        $g = $rgb['g'] / 255;
        $b = $rgb['b'] / 255;

        $r = $r <= 0.03928 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = $g <= 0.03928 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = $b <= 0.03928 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);

        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    private function getWCAGLevel($ratio)
    {
        if ($ratio >= 7) return 'AAA';
        if ($ratio >= 4.5) return 'AA';
        if ($ratio >= 3) return 'AA Large';
        return 'Fail';
    }

    private function getStatus($ratio)
    {
        if ($ratio >= 7) return '✅ Excelente';
        if ($ratio >= 4.5) return '✅ Bueno';
        if ($ratio >= 3) return '⚠️ Aceptable';
        return '❌ Insuficiente';
    }
}
