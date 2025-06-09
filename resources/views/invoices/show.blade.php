<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <!-- Include Bootstrap for styling. Ensure this path is accessible for Dompdf -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            margin: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>Fleet MS</h2>
                            </td>
                            <td>
                                Invoice #: {{ $invoice->invoice_number }}<br>
                                Created: {{ $invoice->invoice_date->format('F d, Y') }}<br>
                                Due: {{ $invoice->due_date->format('F d, Y') }}<br>
                                Status: {{ ucfirst($invoice->status) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ config('app.name', 'Fleet Management System') }}<br>
                                Your Company Address<br>
                                Your Contact Info
                            </td>
                            <td>
                                {{ $invoice->client->company_name ?? 'N/A' }}<br>
                                {{ $invoice->client->contact_person ?? 'N/A' }}<br>
                                {{ $invoice->client->email ?? 'N/A' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Item Description</td>
                <td class="text-end">Amount</td>
            </tr>

            <tr class="item">
                <td>Monthly Service Charges for Contract #{{ $invoice->contract->contract_number ?? 'N/A' }}
                    @if ($invoice->notes)
                        <br><small class="text-muted">({{ $invoice->notes }})</small>
                    @endif
                </td>
                <td class="text-end">
                    @if($invoice->amount_tzs > 0)
                        TZS {{ number_format($invoice->amount_tzs, 2) }}
                    @else
                        USD {{ number_format($invoice->amount_usd, 2) }}
                    @endif
                </td>
            </tr>

            <tr class="total">
                <td></td>
                <td class="text-end">
                   Total:
                   @if($invoice->amount_tzs > 0)
                       TZS {{ number_format($invoice->amount_tzs, 2) }}
                   @else
                       USD {{ number_format($invoice->amount_usd, 2) }}
                   @endif
                </td>
            </tr>
        </table>
        <div class="footer">
            Thank you for your business!
        </div>
    </div>
</body>
</html>
