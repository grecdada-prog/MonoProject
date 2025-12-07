<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $sale->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #333;
            padding: 30px;
            background: #fff;
        }

        .header {
            margin-bottom: 40px;
            border-bottom: 3px solid #DC2626;
            padding-bottom: 20px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo-section {
            display: table-cell;
            vertical-align: middle;
            width: 40%;
        }

        .logo {
            background: linear-gradient(135deg, #DC2626 0%, #991B1B 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            display: inline-block;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: -1px;
        }

        .logo-smart {
            color: white;
        }

        .logo-stock {
            color: #FEE2E2;
        }

        .company-info {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 60%;
            font-size: 10px;
            color: #666;
        }

        .company-info h1 {
            font-size: 20px;
            color: #111;
            margin-bottom: 8px;
        }

        .company-info p {
            margin: 3px 0;
        }

        .invoice-title {
            background: #F3F4F6;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid #DC2626;
        }

        .invoice-title h2 {
            font-size: 24px;
            color: #DC2626;
            margin-bottom: 5px;
        }

        .invoice-number {
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }

        .details-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .details-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .details-box {
            background: #FAFAFA;
            border: 1px solid #E5E7EB;
            border-radius: 6px;
            padding: 15px;
            margin-right: 15px;
        }

        .details-col:last-child .details-box {
            margin-right: 0;
            margin-left: 15px;
        }

        .details-box h3 {
            font-size: 12px;
            color: #DC2626;
            text-transform: uppercase;
            margin-bottom: 10px;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 5px;
        }

        .details-box p {
            margin: 6px 0;
            font-size: 10px;
        }

        .details-box strong {
            color: #000;
            font-weight: 600;
            display: inline-block;
            min-width: 80px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }

        thead th {
            background: linear-gradient(135deg, #1F2937 0%, #111827 100%);
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        tbody td {
            padding: 10px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 10px;
        }

        tbody tr:last-child td {
            border-bottom: 2px solid #DC2626;
        }

        tbody tr:hover {
            background: #F9FAFB;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .product-name {
            font-weight: 600;
            color: #111;
        }

        .summary {
            margin-top: 30px;
            text-align: right;
        }

        .summary-table {
            display: inline-block;
            min-width: 300px;
        }

        .summary-row {
            display: table;
            width: 100%;
            margin: 5px 0;
        }

        .summary-label {
            display: table-cell;
            text-align: right;
            padding-right: 20px;
            font-size: 11px;
            color: #666;
        }

        .summary-value {
            display: table-cell;
            text-align: right;
            font-size: 11px;
            font-weight: bold;
            color: #111;
        }

        .summary-total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #DC2626;
        }

        .summary-total .summary-label {
            font-size: 14px;
            color: #000;
            font-weight: 600;
        }

        .summary-total .summary-value {
            font-size: 18px;
            color: #DC2626;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            font-size: 9px;
            color: #9CA3AF;
        }

        .footer-section {
            margin-bottom: 10px;
        }

        .footer strong {
            color: #666;
        }

        .conditions {
            background: #FEF2F2;
            border-left: 3px solid #DC2626;
            padding: 12px;
            margin: 25px 0;
            font-size: 9px;
            color: #666;
        }

        .conditions h4 {
            color: #DC2626;
            font-size: 10px;
            margin-bottom: 8px;
        }

        .conditions ul {
            margin-left: 15px;
            margin-top: 5px;
        }

        .conditions li {
            margin: 3px 0;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success {
            background: #D1FAE5;
            color: #065F46;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">
                    <span class="logo-smart">Smart</span><span class="logo-stock">Stock</span>
                </div>
            </div>
            <div class="company-info">
                <h1>SMARTSTOCK SARL</h1>
                <p>Système de Gestion de Stock Intelligent</p>
                <p>Douala, Cameroun</p>
                <p>Tél: +237 6 XX XX XX XX</p>
                <p>Email: contact@smartstock.cm</p>
            </div>
        </div>
    </div>

    {{-- INVOICE TITLE --}}
    <div class="invoice-title">
        <h2>FACTURE <span class="badge badge-success">PAYÉE</span></h2>
        <div class="invoice-number">N° {{ $sale->invoice_number }}</div>
    </div>

    {{-- DETAILS --}}
    <div class="details-section">
        <div class="details-col">
            <div class="details-box">
                <h3>Informations Vente</h3>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($sale->sold_at)->format('d/m/Y à H:i') }}</p>
                <p><strong>Vendeur:</strong> {{ $sale->seller->name ?? $sale->seller->username }}</p>
                <p><strong>Mode Paiement:</strong> {{ $sale->payment_method ?? 'Espèces' }}</p>
                @if($sale->payment_ref)
                <p><strong>Réf. Paiement:</strong> {{ $sale->payment_ref }}</p>
                @endif
            </div>
        </div>
        <div class="details-col">
            <div class="details-box">
                <h3>Informations Client</h3>
                @if($sale->client_name)
                <p><strong>Nom:</strong> {{ $sale->client_name }}</p>
                @else
                <p><strong>Client:</strong> <em>Client de passage</em></p>
                @endif
                @if($sale->client_phone)
                <p><strong>Téléphone:</strong> {{ $sale->client_phone }}</p>
                @endif
                @if($sale->client_email)
                <p><strong>Email:</strong> {{ $sale->client_email }}</p>
                @endif
                @if(!$sale->client_name && !$sale->client_phone && !$sale->client_email)
                <p style="color: #9CA3AF; font-style: italic;">Aucune information client</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ITEMS TABLE --}}
    <table>
        <thead>
            <tr>
                <th style="width: 10%">#</th>
                <th style="width: 45%">Produit</th>
                <th style="width: 15%; text-align: center;">Quantité</th>
                <th style="width: 15%; text-align: right;">Prix Unit.</th>
                <th style="width: 15%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sale->items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="product-name">{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->unit_price, 0, ',', ' ') }} F</td>
                <td class="text-right">{{ number_format($item->total_price, 0, ',', ' ') }} F</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- SUMMARY --}}
    <div class="summary">
        <div class="summary-table">
            <div class="summary-row">
                <div class="summary-label">Nombre d'articles:</div>
                <div class="summary-value">{{ $sale->total_items }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Sous-total:</div>
                <div class="summary-value">{{ number_format($sale->total_amount, 0, ',', ' ') }} F</div>
            </div>
            <div class="summary-row summary-total">
                <div class="summary-label">TOTAL À PAYER:</div>
                <div class="summary-value">{{ number_format($sale->total_amount, 0, ',', ' ') }} FCFA</div>
            </div>
        </div>
    </div>

    {{-- CONDITIONS --}}
    <div class="conditions">
        <h4>Conditions de Vente</h4>
        <ul>
            <li>Facture payée en totalité au moment de la vente</li>
            <li>Aucun remboursement après réception de la marchandise</li>
            <li>Garantie selon les conditions du fabricant</li>
            <li>En cas de litige, seul le tribunal de Douala est compétent</li>
        </ul>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="footer-section">
            <strong>SmartStock - Système de Gestion Intelligent</strong>
        </div>
        <div class="footer-section">
            Facture générée électroniquement le {{ now()->format('d/m/Y à H:i') }}
        </div>
        <div class="footer-section">
            Cette facture est définitive et ne peut être modifiée. Conservez-la pour toute réclamation.
        </div>
    </div>

</body>
</html>
