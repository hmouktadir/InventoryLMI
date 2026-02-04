<x-app-layout>
    <style>
        /* Effet de brillance sur les cartes */
        .premium-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        /* Animation subtile pour le point "Live" */
        @keyframes pulse-indigo {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }
        .animate-live { animation: pulse-indigo 2s infinite; }

        /* Style des barres de progression fines */
        .progress-bar { height: 6px; border-radius: 10px; background: rgba(0,0,0,0.05); overflow: hidden; }
        .progress-value { height: 100%; border-radius: 10px; transition: width 1.5s ease-in-out; }
    </style>

    <div class="max-w-[1600px] mx-auto p-8 space-y-10">
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">
                    Hello, <span class="text-indigo-600">{{ Auth::user()->name }}</span> 👋
                </h1>
                <p class="text-slate-500 font-bold mt-2">Voici l'état de ton parc informatique ce {{ now()->format('d F Y') }}</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('prets.index') }}" class="flex items-center gap-3 bg-slate-900 text-white px-6 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200">
                    <span>➕</span> Nouveau Prêt
                </a>
                <a href="{{ route('stock.index') }}" class="flex items-center gap-3 bg-white text-slate-900 px-6 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest border border-slate-200 hover:bg-slate-50 transition-all">
                    📦 Gérer Stock
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="premium-card p-8 rounded-[2.5rem] group hover:scale-[1.02] transition-transform">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-indigo-200">🤝</div>
                    <span class="animate-live h-3 w-3 rounded-full bg-indigo-500 border-2 border-white"></span>
                </div>
                <div class="text-5xl font-black text-slate-900 tracking-tighter">{{ $pretsCount ?? 0 }}</div>
                <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest mt-2">Prêts Actifs</div>
                <div class="mt-6 flex items-center gap-2 text-[10px] font-bold text-indigo-500 bg-indigo-50 px-3 py-1.5 rounded-xl w-fit">
                    📈 +12% cette semaine
                </div>
            </div>

            <div class="premium-card p-8 rounded-[2.5rem] group hover:scale-[1.02] transition-transform border-rose-100">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-rose-500 rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-rose-200">⚠️</div>
                    <span class="text-rose-500 text-[10px] font-black uppercase">Urgent</span>
                </div>
                <div class="text-5xl font-black text-rose-600 tracking-tighter">{{ $lowStockCount ?? 0 }}</div>
                <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest mt-2">Articles critiques</div>
                <div class="mt-6 progress-bar">
                    <div class="progress-value bg-rose-500" style="width: {{ ($lowStockCount > 0) ? '85%' : '0%' }}"></div>
                </div>
            </div>

            <div class="premium-card p-8 rounded-[2.5rem] group hover:scale-[1.02] transition-transform">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-slate-300">👥</div>
                </div>
                <div class="text-5xl font-black text-slate-900 tracking-tighter">{{ \App\Models\User::count() }}</div>
                <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest mt-2">Staff IT</div>
                <div class="mt-6 flex -space-x-3">
                    @foreach(\App\Models\User::take(4)->get() as $u)
                        <div class="h-8 w-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[10px] font-bold">{{ substr($u->name,0,1) }}</div>
                    @endforeach
                </div>
            </div>

            <div class="premium-card p-8 rounded-[2.5rem] group hover:scale-[1.02] transition-transform">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-emerald-200">🏫</div>
                </div>
                <div class="text-5xl font-black text-slate-900 tracking-tighter">4</div>
                <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest mt-2">Sites Connectés</div>
                <div class="mt-6 text-[10px] font-bold text-emerald-600">Lycée / Collège / B1 / B2</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 premium-card p-10 rounded-[3.5rem]">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Répartition Géo-Informatique</h3>
                    <div class="flex gap-2">
                         <span class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-black uppercase">Filtre: Global</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10">
                    <div class="relative h-72">
                        <canvas id="siteChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-4xl font-black text-slate-900">{{ array_sum($dataGraph) }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase">Total</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach(['Lycée', 'Collège', 'B1', 'B2'] as $idx => $site)
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-indigo-100 hover:bg-white transition-all">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full {{ ['bg-indigo-500', 'bg-blue-400', 'bg-rose-400', 'bg-emerald-400'][$idx] }}"></span>
                                <span class="text-xs font-black text-slate-700 uppercase">{{ $site }}</span>
                            </div>
                            <span class="text-sm font-black text-slate-900">{{ $dataGraph[$idx] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="premium-card p-10 rounded-[3.5rem]">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8">Alertes Stock</h3>
                <div class="space-y-4 max-h-[480px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($articlesCritiques as $art)
                    <div class="p-5 bg-white/50 rounded-3xl border border-rose-50 group hover:border-rose-200 transition-all">
                        <div class="flex justify-between items-start mb-3">
                            <div class="font-black text-slate-800 text-sm tracking-tight">{{ $art->designation }}</div>
                            <span class="text-[10px] font-black text-rose-500 bg-rose-50 px-2 py-1 rounded-lg">Rupture</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Quantité restante</div>
                            <div class="text-lg font-black text-rose-600">{{ $art->quantite }}</div>
                        </div>
                        <div class="mt-3 progress-bar">
                            <div class="progress-value bg-rose-500" style="width: {{ ($art->quantite / 10) * 100 }}%"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20">
                        <div class="text-4xl mb-4">✨</div>
                        <p class="text-xs font-black text-emerald-500 uppercase">Tout est parfait !</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('siteChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Lycée', 'Collège', 'B1', 'B2'],
                    datasets: [{
                        data: @json($dataGraph),
                        backgroundColor: ['#6366f1', '#60a5fa', '#fb7185', '#34d399'],
                        borderWidth: 0,
                        borderRadius: 20,
                        spacing: 10,
                        cutout: '85%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    animation: { animateScale: true, duration: 2000 }
                }
            });
        });
    </script>
</x-app-layout>