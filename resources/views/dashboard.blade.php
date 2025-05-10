<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 💰 Balans --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100">Hisob balansi:</h3>
                <p class="text-2xl text-green-500 font-semibold">
                    ${{ number_format($account->balance, 2) }}
                </p>
            </div>

            {{-- ➡️ Pul yuborish formasi --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">Pul yuborish</h3>

                <form method="POST" action="/transfer" class="space-y-4">
                    @csrf
                    <div>
                        <label for="receiver_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Qabul qiluvchi foydalanuvchi ID raqami
                        </label>
                        <input type="number" name="receiver_id" id="receiver_id" class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Miqdor ($)
                        </label>
                        <input type="number" name="amount" step="0.01" id="amount" class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Izoh
                        </label>
                        <textarea name="description" id="description" class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Yuborish
                        </button>
                    </div>
                </form>
            </div>

            {{-- 🧾 Tranzaksiya tarixi --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">Oxirgi tranzaksiyalar</h3>

                @forelse ($transactions as $tx)
                    <div class="border-b border-gray-300 dark:border-gray-600 py-2">
                        <p><strong>ID:</strong> {{ $tx->id }} |
                        <strong>Qabul qiluvchi:</strong> {{ $tx->receiver->name ?? 'Nomaʼlum' }} |
                        <strong>Miqdor:</strong> ${{ number_format($tx->amount, 2) }} |
                        <strong>Sana:</strong> {{ $tx->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                @empty
                    <p>Hali hech qanday tranzaksiya mavjud emas.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
