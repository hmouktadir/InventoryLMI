<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Historique des mouvements</h2>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($historiques->isEmpty())
                    <p class="text-slate-500 text-center">Aucun mouvement enregistré pour le moment.</p>
                @else
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b text-left text-xs font-bold uppercase text-slate-400">
                                <th class="p-4">Date de mise a jour</th>
                                <th class="p-4">Article</th>
                                <th class="p-4">Ancienne Qté</th>
                                <th class="p-4">Nouvelle Qté</th>
                                <th class="p-4">Technicien</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historiques as $log)
                                <tr class="border-b hover:bg-slate-50">
                                    <td class="p-4">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="p-4 font-bold">{{ $log->designation }}</td>
                                    <td class="p-4">{{ $log->ancienne_quantite }}</td>
                                    <td class="p-4 text-indigo-600 font-bold">{{ $log->nouvelle_quantite }}</td>
                                    <td class="p-4 text-sm">{{ $log->technicien }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>