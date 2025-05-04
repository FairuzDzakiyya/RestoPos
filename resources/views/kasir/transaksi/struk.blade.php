@extends('templates.header.kasir')

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gray-100 print:bg-white print:min-h-0 print:block">
        <div id="struk" class="w-[58mm] bg-white p-2 text-[11px] font-mono text-gray-800 rounded print:w-full print:shadow-none print:border print:rounded-none">
            <div class="text-center mb-2 border-b border-dashed border-gray-400 pb-1">
                <h2 class="text-sm font-bold uppercase">Kares</h2>
                <p class="text-[10px] text-gray-500">Jl. Siliwangi No. 45</p>
            </div>

            <div class="mb-2 text-[10px] space-y-0.5 border-b border-dashed border-gray-400 pb-1">
                <p>Kode Pesanan: <span class="font-semibold">{{ $pesanan->kode_pesanan }}</span></p>
                <p>Kasir: <span class="font-semibold">{{ $pesanan->karyawan->name }}</span></p>
                <p>Tanggal: {{ $pesanan->created_at->format('Y-m-d H:i') }}</p>
            </div>

            <table class="w-full text-[10px] mb-2">
                <thead>
                    <tr>
                        <th class="border-b text-left py-1">Menu</th>
                        <th class="border-b text-center py-1">Qty</th>
                        <th class="border-b text-right py-1">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanan->details as $detail)
                        <tr>
                            <td class="py-0.5">
                                {{ $detail->menu->menu }}
                                @if ($detail->qty > 1)
                                    <div class="text-[9px] text-gray-500">Rp{{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }} x {{ $detail->qty }}</div>
                                @endif
                            </td>
                            <td class="py-0.5 text-center">{{ $detail->qty }}</td>
                            <td class="py-0.5 text-right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>                
            </table>

            <div class="text-[10px] mt-2 space-y-0.5 border-t border-dashed border-gray-400 pt-1">
                <p>Total: <span class="font-semibold">Rp{{ number_format(request('total'), 0, ',', '.') }}</span></p>
                <p>Dibayar: <span class="font-semibold">Rp{{ number_format(request('total') + request('kembalian'), 0, ',', '.') }}</span></p>
                <p>Kembalian: <span class="font-semibold">Rp{{ number_format(request('kembalian'), 0, ',', '.') }}</span></p>
            </div>

            <div class="text-[10px] mt-2 space-y-0.5 border-t border-dashed border-gray-400 pt-1">
                <p>Terima kasih telah berbelanja di Kares!</p>
            </div>

            @if (!request()->has('auto_print'))
                <button onclick="window.print()" class="mt-3 w-full bg-blue-600 text-white py-1 rounded text-[11px] hover:bg-blue-700 print:hidden">
                    Print Struk
                </button>
            @endif
        </div>
    </div>

    {{-- Sembunyikan header kasir saat print --}}
    <style>
        @media print {
            header, nav, footer, aside, .print\:hidden {
                display: none !important;
            }
        }
    </style>

    @if (request()->has('auto_print'))
        <script>
            window.onload = () => {
                setTimeout(() => {
                    window.print();
                    setTimeout(() => {
                        window.location.href = "{{ route('transaksi') }}";
                    }, 2000); // Delay redirect 2 detik setelah print
                }, 2000); // Delay print 2 detik
            }
        </script>
    @endif
@endsection