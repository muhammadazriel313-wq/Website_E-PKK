{{-- 6 sel data Perencanaan Sehat (kolom 19-24 Buku 4) untuk satu baris laporan: $item
     J_Psubur = PUS, J_Wsubur = WUS, Kb_p = Akseptor KB L, Kb_w = Akseptor KB P --}}
<td class="k-angka">{{ $item->J_Psubur ?? 0 }}</td>
<td class="k-angka">{{ $item->J_Wsubur ?? 0 }}</td>
<td class="k-angka">{{ $item->Kb_p ?? 0 }}</td>
<td class="k-angka">{{ $item->Kb_w ?? 0 }}</td>
<td class="k-angka">{{ $item->Kk_tbg ?? 0 }}</td>
<td class="k-angka">{{ $item->Kk_asuransi ?? 0 }}</td>