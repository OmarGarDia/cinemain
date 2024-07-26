@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Usuarios') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 contenedor">
        <div class="mx-auto">
            @if (Session::has('success'))
                <div class="bg-green-200 text-green-800 px-6 py-4 mb-4 rounded-md">
                    {{ Session::get('success') }}
                </div>
            @endif
            <!-- Flex container para alinear el aside a la izquierda -->
            <div class="flex">
                <!-- Main Content -->
                <div class="flex-1">
                    <div class="bg-white overflow-hidden w-full">
                        <div class="px-6 text-gray-900 dark:text-gray-800 w-full">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full border-collapse border border-gray-200 text-sm"
                                    name="tabla_usuarios" id="tabla_usuarios">
                                    <thead>
                                        <tr class=" bg-gray-200 text-center">
                                            <th class="px-4 py-2 text-center">ID</th>
                                            <th class="px-4 py-2 text-center">NOMBRE</th>
                                            <th class="px-4 py-2 text-center">EMAIL</th>
                                            <th class="px-4 py-2 text-center">PASSWORD</th>
                                            <th class="px-4 py-2 text-center">CREADO</th>
                                            <th class="px-4 py-2 text-center">MODIFICADO</th>
                                            <th class="px-4 py-2 text-center">OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="border-y-2">
                                                <td class="">{{ $user->id }}
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td class="border px-4 py-2">
                                                    <span id="password-{{ $user->id }}" class="password">••••••••</span>
                                                    <button onclick="togglePassword({{ $user->id }})" class="ml-2"
                                                        data-password="{{ $user->password }}">
                                                        <i id="toggle-icon-{{ $user->id }}" class="mdi mdi-eye"></i>
                                                    </button>
                                                </td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>{{ $user->updated_at }}</td>
                                                <td>
                                                    <div class="flex items-center space-x-2">
                                                        <a href="{{ route('perfil.info', ['userId' => $user->id]) }}"
                                                            class="bg-blue-400 text-white font-bold py-0 px-1 rounded flex items-center">
                                                            <i class="mdi mdi-eye text-lg"></i>
                                                        </a>
                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                            class="bg-orange-400 text-white font-bold py-0 px-1 rounded flex items-center">
                                                            <i class="mdi mdi-pencil-outline text-lg"></i>
                                                        </a>
                                                        <form action="{{ route('users.delete', $user->id) }}"
                                                            method="POST" id="delete-form-{{ $user->id }}"
                                                            style="display: inline;" class="flex items-center">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="botonEliminar"
                                                                class="bg-red-500 text-white font-bold py-0 px-1 rounded flex items-center">
                                                                <i class="mdi mdi-trash-can-outline text-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
