<x-authentication-card>
    <x-slot name="logo">
        {{-- <x-authentication-card-logo /> --}}
    </x-slot>

    <x-validation-errors class="mb-4"/>

    <h1>Editar usuario</h1>
    <form id="form-editar" method="POST" action="{{ route('usuario.update', ['id' => $user->id]) }}">
        @csrf
        @method('PUT')
        <div class="mt-4">
            <x-label for="tipo_usuario" value="{{ __('Tipo de usuario') }}" />
            <select id="tipo_usuario" name="tipo_usuario" class="block mt-1 w-full" required>
                <option value="enfermero">Enfermero</option>
                <option value="administrador">Administrador</option>
                <option value="medico">Médico</option>
                <option value="contador">Contador</option>
            </select>
        </div>

        <div class="mt-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $user->name) }}" required
                autofocus autocomplete="name" />
        </div>

        <div class="mt-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('name', $user->email) }}" required
                autocomplete="username" />
        </div>

        <div class="mt-4">
            <x-label for="password" value="{{ __('Password') }}" />
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                required autocomplete="new-password" />
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-label for="terms">
                    <div class="flex items-center">
                        <x-checkbox name="terms" id="terms" required />

                        <div class="ms-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' =>
                                    '<a target="_blank" href="' .
                                    route('terms.show') .
                                    '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                    __('Terms of Service') .
                                    '</a>',
                                'privacy_policy' =>
                                    '<a target="_blank" href="' .
                                    route('policy.show') .
                                    '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                    __('Privacy Policy') .
                                    '</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-label>
            </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a> --}}
            {{-- <x-button class="ms-4">
                        <a href="{{ route('dashboard') }}">
                            {{ __('Cancelar') }}
                        </a>
                    </x-button> --}}
                    <x-boton-mas id="cancelar" class="ms-4">
                       <a href="{{ route('gestion-usuarios') }}"> {{ __('Cancelar') }} </a>
                    </x-boton-mas>
            <x-button class="ms-4">
                {{ __('Guardar cambios') }}
            </x-button>
        </div>
    </form>
</x-authentication-card>
