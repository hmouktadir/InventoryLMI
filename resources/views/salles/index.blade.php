<x-app-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ openEdit: false, currentEquipement: { id: '', salle: '', materiel: '', date: '' } }" class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-800">Équipements des Salles</h1>
                <p class="text-sm text-slate-500 font-medium">Gestion et suivi du matériel par emplacement</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-400 text-[11px] uppercase tracking-widest border-b border-slate-100">
                        <th class="px-8 py-4">Salle / Emplacement</th>
                        <th class="px-8 py-4">Matériel Affecté</th>
                        <th class="px-8 py-4 text-center">Date d'Affectation</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($salles as $salle)
                    <tr class="hover:bg-slate-50/80 transition-all">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg font-bold text-xs">🏠</div>
                                <span class="text-slate-700 font-bold">{{ $salle->nom_salle }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm text-slate-600 font-medium">
                            {{ $salle->materiel_affecte }}
                        </td>
                        <td class="px-8 py-5 text-center text-xs font-bold text-slate-500">
                            {{ $salle->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button @click="openEdit = true; currentEquipement = { id: '{{ $salle->id }}', salle: '{{ addslashes($salle->nom_salle) }}', materiel: '{{ addslashes($salle->materiel_affecte) }}' }"
                                        class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                    ✏️
                                </button>

                                <form action="{{ route('salles.destroy', $salle->id) }}" method="POST" onsubmit="return confirm('Retirer cet équipement de la salle ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold italic text-sm">Aucun équipement affecté pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition x-cloak>
            <div @click.away="openEdit = false" class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 border border-slate-100">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-800">Modifier l'affectation</h2>
                    <p class="text-sm text-indigo-500 font-bold uppercase tracking-widest text-[10px]" x-text="currentEquipement.salle"></p>
                </div>

                <form :action="'/salles/' + currentEquipement.id" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-4 mb-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Matériel dans la salle</label>
                            <input type="text" name="materiel_affecte" x-model="currentEquipement.materiel" 
                                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 font-bold text-slate-700 outline-none">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" @click="openEdit = false" class="flex-1 py-4 font-bold text-slate-500 hover:bg-slate-50 rounded-2xl transition">Annuler</button>
                        <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:bg-indigo-700 transition active:scale-95">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>