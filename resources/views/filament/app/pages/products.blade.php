<x-filament-panels::page>
    {{-- Page content --}}

    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-500">Your active gym membership expires in 24 days.</p>
    </div>

</x-filament-panels::page>
