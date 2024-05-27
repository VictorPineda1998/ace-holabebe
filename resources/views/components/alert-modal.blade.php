<div class="fixed z-10 inset-0 overflow-y-auto" id="alertModal" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity ease-out duration-300" id="modalBackdrop" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg px-6 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all ease-out duration-300 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" id="modalContent">
            <div class="flex justify-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-full" id="modalIcon">
                    <!-- Icon goes here -->
                </div>
            </div>
            <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Mensaje</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500" id="modalMessage"></p>
                </div>
            </div>
            <div class="mt-5 sm:mt-6">
                <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 sm:text-sm" onclick="closeModal()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(message, type) {
            var modal = document.getElementById('alertModal');
            var modalContent = document.getElementById('modalContent');
            var modalBackdrop = document.getElementById('modalBackdrop');
            document.getElementById('modalMessage').textContent = message;

            if (type === "success") {
                document.getElementById('modalIcon').classList.add('bg-green-100');
                document.getElementById('modalIcon').innerHTML = `<svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>`;
            } else if (type === "error") {
                document.getElementById('modalIcon').classList.add('bg-red-100');
                document.getElementById('modalIcon').innerHTML = `<svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>`;
            }

            modal.style.display = 'block';
            modalBackdrop.classList.remove('opacity-0');
            modalBackdrop.classList.add('opacity-50');
            modalContent.classList.remove('translate-y-4', 'opacity-0');
            modalContent.classList.add('translate-y-0', 'opacity-100');
        }

        function closeModal() {
            var modal = document.getElementById('alertModal');
            var modalContent = document.getElementById('modalContent');
            var modalBackdrop = document.getElementById('modalBackdrop');

            modalBackdrop.classList.remove('opacity-50');
            modalBackdrop.classList.add('opacity-0');
            modalContent.classList.remove('translate-y-0', 'opacity-100');
            modalContent.classList.add('translate-y-4', 'opacity-0');

            setTimeout(function() {
                modal.style.display = 'none';
            }, 300);
        }
</script>

@if(session('success'))
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            openModal("{{ session('success') }}", "success");
        });
    </script>
@endif

@if(session('error'))
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            openModal("{{ session('error') }}", "error");
        });
    </script>
@endif