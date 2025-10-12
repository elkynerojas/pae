<?php

namespace App\Policies;

use App\Models\Entrega;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EntregaPolicy
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
    public function view(User $user, Entrega $entrega): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Entrega $entrega): bool
    {
        // No se puede editar una entrega cerrada
        if ($entrega->estaCerrada()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Entrega $entrega): bool
    {
        // No se puede eliminar una entrega cerrada
        if ($entrega->estaCerrada()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Entrega $entrega): bool
    {
        // No se puede restaurar una entrega cerrada
        if ($entrega->estaCerrada()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Entrega $entrega): bool
    {
        // No se puede eliminar permanentemente una entrega cerrada
        if ($entrega->estaCerrada()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can close the delivery.
     */
    public function close(User $user, Entrega $entrega): bool
    {
        // Solo se puede cerrar una entrega abierta
        return $entrega->estaAbierta();
    }

    /**
     * Determine whether the user can reopen the delivery.
     */
    public function reopen(User $user, Entrega $entrega): bool
    {
        // Solo se puede reabrir una entrega cerrada
        // En el futuro se puede agregar lógica de permisos específicos
        return $entrega->estaCerrada();
    }
}