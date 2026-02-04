<nav class="sticky top-0 z-[100] bg-white/70 backdrop-blur-xl border-b border-slate-200/50 shadow-sm" 
     x-data="{ openPrets: false, openStock: false, mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-4 transition-all">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                        <img class="relative h-11 w-auto rounded-xl shadow-lg group-hover:scale-105 transition-transform duration-500 ease-out" 
                             src="{{ asset('images/logo.jpg') }}" alt="Logo">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-slate-900 tracking-tighter text-2xl leading-none">LFILM</span>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[9px] text-slate-500 font-black uppercase tracking-[0.2em]">Système Inventaire</span>
                        </div>
                    </div>
                </a>

                <div class="hidden lg:flex ml-16 space-x-2">
                    
                    <div class="relative" @mouseenter="openPrets = true" @mouseleave="openPrets = false">
                        <button class="group flex items-center gap-2 px-5 py-2.5 rounded-2xl text-[13px] font-black tracking-tight transition-all duration-300"
                                :class="openPrets ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span>Mouvements</span>
                            <svg class="w-3 h-3 transition-transform duration-500" :class="openPrets ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openPrets" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-cloak 
                             class="absolute top-full left-0 w-80 mt-2 bg-white/95 backdrop-blur-xl border border-slate-100 shadow-2xl rounded-[2rem] overflow-hidden p-3 ring-1 ring-slate-900/5">
                            <a href="{{ route('prets.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-indigo-50 group/item transition-all">
                                <div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center group-hover/item:scale-110 transition-transform">🤝</div>
                                <div class="ml-4">
                                    <div class="text-sm font-black text-slate-800 tracking-tight">Prêts Individuels</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Sortie personnel</div>
                                </div>
                            </a>
                            <a href="{{ route('salles.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-emerald-50 group/item transition-all mt-1">
                                <div class="h-10 w-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center group-hover/item:scale-110 transition-transform">🏫</div>
                                <div class="ml-4">
                                    <div class="text-sm font-black text-slate-800 tracking-tight">Parc Salles</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Équipements fixes</div>
                                </div>
                            </a>
                            <div class="h-px bg-slate-100 my-2 mx-4"></div>
                            <a href="{{ route('prets.historique') }}" class="flex items-center justify-center p-3 text-[11px] font-black text-indigo-500 uppercase tracking-widest hover:text-indigo-700 transition-colors italic">
                                📋 Historique des retours
                            </a>
                        </div>
                    </div>

                    <div class="relative" @mouseenter="openStock = true" @mouseleave="openStock = false">
                        <button class="flex items-center gap-2 px-5 py-2.5 rounded-2xl text-[13px] font-black tracking-tight transition-all duration-300"
                                :class="openStock ? 'bg-amber-500 text-white shadow-lg shadow-amber-100' : 'text-slate-600 hover:bg-slate-50'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l-8 4"></path></svg>
                            <span>Inventaire</span>
                            <svg class="w-3 h-3 transition-transform duration-500" :class="openStock ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openStock" x-transition x-cloak 
                             class="absolute top-full left-0 w-80 mt-2 bg-white/95 backdrop-blur-xl border border-slate-100 shadow-2xl rounded-[2rem] overflow-hidden p-3 ring-1 ring-slate-900/5">
                            <a href="{{ route('stock.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-amber-50 group/item transition-all">
                                <div class="h-10 w-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center group-hover/item:scale-110">🔋</div>
                                <div class="ml-4">
                                    <div class="text-sm font-black text-slate-800 tracking-tight">Consommables</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Gestion du stock</div>
                                </div>
                            </a>
                            <a href="{{ route('stock.history') }}" class="flex items-center p-4 rounded-2xl hover:bg-slate-100 group/item transition-all mt-1">
                                <div class="h-10 w-10 bg-slate-200 text-slate-600 rounded-xl flex items-center justify-center group-hover/item:scale-110">📜</div>
                                <div class="ml-4">
                                    <div class="text-sm font-black text-slate-800 tracking-tight">Flux Stock</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Journal des techniciens</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden sm:flex items-center">
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-4 pl-4 pr-1 py-1 bg-slate-100/50 hover:bg-slate-100 rounded-[1.25rem] transition-all duration-300 border border-slate-200/50 outline-none group">
                                <div class="flex flex-col items-end">
                                    <span class="text-[11px] font-black text-slate-900 leading-none tracking-tight">{{ Auth::user()->name }}</span>
                                    <span class="text-[8px] font-black text-indigo-500 uppercase tracking-[0.2em] mt-1">{{ Auth::user()->role }}</span>
                                </div>
                                <div class="h-10 w-10 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-xs shadow-xl group-hover:scale-105 transition-transform">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-2">
                                <div class="px-4 py-3 text-[10px] text-slate-400 font-black uppercase tracking-widest border-b border-slate-50 mb-2">Centre de contrôle</div>
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 font-bold text-slate-700 py-3 rounded-xl hover:bg-indigo-50">
                                    <span class="text-lg">⚙️</span> {{ __('Mon Profil') }}
                                </x-dropdown-link>

                                @if(strtolower(Auth::user()->role) === 'admin')
                                    <x-dropdown-link :href="route('users.index')" class="text-indigo-600 font-black flex items-center gap-3 py-3 rounded-xl hover:bg-indigo-100/50 transition-colors mt-1">
                                        <span class="text-lg">🛡️</span> {{ __('Administration') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-slate-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full text-left font-black text-red-500 hover:text-red-700 p-3 rounded-xl hover:bg-red-50 transition-all text-xs uppercase tracking-widest">
                                        <span>🚪</span> {{ __('Déconnexion') }}
                                    </button>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

        </div>
    </div>
</nav>