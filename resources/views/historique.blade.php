<x-app-layout>
    <style>
        .table-spaced { border-separate: separate; border-spacing: 0 0.75rem; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="mb-8 flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Archives <span class="text-indigo-600">Retours</span></h2>
                <p class="text-sm font-bold text-slate-400 mt-1">Historique complet des matériels restitués au stock</p>
            </div>
            <div class="glass-card px-6 py-4 rounded-[2rem] shadow-xl shadow-slate-200/50 flex items-center gap-4">
                <div class="h-12 w-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-xl">📂</div>
                <div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block">Total archivé</span>
                    <span class="text-xl font-black text-slate-800 tracking-tighter">{{ $historique->total() }} <span class="text-indigo-500 text-sm">articles</span></span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto px-1">
            <table class="w-full table-spaced">
                <thead>
                    <tr class="text-slate-400 text-[11px] uppercase tracking-[0.2em] font-black">
                        <th class="px-8 py-2 text-left">👤 Employé</th>
                        <th class="px-8 py-2 text-left">🖥️ Équipement</th>
                        <th class="px-8 py-2 text-center">🆔 S/N</th>
                        <th class="px-8 py-2 text-center">🛠️ Technicien</th>
                        <th class="px-8 py-2 text-right">📅 Dates & Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historique as $item)
                    <tr class="group bg-white hover:bg-emerald-50/30 transition-all duration-300 shadow-sm hover:shadow-md border border-transparent hover:border-emerald-100">
                        
                        <td class="px-8 py-5 first:rounded-l-[2rem] border-y border-l border-slate-100 group-hover:border-emerald-100">
                            <div class="flex items-center">
                                <div class="h-9 w-9 bg-slate-100 rounded-xl flex items-center justify-center text-xs font-black text-slate-500 mr-3 shadow-inner group-hover:bg-white group-hover:text-emerald-500 transition-colors">
                                    {{ substr($item->employe, 0, 1) }}
                                </div>
                                <div class="font-black text-slate-800 text-sm tracking-tight">{{ $item->employe }}</div>
                            </div>
                        </td>

                        <td class="px-8 py-5 border-y border-slate-100 group-hover:border-emerald-100">
                            <div class="text-slate-600 text-sm font-bold italic">{{ $item->accessoire }}</div>
                        </td>

                        <td class="px-8 py-5 border-y border-slate-100 group-hover:border-emerald-100 text-center">
                            <code class="text-[9px] bg-slate-50 px-2 py-1 rounded-lg text-slate-400 font-mono border border-slate-100 group-hover:bg-white">
                                {{ $item->numero_serie ?? 'SANS S/N' }}
                            </code>
                        </td>

                        <td class="px-8 py-5 border-y border-slate-100 group-hover:border-emerald-100 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-slate-100 text-slate-500 border border-slate-200 uppercase tracking-tighter group-hover:bg-white group-hover:border-emerald-200 group-hover:text-emerald-600">
                                {{ $item->technicien }}
                            </span>
                        </td>

                        <td class="px-8 py-5 last:rounded-r-[2rem] border-y border-r border-slate-100 group-hover:border-emerald-100 text-right">
                            <div class="flex flex-col items-end">
                                <div class="flex items-center text-emerald-600 font-black text-[10px] uppercase tracking-tighter mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                                    Retourné le {{ $item->updated_at->format('d/m/Y') }}
                                </div>
                                <div class="text-[9px] text-slate-400 font-bold">
                                    Sortie le {{ \Carbon\Carbon::parse($item->date_affectation)->format('d/m/Y') }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-slate-50 rounded-full flex items-center justify-center text-3xl mb-4">📭</div>
                                <p class="text-slate-400 font-black italic tracking-tight">L'historique des retours est vide.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 px-4">
            {{ $historique->links() }}
        </div>
    </div>
</x-app-layout>