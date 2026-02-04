<x-app-layout>
    <style>
        .table-spaced { border-separate: separate; border-spacing: 0 0.75rem; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ openEdit: false, currentUser: { id: '', name: '', role: '' } }" class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="fixed top-24 right-10 z-[200] transform transition-all duration-500">
                <div class="bg-white border-l-4 border-emerald-500 shadow-2xl rounded-2xl p-5 flex items-center gap-4 min-w-[300px]">
                    <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Sécurité</p>
                        <p class="text-sm font-bold text-slate-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-card rounded-[2.5rem] p-8 shadow-xl sticky top-24">
                    <div class="h-12 w-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-xl mb-4">👤</div>
                    <h2 class="text-2xl font-black text-slate-800 mb-6 tracking-tight">Nouvel Utilisateur</h2>
                    
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Nom Complet</label>
                            <input type="text" name="name" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-semibold" placeholder="ex: Jean Dupont" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Email Professionnel</label>
                            <input type="email" name="email" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-semibold" placeholder="email@ecole.com" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Rôle Système</label>
                            <select name="role" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-bold text-slate-700 cursor-pointer">
                                <option value="technicien">🛠️ Technicien</option>
                                <option value="admin">🔑 Administrateur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Mot de passe</label>
                            <input type="password" name="password" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-mono" required>
                        </div>
                        <button type="submit" class="w-full btn-grad text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 hover:shadow-indigo-300 transition-all active:scale-95 uppercase tracking-widest text-xs">
                            Créer le compte
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="px-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-slate-800 text-2xl tracking-tight">Équipe <span class="text-indigo-600">Technique</span></h3>
                        <div class="bg-white px-4 py-2 rounded-2xl border border-slate-100 shadow-sm text-[10px] font-black uppercase text-slate-400 tracking-widest">
                            {{ $users->count() }} Comptes actifs
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-spaced">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-[0.2em] font-black">
                                    <th class="px-8 py-2 text-left">Utilisateur</th>
                                    <th class="px-8 py-2 text-center">Rôle</th>
                                    <th class="px-8 py-2 text-right">Accès</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="group bg-white hover:bg-indigo-50/40 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <td class="px-8 py-5 first:rounded-l-[2rem] border-y border-l border-slate-100 group-hover:border-indigo-100">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-slate-100 rounded-xl flex items-center justify-center text-xs font-black text-slate-500 mr-4 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-black text-slate-800 text-sm tracking-tight">{{ $user->name }}</div>
                                                <div class="text-[10px] text-slate-400 font-bold uppercase">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 border-y border-slate-100 group-hover:border-indigo-100 text-center">
                                        <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest
                                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-600 border border-purple-200' : 'bg-blue-100 text-blue-600 border border-blue-200' }}">
                                            {{ $user->role ?? 'Technicien' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 last:rounded-r-[2rem] border-y border-r border-slate-100 group-hover:border-indigo-100 text-right">
                                        <button @click="openEdit = true; currentUser = { id: '{{ $user->id }}', name: '{{ addslashes($user->name) }}', role: '{{ $user->role ?? 'technicien' }}' }" 
                                                class="text-[10px] font-black uppercase tracking-widest text-indigo-600 hover:text-white bg-indigo-50 hover:bg-indigo-600 px-4 py-2.5 rounded-xl transition-all active:scale-95 border border-indigo-100">
                                            Configurer
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openEdit" 
             class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             x-transition x-cloak>
            
            <div @click.away="openEdit = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-10 border border-white/20">
                <div class="text-center mb-8">
                    <div class="h-16 w-16 bg-indigo-100 text-indigo-600 rounded-3xl flex items-center justify-center text-2xl mx-auto mb-4 animate-bounce">🛡️</div>
                    <h2 class="text-2xl font-black text-slate-800">Sécurité Compte</h2>
                    <p class="text-indigo-500 font-bold uppercase tracking-widest text-[10px] mt-2" x-text="currentUser.name"></p>
                </div>

                <form :action="'/users/' + currentUser.id" method="POST" class="space-y-6">
                    @csrf @method('PATCH')
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Privilèges</label>
                        <select name="role" x-model="currentUser.role" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 font-bold text-slate-700 outline-none focus:border-indigo-500/20 focus:bg-white transition-all">
                            <option value="admin">Administrateur</option>
                            <option value="technicien">Technicien</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Réinitialiser Password</label>
                        <input type="password" name="password" placeholder="••••••••" 
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 outline-none focus:border-indigo-500/20 focus:bg-white transition-all font-mono">
                        <p class="text-[9px] text-slate-400 mt-3 text-center italic tracking-tight">Laissez vide pour conserver le mot de passe actuel.</p>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="openEdit = false" class="flex-1 py-4 font-black text-slate-400 hover:bg-slate-50 rounded-2xl transition">Annuler</button>
                        <button type="submit" class="flex-1 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-indigo-600 transition active:scale-95 uppercase tracking-widest text-xs">
                            Appliquer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>