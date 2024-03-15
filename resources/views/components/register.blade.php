<x-authentication-card>
    <x-slot name="logo">
        {{-- <x-authentication-card-logo /> --}}
    </x-slot>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}" id="formRegistrar">
        @csrf
        @if (DB::table('users')->count() === 0)
            <div class="mt-4">
                <select id="tipo_usuario" name="tipo_usuario"
                    class="mt-1 w-full rounded-md bg-white py-2 pl-3 pr-10 text-gray-500 focus:ring-4 focus:ring-indigo-600"
                    required style="display: none;" >
                    <option value="Administrador" selected>Administrador</option>
                </select>
            </div>
        @else
            <div class="mt-4">
                <x-label for="tipo_usuario" value="{{ __('Tipo de usuario') }}" />
                <select id="tipo_usuario" name="tipo_usuario"
                    class="mt-1 w-full rounded-md bg-white py-2 pl-3 pr-10 text-gray-500 focus:ring-4 focus:ring-indigo-600"
                    required>
                    <option disabled selected class="text-gray-400 italic">Selecciona un tipo de usuario</option>
                    <option value="Medico general">Médico General</option>
                    <option value="Medico especialista">Médico Especialista</option>
                    <option value="Enfermeria consultorios">Enfermeria Consultorios</option>
                    <option value="Enfermeria hospitalizacion">Enfermeria Hospitalizacion</option>
                    <option value="Contador">Contador</option>
                    <option value="Administrador">Administrador</option>
                </select>
            </div>
        @endif


        <div class="mt-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
        </div>

        <div class="mt-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
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
            
            @if (DB::table('users')->count() === 0)
                <x-boton-cancelar id="cancelar" class="ms-4">
                    <a href="{{ route('login') }}">{{ __('Cancelar') }}</a>
                </x-boton-cancelar>
            @else
                <x-boton-cancelar id="cancelar" class="ms-4">
                    {{ __('Cancelar') }}
                </x-boton-cancelar>
            @endif

            <x-button class="ms-4">
                {{ __('Register') }}
            </x-button>
        </div>
    </form>
</x-authentication-card>
