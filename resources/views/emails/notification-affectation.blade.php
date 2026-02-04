<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7fa; padding: 20px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
        
        <div style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 30px; text-align: center;">
            <span style="font-size: 40px;">📦</span>
            <h2 style="color: #ffffff; margin: 10px 0 0 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px;">Avis d'Affectation</h2>
        </div>

        <div style="padding: 30px;">
            <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">
                Une nouvelle affectation de matériel a été enregistrée par le service informatique.
            </p>

            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <tr>
                    <td style="padding: 12px 0; color: #94a3b8; font-weight: bold; text-transform: uppercase; font-size: 11px; width: 40%;">Bénéficiaire</td>
                    <td style="padding: 12px 0; color: #1e293b; font-weight: bold;">
                        {{ $data['employe'] ?? $data['salle'] }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; color: #94a3b8; font-weight: bold; text-transform: uppercase; font-size: 11px;">Site / Lieu</td>
                    <td style="padding: 12px 0; color: #1e293b; font-weight: bold;">{{ $data['site'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; color: #94a3b8; font-weight: bold; text-transform: uppercase; font-size: 11px;">Matériel</td>
                    <td style="padding: 12px 0; color: #4f46e5; font-weight: bold;">{{ $data['materiel'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; color: #94a3b8; font-weight: bold; text-transform: uppercase; font-size: 11px;">Technicien IT</td>
                    <td style="padding: 12px 0; color: #1e293b;">👤 {{ $data['technicien'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; color: #94a3b8; font-weight: bold; text-transform: uppercase; font-size: 11px;">État déclaré</td>
                    <td style="padding: 12px 0;">
                        <span style="background-color: #f0fdf4; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                            {{ $data['etat'] }}
                        </span>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #f1f5f9; text-align: center;">
                <p style="color: #94a3b8; font-size: 12px; font-style: italic;">
                    Date de l'opération : {{ now()->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>

        <div style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="color: #64748b; font-size: 11px; margin: 0;">
                Ceci est une notification automatique. Merci de ne pas répondre à ce mail.
            </p>
        </div>
    </div>
</body>
</html>