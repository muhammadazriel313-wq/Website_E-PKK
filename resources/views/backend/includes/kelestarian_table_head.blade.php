{{-- Header tabel Kelestarian Lingkungan Hidup sesuai Buku 4 Pokja IV (kolom 12-18).
     Parameter opsional:
       $extra   = kolom tambahan di kanan, mis. ['Catatan','Status','Tanggal','Aksi']
       $showKec = true/false, default: true jika login sebagai kabupaten (guard web) --}}
@php
  $extra   = $extra ?? [];
  $showKec = $showKec ?? Auth::guard('web')->check();
@endphp
<thead>
  <tr>
    <th rowspan="3" class="k-no">No</th>
    @if ($showKec)
      <th rowspan="3" class="k-wil">Kecamatan</th>
      <th rowspan="3" class="k-wil">Desa</th>
    @else
      <th rowspan="3" class="k-wil">Desa</th>
    @endif
    <th colspan="7" class="k-main">Kelestarian Lingkungan Hidup</th>
    @foreach ($extra as $label)
      <th rowspan="3" class="k-extra">{{ $label }}</th>
    @endforeach
  </tr>
  <tr>
    <th colspan="3" class="k-group">Jumlah Rumah yang Memiliki</th>
    <th rowspan="2" class="k-solo">Jumlah MCK</th>
    <th colspan="3" class="k-group">Jumlah KRT yang Menggunakan Air</th>
  </tr>
  <tr>
    <th class="k-leaf">Jamban (WC)</th>
    <th class="k-leaf">SPAL</th>
    <th class="k-leaf">TPS</th>
    <th class="k-leaf">PDAM</th>
    <th class="k-leaf">Sumur</th>
    <th class="k-leaf">Lain-lain</th>
  </tr>
  {{-- Baris nomor kolom Buku 4: 1, 2, lalu 12 sampai 18 --}}
  <tr class="k-num">
    <th>1</th>
    <th @if ($showKec) colspan="2" @endif>2</th>
    @for ($i = 12; $i <= 18; $i++)
      <th>{{ $i }}</th>
    @endfor
    @foreach ($extra as $label)
      <th>-</th>
    @endforeach
  </tr>
</thead>
