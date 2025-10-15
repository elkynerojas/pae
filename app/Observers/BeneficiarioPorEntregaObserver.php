<?php

namespace App\Observers;

use App\Models\BeneficiarioPorEntrega;
use App\Models\Inventario;

class BeneficiarioPorEntregaObserver
{
    /**
     * Handle the BeneficiarioPorEntrega "created" event.
     */
    public function created(BeneficiarioPorEntrega $beneficiarioPorEntrega): void
    {
        \Log::info('BeneficiarioPorEntregaObserver: created event', [
            'beneficiario_por_entrega_id' => $beneficiarioPorEntrega->id,
            'entrega_id' => $beneficiarioPorEntrega->entrega_id,
            'beneficiario_id' => $beneficiarioPorEntrega->beneficiario_id
        ]);

        // Solo procesar si la entrega no está cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            \Log::info('BeneficiarioPorEntregaObserver: Entrega cerrada, saltando actualización de inventario');
            return;
        }

        try {
            $this->actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'restar');
            \Log::info('BeneficiarioPorEntregaObserver: Inventario actualizado exitosamente');
        } catch (\Exception $e) {
            \Log::error('BeneficiarioPorEntregaObserver: Error al actualizar inventario', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle the BeneficiarioPorEntrega "updated" event.
     */
    public function updated(BeneficiarioPorEntrega $beneficiarioPorEntrega): void
    {
        // Solo procesar si la entrega no está cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            return;
        }

        // Si cambió la cantidad de raciones, necesitamos ajustar el inventario
        if ($beneficiarioPorEntrega->wasChanged('cantidad_raciones')) {
            $cantidadAnterior = $beneficiarioPorEntrega->getOriginal('cantidad_raciones');
            $cantidadNueva = $beneficiarioPorEntrega->cantidad_raciones;
            $diferencia = $cantidadNueva - $cantidadAnterior;
            
            if ($diferencia > 0) {
                $this->actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'restar', $diferencia);
            } elseif ($diferencia < 0) {
                $this->actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'sumar', abs($diferencia));
            }
        }
    }

    /**
     * Handle the BeneficiarioPorEntrega "deleted" event.
     */
    public function deleted(BeneficiarioPorEntrega $beneficiarioPorEntrega): void
    {
        // Solo procesar si la entrega no está cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            return;
        }

        $this->actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'sumar');
    }

    /**
     * Handle the BeneficiarioPorEntrega "restored" event.
     */
    public function restored(BeneficiarioPorEntrega $beneficiarioPorEntrega): void
    {
        // Solo procesar si la entrega no está cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            return;
        }

        $this->actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'restar');
    }

    /**
     * Handle the BeneficiarioPorEntrega "force deleted" event.
     */
    public function forceDeleted(BeneficiarioPorEntrega $beneficiarioPorEntrega): void
    {
        // Solo procesar si la entrega no está cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            return;
        }

        $this->actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'sumar');
    }

    /**
     * Actualizar inventario basado en un beneficiario específico
     */
    private function actualizarInventarioPorBeneficiario(
        BeneficiarioPorEntrega $beneficiarioPorEntrega, 
        string $operacion, 
        int $cantidadRaciones = null
    ): void {
        $entrega = $beneficiarioPorEntrega->entrega;
        if (!$entrega) {
            return;
        }

        $racion = $entrega->racion;
        if (!$racion) {
            return;
        }

        // Usar la cantidad específica o la cantidad del beneficiario
        $cantidadARestar = $cantidadRaciones ?? $beneficiarioPorEntrega->cantidad_raciones;
        
        if ($cantidadARestar <= 0) {
            return;
        }

        // Obtener todos los productos de la ración
        $productosPorRacion = $racion->productosPorRacion;

        // Para cada producto en la ración, actualizar el inventario
        foreach ($productosPorRacion as $productoPorRacion) {
            $cantidadTotal = $productoPorRacion->cantidad * $cantidadARestar;
            
            Inventario::actualizarStock(
                $productoPorRacion->producto_id,
                $cantidadTotal,
                $operacion
            );
        }
    }
}