<x-app-layout>
    <div x-data="{ openEdit: false, currentUser: { id: '', name: '', role: '' } }" class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">Gestion des Utilisateurs</h3>
            </div>

            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-[11px] uppercase tracking-widest border-b border-slate-50">
                        <th class="px-8 py-4">Nom & Email</th>
                        <th class="px-8 py-4">Rôle</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition-all">
                        <td class="px-8 py-5">
                            <div class="text-slate-700 font-bold text-sm">{{ $user->name }}</div>
                            <div class="text-xs text-slate-400">{{ $user->email }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right flex justify-end gap-2">
                            <button @click="openEdit = true; currentUser = { id: '{{ $user->id }}', name: '{{ addslashes($user->name) }}', role: '{{ $user->role }}' }" 
                                    class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs hover:bg-slate-900 hover:text-white transition-all">
                                Gérer l'accès
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak x-transition>
            <div @click.away="openEdit = false" class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 border border-slate-100">
                <h2 class="text-xl font-black text-slate-800 mb-1">Modifier l'utilisateur</h2>
                <p class="text-sm text-indigo-500 font-bold mb-6" x-text="currentUser.name"></p>

                <form :action="'/users/' + currentUser.id" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Droit d'accès</label>
                            <select name="role" x-model="currentUser.role" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 font-bold text-slate-700 outline-none">
                                <option value="admin">Administrateur</option>
                                <option value="technicien">Technicien</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 text-red-500">Réinitialiser le mot de passe</label>
                            <input type="password" name="password" placeholder="Laisser vide pour ne pas changer" 
                                   class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none focus:ring-2 focus:ring-red-200">
                            <p class="text-[9px] text-slate-400 mt-1 italic">L'utilisateur devra utiliser ce nouveau MDP à sa prochaine connexion.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="button" @click="openEdit = false" class="flex-1 py-4 font-bold text-slate-400">Annuler</button>
                        <button type="submit" class="flex-1 py-4 bg-slate-900 text-white font-bold rounded-2xl shadow-xl hover:bg-indigo-600 transition-all">
                            Appliquer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>