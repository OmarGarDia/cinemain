@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Editar usuario ') }}
    </h2>
@endsection
@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-md">
            <div class="bg-white overflow-hidden">
                <div class="px-6 text-gray-900 dark:text-gray-800">
                    <div class="overflow-x-auto">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            <div class="p-4 md:p-5">
                                <div class="pb-4">
                                    <label for="name_edit"
                                        class="block mb-2 text-sm font-medium dark:text-gray-700">Nombre</label>
                                    <input type="text" name="name_edit" id="name_edit"
                                        value="{{ old('name', $user->name) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
                                </div>
                                <div class="pb-4">
                                    <label for="email_edit"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-700">Email</label>
                                    <input type="email" name="email_edit" id="email_edit"
                                        value="{{ old('email', $user->email) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
                                    @error('email_edit')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="pb-4">
                                    <label for="password_edit"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-700">Nueva
                                        Contraseña</label>
                                    <input type="password" name="password_edit" id="password_edit"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
                                </div>
                                <div class="pb-4">
                                    <label for="password_edit_confirmation"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-700">Confirmar
                                        Contraseña</label>
                                    <input type="password" name="password_edit_confirmation" id="password_edit_confirmation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
                                </div>
                                @if (Session::has('error'))
                                    <div class="pb-4">
                                        <div class="text-red-500 text-sm">{{ Session::get('error') }}</div>
                                    </div>
                                @endif
                                <div class="pb-4">
                                    <button data-modal-hide="progress-modal" type="submit"
                                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-green-700 dark:bg-green-800 dark:text-white dark:border-green-600 dark:hover:text-white dark:hover:bg-green-700">Editar</button>
                                    <a data-modal-hide="progress-modal" href="{{ route('usuarios') }}"
                                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-red-700 dark:bg-red-800 dark:text-white dark:border-red-600 dark:hover:text-white dark:hover:bg-red-700">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
