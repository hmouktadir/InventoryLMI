<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0; size: A4; }
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            margin: 0; padding: 0; 
            width: 210mm; height: 297mm;
            color: #1e293b;
            background: #f8fafc; /* Fond très légèrement gris pour faire ressortir les cadres */
        }

        .page-wrapper {
            position: relative;
            width: 210mm;
            height: 297mm;
            background: white;
        }

        /* Cadre avec largeur réduite pour éviter d'être coupé à droite */
        .coupon-border {
            position: absolute;
            width: 180mm; 
            height: 125mm; 
            left: 5mm; /* Centrage parfait (210 - 180) / 2 */
            border: 1px solid #e2e8f0;
            background: #ffffff;
            border-radius: 20px;
            padding: 10mm;
            box-sizing: border-box;
            /* Simulation d'ombre par une double bordure ou trait épais en bas */
            border-bottom: 4px solid #b60000; 
        }

        .top-coupon { top: 5mm; }
        .bottom-coupon { top: 160mm; }

        /* Ligne de découpe */
        .cut-line {
            position: absolute;
            top: 148.5mm;
            width: 100%;
            border-top: 2px dashed #cbd5e1;
            text-align: center;
        }
        .cut-line span {
            position: relative;
            /* top: -12px; */
            background: white;
            padding: 0 15px;
            font-size: 11px;
            color: #94a3b8;
            font-weight: bold;
        }

        .header { width: 100%; margin-bottom: 15px; }
        .logo { width: 130px; height: auto; }
        
        .title-area { text-align: right; }
        .title-area h2 { 
            margin: 0; 
            color: #1e3a8a; 
            font-size: 19px; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .badge { 
            display: inline-block; 
            padding: 4px 12px; 
            background: #eff6ff; 
            color: #1e40af;
            font-size: 9px; 
            font-weight: bold; 
            border-radius: 50px;
            margin-top: 6px;
            border: 1px solid #dbeafe;
        }

        /* Tableaux Modernes */
        table.data { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.data th { 
            background: #f1f5f9; 
            color: #475569; 
            text-align: left; 
            padding: 10px; 
            font-size: 10px; 
            text-transform: uppercase;
            border-radius: 8px 0 0 0;
        }
        table.data td { 
            padding: 12px 10px; 
            border-bottom: 1px solid #f1f5f9; 
            font-size: 12px;
            color: #1e293b;
        }

        /* Signatures stylées */
        .sigs { margin-top: 25px; }
        .sig-box { width: 45%; display: inline-block; }
        .sig-label { 
            font-size: 10px; 
            font-weight: bold; 
            color: #64748b; 
            text-transform: uppercase; 
            margin-bottom: 8px;
        }
        .sig-space {
            height: 50px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
        }

        .footer { 
            font-size: 9px; 
            text-align: center; 
            color: #94a3b8; 
            margin-top: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <div class="coupon-border top-coupon">
        <table class="header">
            <tr>
                <td><img src="https://upload.wikimedia.org/wikipedia/commons/5/57/Lyc%C3%A9e_fran%C3%A7ais_international_Louis-Massignon_Logo.jpg" class="logo"></td>
                <td class="title-area">
                    <h2>Bon de Décharge</h2>
                    <span class="badge">COPIE ADMINISTRATION</span>
                </td>
            </tr>
        </table>

        <div style="background: #1e3a8a; color: white; padding: 10px; border-radius: 10px; font-size: 11px; margin-bottom: 15px;">
            <table width="100%">
                <tr>
                    <td><strong>BÉNÉFICIAIRE :</strong> {{ $pret->employe }}</td>
                    <td align="right"><strong>DATE :</strong> {{ date('d/m/Y') }}</td>
                </tr>
            </table>
        </div>

        <table class="data">
            <thead>
                <tr>
                    <th width="70%">Équipement Affecté</th>
                    <th width="30%">Numéro de Série</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $pret->accessoire }} ({{ $pret->site }})</td>
                    <td style="font-weight: bold;">{{ $pret->numero_serie ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="sigs">
            <div class="sig-box">
                <div class="sig-label">Signature Bénéficiaire</div>
                <div class="sig-space"></div>
            </div>
            <div class="sig-box" style="margin-left: 8%;">
                <div class="sig-label">Visa Service IT</div>
                <div class="sig-space"></div>
            </div>
        </div>
    </div>

    <div class="cut-line">
        <span>✂ DOCUMENT À DÉCOUPER ✂</span>
    </div>

    <div class="coupon-border bottom-coupon">
        <table class="header">
            <tr>
                <td><img src="https://upload.wikimedia.org/wikipedia/commons/5/57/Lyc%C3%A9e_fran%C3%A7ais_international_Louis-Massignon_Logo.jpg" class="logo"></td>
                <td class="title-area">
                    <h2>Bon de Décharge</h2>
                    <span class="badge">COPIE PERSONNEL</span>
                </td>
            </tr>
        </table>

        <div style="border: 1px solid #1e3a8a; color: #1e3a8a; padding: 10px; border-radius: 10px; font-size: 11px; margin-bottom: 15px;">
            <strong>AGENT :</strong> {{ $pret->employe }} | <strong>SITE :</strong> {{ $pret->site }}
        </div>

        <table class="data">
            <thead>
                <tr>
                    <th width="70%">Matériel reçu en bon état</th>
                    <th width="30%">S/N</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $pret->accessoire }}</td>
                    <td style="font-weight: bold;">{{ $pret->numero_serie ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="sigs">
            <div class="sig-box">
                <div class="sig-label">Signature Bénéficiaire</div>
                <div class="sig-space"></div>
            </div>
            <div class="sig-box" style="margin-left: 8%;">
                <div class="sig-label">Visa Service IT</div>
                <div class="sig-space"></div>
            </div>
        </div>

        <div class="footer">Ce document doit être conservé par l'agent et restitué lors de son départ.</div>
    </div>

</div>

</body>
</html>