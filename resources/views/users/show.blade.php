<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Usuario') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Información básica -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Personal</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Nombre Completo</label>
                                    <p class="text-sm text-gray-900">{{ $user->nombre_completo }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Email</label>
                                    <p class="text-sm text-gray-900">{{ $user->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Teléfono</label>
                                    <p class="text-sm text-gray-900">{{ $user->telefono ?? 'No especificado' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Cargo</label>
                                    <p class="text-sm text-gray-900">{{ $user->cargo ?? 'No especificado' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información del Sistema</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Rol</label>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $user->rol === 'admin' ? 'bg-red-100 text-red-800' : 
                                           ($user->rol === 'gestor' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($user->rol) }}
                                    </span>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Estado</label>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $user->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Fecha de Registro</label>
                                    <p class="text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Última Actualización</label>
                                    <p class="text-sm text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Último Acceso</label>
                                    <p class="text-sm text-gray-900">{{ $user->ultimo_acceso ? $user->ultimo_acceso->format('d/m/Y H:i') : 'Nunca' }}</p>
                                </div>
                                
                                @if($user->email_verified_at)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600">Email Verificado</label>
                                        <p class="text-sm text-gray-900">{{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Permisos por rol -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Permisos del Rol</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($user->isAdmin())
                                <div class="bg-red-50 p-3 rounded border-l-4 border-red-400">
                                    <h4 class="font-semibold text-red-800">Administrador</h4>
                                    <ul class="text-sm text-red-700 mt-2 space-y-1">
                                        <li>• Gestión completa de usuarios</li>
                                        <li>• Acceso a todos los módulos</li>
                                        <li>• Configuración del sistema</li>
                                        <li>• Reportes avanzados</li>
                                    </ul>
                                </div>
                            @elseif($user->isGestor())
                                <div class="bg-yellow-50 p-3 rounded border-l-4 border-yellow-400">
                                    <h4 class="font-semibold text-yellow-800">Gestor</h4>
                                    <ul class="text-sm text-yellow-700 mt-2 space-y-1">
                                        <li>• Gestión de beneficiarios</li>
                                        <li>• Gestión de productos</li>
                                        <li>• Gestión de entregas</li>
                                        <li>• Reportes básicos</li>
                                    </ul>
                                </div>
                            @else
                                <div class="bg-green-50 p-3 rounded border-l-4 border-green-400">
                                    <h4 class="font-semibold text-green-800">Operador</h4>
                                    <ul class="text-sm text-green-700 mt-2 space-y-1">
                                        <li>• Consulta de beneficiarios</li>
                                        <li>• Registro de entregas</li>
                                        <li>• Consulta de inventario</li>
                                        <li>• Reportes básicos</li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex justify-end space-x-3">
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ $user->activo ? 'Desactivar Usuario' : 'Activar Usuario' }}
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" 
                                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Eliminar Usuario
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
