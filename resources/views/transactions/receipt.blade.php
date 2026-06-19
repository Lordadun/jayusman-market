<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <title>Struk {{ $transaction->invoice_number }}</title>
 <style>
 body {
 font-family: Arial, sans-serif;
 width: 320px;
 margin: 20px auto;
font-size: 13px;
 color: #000;
 }
 .center {
 text-align: center;
 }
 .line {
 border-top: 1px dashed #000;
 margin: 10px 0;
 }
 table {
 width: 100%;
 border-collapse: collapse;
 }
 td {
 padding: 3px 0;
 vertical-align: top;
 }
 .right {
 text-align: right;
 }
 .bold {
 font-weight: bold;
 }
 .small {
 font-size: 12px;
 }
 @media print {
 body {
 margin: 0 auto;
 }
 button {
 display: none;
 }
 }
</style>
</head>
<body onload="window.print()">
 <div class="center">
 <h3 style="margin-bottom: 4px;">
 {{ $transaction->branch->name ?? 'Jayusman Mart' }}
 </h3>
 <div class="small">
 {{ $transaction->branch->address ?? '-' }}
 </div>
 <div class="small">
 Telp: {{ $transaction->branch->phone ?? '-' }}
 </div>
 </div>
 <div class="line"></div>
 <table>
 <tr>
 <td>Invoice</td>
 <td class="right">{{ $transaction->invoice_number }}</td>
 </tr>
 <tr>
 <td>Kasir</td>
 <td class="right">{{ $transaction->cashier->name ?? '-' }}</td>
 </tr>
 <tr>
 <td>Tanggal</td>
 <td class="right">{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
 </tr>
 </table>
 <div class="line"></div>
 <table>
 @foreach($transaction->details as $detail)
 <tr>
 <td colspan="2" class="bold">
 {{ $detail->product->name ?? '-' }}
 </td>
</tr>
 <tr>
 <td>
 {{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}
 </td>
 <td class="right">
 Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
 </td>
 </tr>
 @endforeach
 </table>
 <div class="line"></div>
 <table>
 <tr>
 <td class="bold">Total</td>
 <td class="right bold">
 Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
 </td>
 </tr>
 <tr>
 <td>Bayar</td>
 <td class="right">
 Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}
 </td>
 </tr>
 <tr>
 <td>Kembali</td>
 <td class="right">
 Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
 </td>
 </tr>
 </table>
 <div class="line"></div>
 <div class="center small">
 <p>Terima kasih sudah berbelanja</p>
 <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
 <p>Jayusman Mart</p>
</div>
</body>
</html>