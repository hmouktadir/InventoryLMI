<x-app-layout>
    <style>
        .table-spaced { border-separate: separate; border-spacing: 0 0.75rem; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="mb-8 flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Flux de <span class="text-indigo-600">Stock</span></h2>
                <p class="text-sm font-bold text-slate-400 mt-1">Journal détaillé des modifications de quantités</p>
            </div>
            <div class="glass-card px-6 py-4 rounded-[2rem] shadow-xl shadow-slate-200/50 flex items-center gap-4">
                <div class="h-12 w-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-xl">📈</div>
                <div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block">Activité</span>
                    <span class="text-xl font-black text-slate-800 tracking-tighter">{{ $historiques->count() }} <span class="text-indigo-500 text-sm">logs</span></span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto px-1">
            <table class="w-full table-spaced">
                <thead>
                    <tr class="text-slate-400 text-[11px] uppercase tracking-[0.2em] font-black">
                        <th class="px-8 py-2 text-left">🕒 Date & Heure</th>
                        <th class="px-8 py-2 text-left">📦 Article</th>
                        <th class="px-8 py-2 text-center">🔄 Variation</th>
                        <th class="px-8 py-2 text-center">👤 Technicien</th>
                        <th class="px-8 py-2 text-right">État Final</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historiques as $log)
                    @php 
                        $isIncrease = $log->nouvelle_quantite > $log->ancienne_quantite;
                    @endphp
                    <tr class="group bg-white hover:bg-slate-50 transition-all duration-300 shadow-sm hover:shadow-md border border-transparent">
                        
                        <td class="px-8 py-5 first:rounded-l-[2rem] border-y border-l border-slate-100 group-hover:border-indigo-100">
                            <div class="text-slate-800 font-bold text-sm tracking-tight">
                                {{ $log->created_at->format('d/m/Y') }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-black uppercase">
                                {{ $log->created_at->format('H:i') }}
                            </div>
                        </td>

                        <td class="px-8 py-5 border-y border-slate-100 group-hover:border-indigo-100">
                            <div class="text-slate-700 font-black text-sm">{{ $log->designation }}</div>
                        </td>

                        <td class="px-8 py-5 border-y border-slate-100 group-hover:border-indigo-100 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <span class="text-xs font-bold text-slate-400">{{ $log->ancienne_quantite }}</span>
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span class="text-sm font-black {{ $isIncrease ? 'text-emerald-500' : 'text-rose-500' }}">
                                    {{ $log->nouvelle_quantite }}
                                </span>
                            </div>
                        </td>

                        <td class="px-8 py-5 border-y border-slate-100 group-hover:border-indigo-100 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase tracking-tighter">
                                👤 {{ $log->technicien }}
                            </span>
                        </td>

                        <td class="px-8 py-5 last:rounded-r-[2rem] border-y border-r border-slate-100 group-hover:border-indigo-100 text-right">
                            @if($isIncrease)
                                <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-3 py-1 rounded-lg uppercase">
                                    + Ajout
                                </span>
                            @else
                                <span class="text-[10px] font-black text-rose-500 bg-rose-50 px-3 py-1 rounded-lg uppercase">
                                    - Retrait
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center text-slate-300">
                                <div class="text-6xl mb-4">⌛</div>
                                <p class="font-black italic text-slate-400">Aucun mouvement n'a encore été enregistré.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>