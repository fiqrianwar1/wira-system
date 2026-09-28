<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('spareparts.stocks.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="py-1">
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    {{ __('✏️ Revisi Data Stok') }}
                </h2>
                <p class="text-sm text-gray-500 font-bold mt-1">
                    Logistik / <span class="text-amber-600 uppercase tracking-wider">Update Rak & Harga</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-[85rem] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-gray-200/40 sm:rounded-[2rem] border border-gray-100">
                
                {{-- HEADER EDIT MODE --}}
                <div class="bg-amber-400 px-6 py-6 relative overflow-hidden flex items-center gap-4 shadow-sm">
                    <div class="absolute top-0 right-0 w-64 h-full bg-yellow-300 skew-x-12 -mr-32 opacity-30"></div>
                    <div class="bg-amber-600 p-3 rounded-2xl text-white shadow-inner border border-amber-500 relative z-10">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-amber-900 tracking-tight">MODE REVISI DATA</h3>
                        <p class="text-amber-800 text-[11px] font-bold uppercase tracking-widest mt-0.5">Kelompok Item: {{ $panelName }}</p>
                    </div>
                </div>

                <form action="{{ route('spareparts.stocks.update') }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-xl mb-6 shadow-sm">
                            <p class="font-black text-xs uppercase tracking-widest mb-1.5">Data Gagal Disimpan!</p>
                            <ul class="list-disc pl-5 text-sm font-bold opacity-90">
                                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- TABEL EDIT LIST --}}
                    <div class="overflow-x-auto rounded-[1.5rem] border border-gray-100 shadow-sm mb-6">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-400 text-[11px] font-black uppercase tracking-widest border-b border-gray-100">
                                <tr>
                                    <th class="px-4 py-4 w-12 text-center">#</th>
                                    <th class="px-4 py-4">Detail Item</th>
                                    <th class="px-4 py-4">Sumber</th>
                                    <th class="px-4 py-4 w-32 sm:w-40">Lokasi Rak</th>
                                    <th class="px-4 py-4 w-36 sm:w-48 text-right">Harga (Rp)</th>
                                    <th class="px-4 py-4 w-36 sm:w-40 text-center">Tgl (ETA)</th>
                                    <th class="px-4 py-4 w-16 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 bg-white">
                                @foreach($items as $index => $item)
                                    <tr class="hover:bg-amber-50/30 transition-colors">
                                        <td class="px-4 py-3 text-center align-middle">
                                            <input type="hidden" name="ids[]" value="{{ $item->id }}">
                                            <div class="bg-gray-100 text-gray-500 font-black text-xs w-7 h-7 inline-flex items-center justify-center rounded-md">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <p class="font-black text-gray-800 text-sm">{{ $item->panel_name }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mt-0.5">ID: #{{ $item->id }}</p>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span class="text-[10px] font-bold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1.5 rounded truncate max-w-[120px] inline-block" title="{{ $item->kerusakan }}">
                                                {{ $item->kerusakan ?? 'Stok Umum' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="locations[]" value="{{ $item->part_location }}" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 p-2.5 font-bold shadow-sm transition-colors" required>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <div class="relative">
                                                <span class="absolute left-3 top-2.5 text-[11px] font-black text-gray-400">Rp</span>
                                                <input type="number" name="prices[]" value="{{ $item->harga }}" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 p-2.5 pl-8 font-mono font-bold shadow-sm transition-colors text-right" required>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="date" name="etadates[]" value="{{ \Carbon\Carbon::parse($item->part_eta)->format('Y-m-d') }}" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 p-2.5 font-bold shadow-sm transition-colors cursor-pointer" required>
                                        </td>
                                        <td class="px-4 py-3 text-center align-middle">
                                            <button type="button" onclick="confirmDelete('{{ route('spareparts.stocks.destroy', $item->id) }}')" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-xl transition-all" title="Hapus">
                                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 gap-3">
                        <a href="{{ route('spareparts.stocks.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all text-xs uppercase tracking-widest">
                            Batal
                        </a>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-black py-3 px-8 rounded-xl shadow-lg shadow-amber-500/30 transform transition hover:-translate-y-0.5 flex items-center gap-2 text-xs uppercase tracking-widest">
                            Simpan Perubahan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(url) {
            if (confirm('Yakin mau hapus barang ini dari rak gudang bro? Data bakal hilang lho.')) {
                let form = document.getElementById('delete-form');
                form.action = url;
                form.submit();
            }
        }
    </script>
</x-app-layout>