<x-app-layout>
    <x-header>

    </x-header>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-welcome /> --}}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        @if(session('error'))
            var error = @json(session('error'));
            alert(error);
        @endif
    });
    </script>
</x-app-layout>
