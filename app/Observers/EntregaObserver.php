<?php

namespace App\Observers;

use App\Models\Entrega;
use App\Models\Inventario;
use App\Models\BeneficiarioPorEntrega;
use App\Services\LogSistemaService;

class EntregaObserver
{
    /**
     * Handle the Entrega "created" event.
     */
    public function created(Entrega $entrega): void
    {
        $this->actualizarInventario($entrega, 'restar');
        
        // Registrar en log
        LogSistemaService::crear(
            'entregas',
            $entrega->id,
            $entrega->toArray(),
            "Nueva entrega creada para la ración '{$entrega->racion->nombre}'"
        );
    }

    /**
     * Handle the Entrega "updated" event.
     */
    public function updated(Entrega $entrega): void
    {
        // Solo procesar cambios si la entrega no está cerrada
        if ($entrega->estaCerrada()) {
            return;
        }

        // Si cambió la ración, necesitamos revertir el inventario anterior
        // y aplicar el nuevo
        if ($entrega->wasChanged('racion_id')) {
            $this->revertirInventarioAnterior($entrega);
            $this->actualizarInventario($entrega, 'restar');
        }
        
        // Registrar en log
        LogSistemaService::actualizar(
            'entregas',
            $entrega->id,
            $entrega->getOriginal(),
            $entrega->toArray(),
            "Entrega actualizada para la ración '{$entrega->racion->nombre}'"
        );
    }

    /**
     * Handle the Entrega "deleted" event.
     */
    public function deleted(Entrega $entrega): void
    {
        $this->actualizarInventario($entrega, 'sumar');
        
        // Registrar en log
        LogSistemaService::eliminar(
            'entregas',
            $entrega->id,
            $entrega->toArray(),
            "Entrega eliminada para la ración '{$entrega->racion->nombre}'"
        );
    }

    /**
     * Handle the Entrega "restored" event.
     */
    public function restored(Entrega $entrega): void
    {
        $this->actualizarInventario($entrega, 'restar');
    }

    /**
     * Handle the Entrega "force deleted" event.
     */
    public function forceDeleted(Entrega $entrega): void
    {
        $this->actualizarInventario($entrega, 'sumar');
    }

    /**
     * Actualizar inventario basado en la entrega
     */
    private function actualizarInventario(Entrega $entrega, string $operacion): void
    {
        // Obtener la ración asociada
        $racion = $entrega->racion;
        if (!$racion) {
            return;
        }

        // Obtener todos los productos de la ración
        $productosPorRacion = $racion->productosPorRacion;
        
        // Obtener el número total de beneficiarios que recibieron esta entrega
        $totalBeneficiarios = $entrega->beneficiariosPorEntrega()->sum('cantidad_raciones');
        
        if ($totalBeneficiarios <= 0) {
            return;
        }

        // Para cada producto en la ración, actualizar el inventario
        foreach ($productosPorRacion as $productoPorRacion) {
            $cantidadTotal = $productoPorRacion->cantidad * $totalBeneficiarios;
            
            Inventario::actualizarStock(
                $productoPorRacion->producto_id,
                $cantidadTotal,
                $operacion
            );
        }
    }

    /**
     * Revertir inventario de la ración anterior
     */
    private function revertirInventarioAnterior(Entrega $entrega): void
    {
        $racionAnteriorId = $entrega->getOriginal('racion_id');
        
        if (!$racionAnteriorId) {
            return;
        }

        $racionAnterior = \App\Models\Racion::find($racionAnteriorId);
        if (!$racionAnterior) {
            return;
        }

        // Obtener el número total de beneficiarios
        $totalBeneficiarios = $entrega->beneficiariosPorEntrega()->sum('cantidad_raciones');
        
        if ($totalBeneficiarios <= 0) {
            return;
        }

        // Revertir el inventario de la ración anterior
        $productosPorRacion = $racionAnterior->productosPorRacion;
        
        foreach ($productosPorRacion as $productoPorRacion) {
            $cantidadTotal = $productoPorRacion->cantidad * $totalBeneficiarios;
            
            Inventario::actualizarStock(
                $productoPorRacion->producto_id,
                $cantidadTotal,
                'sumar'
            );
        }
    }
}