<x-app-layout>
    <div x-data="{ openEdit: false, currentUser: { id: '', name: '', role: '' } }" class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-2xl font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-100">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Ajouter un Utilisateur</h2>
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nom Complet</label>
                            <input type="text" name="name" class="w-full border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-4 focus:ring-indigo-500/10" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Email</label>
                            <input type="email" name="email" class="w-full border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-4 focus:ring-indigo-500/10" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Rôle par défaut</label>
                            <select name="role" class="w-full border-slate-200 rounded-xl px-4 py-3 outline-none">
                                <option value="technicien">Technicien</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Mot de passe provisoire</label>
                            <input type="password" name="password" class="w-full border-slate-200 rounded-xl px-4 py-3 outline-none" required>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-indigo-700 transition-all">
                            Créer le compte
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-4 text-xs font-black uppercase text-slate-400">Nom & Email</th>
                                <th class="px-8 py-4 text-xs font-black uppercase text-slate-400 text-center">Rôle</th>
                                <th class="px-8 py-4 text-xs font-black uppercase text-slate-400 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50 transition-all group">
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-700">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }}">
                                        {{ $user->role ?? 'Technicien' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button @click="openEdit = true; currentUser = { id: '{{ $user->id }}', name: '{{ addslashes($user->name) }}', role: '{{ $user->role ?? 'technicien' }}' }" 
                                            class="text-xs font-bold text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg transition-colors">
                                        Gérer l'accès
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="openEdit" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            
            <div @click.away="openEdit = false" class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 border border-slate-100">
                <h2 class="text-xl font-black text-slate-800 mb-1 text-center">Gestion de l'accès</h2>
                <p class="text-sm text-indigo-500 font-bold mb-6 text-center" x-text="currentUser.name"></p>

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
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Nouveau mot de passe</label>
                            <input type="password" name="password" placeholder="Laisser vide pour ne pas changer" 
                                   class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-200">
                            <p class="text-[9px] text-slate-400 mt-2 italic text-center italic">Le changement est immédiat après validation.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="button" @click="openEdit = false" class="flex-1 py-4 font-bold text-slate-500 hover:bg-slate-50 rounded-2xl transition">Annuler</button>
                        <button type="submit" class="flex-1 py-4 bg-slate-900 text-white font-bold rounded-2xl shadow-xl hover:bg-indigo-600 transition-all">
                            Appliquer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>