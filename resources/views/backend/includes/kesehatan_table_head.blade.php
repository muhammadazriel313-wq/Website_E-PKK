{{-- Header tabel Kesehatan sesuai Buku 4 Pokja IV (kolom 1-11).
     Parameter opsional:
       $extra   = daftar judul kolom tambahan di kanan, mis. ['Catatan','Status','Tanggal','Aksi']
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
    <th colspan="9" class="k-main">Kesehatan</th>
    @foreach ($extra as $label)
      <th rowspan="3" class="k-extra">{{ $label }}</th>
    @endforeach
  </tr>
  <tr>
    <th colspan="5" class="k-group">Jumlah Kader</th>
    <th rowspan="2" class="k-solo">Posyandu</th>
    <th rowspan="2" class="k-solo">Imunisasi / Vaksinasi<br>Bayi / Balita</th>
    <th rowspan="2" class="k-solo">PKG</th>
    <th rowspan="2" class="k-solo">TBC</th>
  </tr>
  <tr>
    <th class="k-leaf">Kader<br>Kesehatan</th>
    <th class="k-leaf">Gizi</th>
    <th class="k-leaf">Kesling</th>
    <th class="k-leaf">PHBS</th>
    <th class="k-leaf">KB</th>
  </tr>
  {{-- Baris nomor kolom, seperti di Buku 4 --}}
  <tr class="k-num">
    <th>1</th>
    <th @if ($showKec) colspan="2" @endif>2</th>
    @for ($i = 3; $i <= 11; $i++)
      <th>{{ $i }}</th>
    @endfor
    @foreach ($extra as $label)
      <th>-</th>
    @endforeach
  </tr>
</thead>
