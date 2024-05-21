<x-app-layout>
    <x-div-fondo>
        <x-header>

        </x-header>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    {{-- <x-welcome /> --}}
                </div>
            </div>
        </div>
    </x-div-fondo>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error'))
                var error = @json(session('error'));
                alert(error);
            @endif
        });
    </script>
</x-app-layout>
