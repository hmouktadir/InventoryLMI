<?php

namespace App\Exports;

use App\Models\SalleEquipement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SallesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // On sélectionne uniquement les colonnes utiles
        return SalleEquipement::select('created_at', 'nom_salle', 'materiel', 'technicien', 'etat')->get();
    }

    public function headings(): array
    {
        return ["Date d'affectation", "Nom de la Salle", "Matériel", "Technicien", "État"];
    }
}