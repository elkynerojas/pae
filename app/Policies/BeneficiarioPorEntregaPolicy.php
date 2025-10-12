<?php

namespace App\Policies;

use App\Models\BeneficiarioPorEntrega;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BeneficiarioPorEntregaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BeneficiarioPorEntrega $beneficiarioPorEntrega): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Para crear beneficiarios, necesitamos verificar el contexto
        // Esto se manejará en el RelationManager con validaciones específicas
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BeneficiarioPorEntrega $beneficiarioPorEntrega): bool
    {
        // No se puede editar beneficiarios de una entrega cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BeneficiarioPorEntrega $beneficiarioPorEntrega): bool
    {
        // No se puede eliminar beneficiarios de una entrega cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BeneficiarioPorEntrega $beneficiarioPorEntrega): bool
    {
        // No se puede restaurar beneficiarios de una entrega cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BeneficiarioPorEntrega $beneficiarioPorEntrega): bool
    {
        // No se puede eliminar permanentemente beneficiarios de una entrega cerrada
        if ($beneficiarioPorEntrega->entrega && $beneficiarioPorEntrega->entrega->estaCerrada()) {
            return false;
        }

        return true;
    }
}