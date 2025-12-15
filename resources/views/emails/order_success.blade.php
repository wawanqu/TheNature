<h1>Halo {{ $order->user->name }}</h1>

<p>Pesananmu dengan kode <strong>{{ $order->kode_transaksi }}</strong> berhasil dibuat.</p>
<p>Total pembayaran: Rp {{ number_format($order->jumlah_pembayaran,0,',','.') }}</p>

<h3>Detail Produk:</h3>
<ul>
    @foreach($order->items as $item)
        <li>
            {{ $item->product_name }} x {{ $item->quantity }}
            (Rp {{ number_format($item->product_price,0,',','.') }})
        </li>
    @endforeach
</ul>

@if(!empty($order->notes))
    <p><strong>Catatan Pembeli:</strong> {{ $order->notes }}</p>
@endif

<p>Terima kasih sudah belanja di The Nature!</p>