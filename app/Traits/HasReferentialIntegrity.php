<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasReferentialIntegrity
{
    /**
     * Verificar si el modelo tiene dependencias antes de eliminar
     */
    public function hasDependencies(): bool
    {
        // Protección especial para usuario con ID 1
        if (get_class($this) === \App\Models\User::class && $this->id === 1) {
            return true;
        }
        
        $relationships = $this->getRelationships();
        
        foreach ($relationships as $relationName => $relation) {
            if ($relation->exists()) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Obtener las relaciones que pueden causar dependencias
     */
    public function getRelationships(): array
    {
        $relationships = [];
        
        // Obtener todas las relaciones del modelo
        $modelRelations = $this->getRelations();
        
        // Verificar relaciones específicas según el modelo
        switch (get_class($this)) {
            case \App\Models\Producto::class:
                $relationships = [
                    'inventario' => $this->hasOne(\App\Models\Inventario::class),
                    'productosPorRacion' => $this->hasMany(\App\Models\ProductoPorRacion::class),
                    'productosPorRecepcion' => $this->hasMany(\App\Models\ProductoPorRecepcion::class),
                ];
                break;
                
            case \App\Models\Racion::class:
                $relationships = [
                    'entregas' => $this->hasMany(\App\Models\Entrega::class),
                    'productosPorRacion' => $this->hasMany(\App\Models\ProductoPorRacion::class),
                ];
                break;
                
            case \App\Models\Beneficiario::class:
                $relationships = [
                    'beneficiariosPorEntrega' => $this->hasMany(\App\Models\BeneficiarioPorEntrega::class),
                ];
                break;
                
            case \App\Models\TipoProducto::class:
                $relationships = [
                    'productos' => $this->hasMany(\App\Models\Producto::class),
                ];
                break;
                
            case \App\Models\PresentacionProducto::class:
                $relationships = [
                    'productos' => $this->hasMany(\App\Models\Producto::class),
                ];
                break;
                
            case \App\Models\Entrega::class:
                $relationships = [
                    'beneficiariosPorEntrega' => $this->hasMany(\App\Models\BeneficiarioPorEntrega::class),
                ];
                break;
                
            case \App\Models\Recepcion::class:
                $relationships = [
                    'productosPorRecepcion' => $this->hasMany(\App\Models\ProductoPorRecepcion::class),
                ];
                break;
        }
        
        return $relationships;
    }

    /**
     * Obtener mensaje de error personalizado para dependencias
     */
    public function getDependencyErrorMessage(): string
    {
        $modelName = class_basename($this);
        
        switch (get_class($this)) {
            case \App\Models\Producto::class:
                return "No se puede eliminar el producto '{$this->nombre}' porque tiene registros relacionados en inventario, raciones o recepciones.";
                
            case \App\Models\Racion::class:
                return "No se puede eliminar la ración '{$this->nombre}' porque tiene entregas o productos asociados.";
                
            case \App\Models\Beneficiario::class:
                return "No se puede eliminar el beneficiario '{$this->nombre_completo}' porque tiene entregas registradas.";
                
            case \App\Models\TipoProducto::class:
                return "No se puede eliminar el tipo de producto '{$this->nombre}' porque tiene productos asociados.";
                
            case \App\Models\PresentacionProducto::class:
                return "No se puede eliminar la presentación '{$this->nombre}' porque tiene productos asociados.";
                
            case \App\Models\Entrega::class:
                return "No se puede eliminar la entrega del {$this->fecha->format('d/m/Y')} porque tiene beneficiarios asociados.";
                
            case \App\Models\Recepcion::class:
                return "No se puede eliminar la recepción del {$this->fecha->format('d/m/Y')} porque tiene productos asociados.";
                
            case \App\Models\User::class:
                if ($this->id === 1) {
                    return "No se puede eliminar el usuario administrador principal (ID: 1) por seguridad del sistema.";
                }
                return "No se puede eliminar este usuario porque tiene registros asociados.";
                
            default:
                return "No se puede eliminar este registro porque otros registros dependen de él.";
        }
    }

    /**
     * Obtener lista de dependencias para mostrar en el mensaje
     */
    public function getDependencyDetails(): array
    {
        $details = [];
        $relationships = $this->getRelationships();
        
        foreach ($relationships as $relationName => $relation) {
            $count = $relation->count();
            if ($count > 0) {
                $details[] = [
                    'relation' => $relationName,
                    'count' => $count,
                    'message' => $this->getRelationMessage($relationName, $count)
                ];
            }
        }
        
        return $details;
    }

    /**
     * Obtener mensaje específico para cada relación
     */
    private function getRelationMessage(string $relationName, int $count): string
    {
        $messages = [
            'inventario' => "{$count} registro(s) en inventario",
            'productosPorRacion' => "{$count} producto(s) en raciones",
            'productosPorRecepcion' => "{$count} producto(s) en recepciones",
            'entregas' => "{$count} entrega(s) registrada(s)",
            'beneficiariosPorEntrega' => "{$count} beneficiario(s) en entregas",
            'productos' => "{$count} producto(s) asociado(s)",
            'beneficiariosPorEntrega' => "{$count} beneficiario(s) asociado(s)",
            'productosPorRecepcion' => "{$count} producto(s) asociado(s)",
        ];
        
        return $messages[$relationName] ?? "{$count} registro(s) relacionado(s)";
    }
}
