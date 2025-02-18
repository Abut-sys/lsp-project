<x-filament::page>
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold text-center mb-4">Login</h2>
            <form wire:submit.prevent="login">
                {{ $this->form }}

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mt-4">
                    Login
                </button>
            </form>
        </div>
    </div>
</x-filament::page>
