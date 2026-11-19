{{-- Header tabel Perencanaan Sehat sesuai Buku 4 Pokja IV (kolom 19-24).
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
    <th colspan="6" class="k-main">Perencanaan Sehat</th>
    @foreach ($extra as $label)
      <th rowspan="3" class="k-extra">{{ $label }}</th>
    @endforeach
  </tr>
  <tr>
    <th rowspan="2" class="k-solo" title="Pasangan Usia Subur">Jml PUS</th>
    <th rowspan="2" class="k-solo" title="Wanita Usia Subur">Jml WUS</th>
    <th colspan="2" class="k-group">Jml Akseptor KB</th>
    <th rowspan="2" class="k-solo">Jml KK yang Memiliki<br>Tabungan Keluarga</th>
    <th rowspan="2" class="k-solo">Jml KK yang Memiliki<br>Asuransi Kesehatan</th>
  </tr>
  <tr>
    <th class="k-leaf" title="Laki-laki">L</th>
    <th class="k-leaf" title="Perempuan">P</th>
  </tr>
  {{-- Baris nomor kolom Buku 4: 1, 2, lalu 19 sampai 24 --}}
  <tr class="k-num">
    <th>1</th>
    <th @if ($showKec) colspan="2" @endif>2</th>
    @for ($i = 19; $i <= 24; $i++)
      <th>{{ $i }}</th>
    @endfor
    @foreach ($extra as $label)
      <th>-</th>
    @endforeach
  </tr>
</thead>