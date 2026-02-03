<x-app-layout>
    <div class="py-12" x-data="{ openEdit: false, currentStock: {} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Désignation</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Quantité</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stocks as $item)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $item->designation }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full font-bold text-sm">
                                    {{ $item->quantite }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="openEdit = true; currentStock = { id: '{{ $item->id }}', name: '{{ $item->designation }}', qty: '{{ $item->quantite }}' }" 
                                        class="text-amber-500 hover:text-amber-700 font-bold p-2">
                                    ✏️ Modifier
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openEdit" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            
            <div @click.away="openEdit = false" 
                 class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 transform transition-all">
                
                <h2 class="text-xl font-black text-slate-800 mb-1">Modifier le stock</h2>
                <p class="text-sm text-slate-400 mb-6" x-text="currentStock.name"></p>

                <form :action="'/stock/' + currentStock.id" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-6">
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2">Quantité actuelle</label>
                        <input type="number" name="quantite" x-model="currentStock.qty" 
                               class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 focus:ring-4 focus:ring-indigo-500/10 text-xl font-bold outline-none">
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="openEdit = false" class="flex-1 py-4 font-bold text-slate-500 hover:bg-slate-50 rounded-2xl transition">Annuler</button>
                        <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-10 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         class="fixed bottom-10 right-10 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 z-[200]">
        <span class="bg-emerald-500 rounded-full p-1 italic text-[10px]">OK</span>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif
</x-app-layout>