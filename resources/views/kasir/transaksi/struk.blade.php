@extends('templates.header.kasir')

@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden !important;
            }

            #struk,
            #struk * {
                visibility: visible !important;
            }

            #struk {
                position: absolute !important;
                left: 0;
                top: 0;
                width: 58mm;
                max-width: 100%;
                margin: 0 auto;
                box-shadow: none !important;
                border: none !important;
            }

            .no-print,
            header,
            nav,
            .sidebar {
                display: none !important;
            }

            .print-wrapper {
                all: unset !important;
                /* hilangin flex & min-h-screen */
            }

            @page {
                size: 58mm auto;
                margin: 0;
            }
        }
    </style>

    <div class="print-wrapper flex items-center justify-center min-h-screen bg-gray-50">
        <div id="struk" class="bg-white p-2 text-[11px] font-mono text-gray-800 w-[58mm]">
            <div class="text-center mb-1">
                <h2 class="text-base font-bold uppercase">Nama Toko</h2>
                <p class="text-[10px] text-gray-500">Jl. Contoh No. 123, Kota</p>
            </div>

            <p class="text-[10px] text-left mb-1">Tanggal: {{ $pesanan->created_at->format('Y-m-d H:i') }}</p>

            <table class="w-full text-left text-[10px] mb-2">
                <thead>
                    <tr>
                        <th class="border-b py-1">Menu</th>
                        <th class="border-b py-1 text-center">Qty</th>
                        <th class="border-b py-1 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanan->details as $detail)
                        <tr>
                            <td class="py-0.5">{{ $detail->menu->menu }}</td>
                            <td class="py-0.5 text-center">{{ $detail->qty }}</td>
                            <td class="py-0.5 text-right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-left space-y-0.5 mt-2 text-[10px]">
                <p>Total: <span class="font-semibold">Rp{{ number_format(request('total'), 0, ',', '.') }}</span></p>
                <p>Bayar: <span class="font-semibold">Rp{{ number_format(request('bayar'), 0, ',', '.') }}</span></p>
                <p>Kembalian: <span class="font-semibold">Rp{{ number_format(request('kembalian'), 0, ',', '.') }}</span>
                </p>
            </div>

            @if (!request()->has('auto_print'))
                <button onclick="printStruk()"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded mt-2 w-full text-[11px] no-print">
                    Print Struk
                </button>
            @endif
        </div>
    </div>

    @if (request()->has('auto_print'))
        <script>
            window.onload = () => {
                window.print();
                setTimeout(() => {
                    window.location.href = "{{ route('transaksi') }}";
                }, 3000);
            }
        </script>
    @else
        <script>
            function printStruk() {
                window.print();
            }
        </script>
    @endif

@endsection