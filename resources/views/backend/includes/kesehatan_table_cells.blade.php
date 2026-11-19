{{-- 9 sel data Kesehatan (kolom 3-11 Buku 4) untuk satu baris laporan: $item --}}
<td class="k-angka">{{ $item->kader_kesehatan ?? 0 }}</td>
<td class="k-angka">{{ $item->kader_gizi ?? 0 }}</td>
<td class="k-angka">{{ $item->kader_kesling ?? 0 }}</td>
<td class="k-angka">{{ $item->kader_phbs ?? 0 }}</td>
<td class="k-angka">{{ $item->kader_kb ?? 0 }}</td>
<td class="k-angka">{{ $item->posyandu ?? 0 }}</td>
<td class="k-angka">{{ $item->imunisasi_vaksinasi ?? 0 }}</td>
<td class="k-angka">{{ $item->pkg ?? 0 }}</td>
<td class="k-angka">{{ $item->tbc ?? 0 }}</td>
