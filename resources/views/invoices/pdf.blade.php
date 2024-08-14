<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice PDF</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 50px;
        }
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .company-details {
            text-align: left;
            width: 48%;
            margin-bottom: 20px; /* Ajoute de l'espace en bas */
        }
        .client-details {
            text-align: left;
            width: 48%;
        }
        .invoice-details {
            text-align: right;
            margin-bottom: 20px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .total {
            text-align: right;
            font-size: 16px;
        }
        .description {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/wequipu.jpg') }}" alt="Company Logo">
        <h2>Facture</h2>
    </div>

    <div class="details">
        <div class="company-details">
            <strong>WEQUIPU INTERNATIONAL SARL</strong><br>
            NIF: 1000200997<br>
            ADRESSE: BP 20014<br>
            TÉLÉPHONE: 91 28 69 68
        </div>

        <div class="client-details">
            <strong>CLIENT DESTINATAIRE</strong><br>
            NOM: {{ $invoice->client->name }}<br>
            NIF: {{ $invoice->client->NIF }}<br>
            ADRESSE: {{ $invoice->client->address }}<br>
            EMAIL: {{ $invoice->client->email }}
        </div>
    </div>

    <div class="invoice-details">
        <strong>Numéro de facture :</strong> {{ $invoice->invoice_number }}<br>
        <strong>Date :</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}<br>
        <strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Item</th>
                <th>Produit</th>
                <th>Description</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product->item_code }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->product->description }}</td>
                <td>{{ $item->prix_unitaire }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->prix_unitaire * $item->quantity }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" class="total"><strong>Remise</strong></td>
                <td>{{ $invoice->discount }}</td>
            </tr>
            <tr>
                <td colspan="5" class="total"><strong>Total après remise</strong></td>
                <td>{{ $invoice->total }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Section de description -->
    <div class="description">
        <strong>Description:</strong><br>
        {{ $invoice->email_text }}
    </div>

</body>
</html>
