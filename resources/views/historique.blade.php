<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Historique des Retours</h2>
                <p class="text-sm text-slate-400">Archive complète des matériels restitués</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Total archivé</span>
                <span class="text-lg font-bold text-indigo-600">{{ $historique->total() }} items</span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr class="text-slate-400 text-[11px] uppercase font-black tracking-widest">
                            <th class="px-8 py-5">Employé</th>
                            <th class="px-8 py-5">Équipement</th>
                            <th class="px-8 py-5">S/N</th>
                            <th class="px-8 py-5">Technicien</th>
                            <th class="px-8 py-5">Sortie</th>
                            <th class="px-8 py-5">Retour</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($historique as $item)
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="px-8 py-5">
                                <div class="font-bold text-slate-700 text-sm">{{ $item->employe }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="text-slate-600 text-sm font-medium">{{ $item->accessoire }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <code class="text-[10px] bg-slate-100 px-2 py-1 rounded text-slate-500 font-mono">
                                    {{ $item->numero_serie ?? 'N/A' }}
                                </code>
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase">
                                    {{ $item->technicien }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-slate-400 text-xs">
                                {{ \Carbon\Carbon::parse($item->date_affectation)->format('d/m/Y') }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center text-emerald-600 font-bold text-xs">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $item->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <p class="text-slate-400 font-medium text-sm">L'historique est vide pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-4 bg-slate-50/30 border-t border-slate-100">
                {{ $historique->links() }}
            </div>
        </div>
    </div>
</x-app-layout>