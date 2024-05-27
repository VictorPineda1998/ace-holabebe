<div class="fixed z-10 inset-0 overflow-y-auto" id="confirmModal" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity ease-out duration-300" id="confirmModalBackdrop" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg px-6 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all ease-out duration-300 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
            id="confirmModalContent">
            <div class="flex justify-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="confirmModalTitle">Confirmación</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500" id="confirmModalMessage"></p>
                    <p class="text-sm font-medium text-gray-900 mt-1" id="confirmModalnombre"></p>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 flex justify-between">
                <button type="button"
                    class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 sm:text-sm"
                    onclick="confirmAction()">
                    Confirmar
                </button>
                <button type="button"
                    class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-500 text-base font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:text-sm"
                    onclick="closeConfirmModal()">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function openConfirmModal(onConfirm, confirmMessage, nombre) {

        var confirmModal = document.getElementById('confirmModal');
        var confirmModalContent = document.getElementById('confirmModalContent');
        var confirmModalBackdrop = document.getElementById('confirmModalBackdrop');
        document.getElementById('confirmModalMessage').textContent = confirmMessage;
        document.getElementById('confirmModalnombre').textContent = nombre;
        // Asigna la función de confirmación al botón Confirmar
        window.confirmAction = function() {
            onConfirm();
            closeConfirmModal();
        };

        confirmModal.style.display = 'block';
        confirmModalBackdrop.classList.remove('opacity-0');
        confirmModalBackdrop.classList.add('opacity-50');
        confirmModalContent.classList.remove('translate-y-4', 'opacity-0');
        confirmModalContent.classList.add('translate-y-0', 'opacity-100');
    }

    function closeConfirmModal() {
        var confirmModal = document.getElementById('confirmModal');
        var confirmModalContent = document.getElementById('confirmModalContent');
        var confirmModalBackdrop = document.getElementById('confirmModalBackdrop');

        confirmModalBackdrop.classList.remove('opacity-50');
        confirmModalBackdrop.classList.add('opacity-0');
        confirmModalContent.classList.remove('translate-y-0', 'opacity-100');
        confirmModalContent.classList.add('translate-y-4', 'opacity-0');

        setTimeout(function() {
            confirmModal.style.display = 'none';
        }, 300);
    }
</script>
