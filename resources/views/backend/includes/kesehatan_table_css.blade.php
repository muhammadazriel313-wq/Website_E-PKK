{{-- Gaya tabel Pokja IV (Buku 4): Kesehatan & Kelestarian - pastel, senada tema E-PKK (#016AA3) --}}
@once
<style>
  .tbl-kes-wrap { overflow-x: auto; border-radius: 14px; border: 1px solid #c5dff0; background: #fff; box-shadow: 0 6px 20px rgba(1,106,163,.08); }
  .tbl-kes-wrap::-webkit-scrollbar { height: 8px; }
  .tbl-kes-wrap::-webkit-scrollbar-track { background: #eef6fb; border-radius: 10px; }
  .tbl-kes-wrap::-webkit-scrollbar-thumb { background: #a9d6ee; border-radius: 10px; }

  table.tbl-kes { border-collapse: collapse; width: 100%; min-width: 1100px; margin: 0 !important; font-size: 13px; color: #35566b; }
  table.tbl-kes th, table.tbl-kes td { border: 1px solid #c5dff0; }

  /* ---------- HEADER: semua tulisan HORIZONTAL (di Buku 4 aslinya vertikal) ---------- */
  table.tbl-kes thead th {
    writing-mode: horizontal-tb !important; text-orientation: mixed !important; transform: none !important;
    white-space: normal; text-transform: none; letter-spacing: .2px; text-align: center; vertical-align: middle;
    padding: 10px 12px; font-size: 12.5px; font-weight: 600; line-height: 1.3; color: #0b4a6b; position: static;
  }
  table.tbl-kes thead th.k-no,
  table.tbl-kes thead th.k-wil   { background: #d4e9f7; min-width: 90px; }
  table.tbl-kes thead th.k-main  { background: #a9d6ee; color: #08425f; font-size: 14px; letter-spacing: 1.5px; text-transform: uppercase; }
  table.tbl-kes thead th.k-group { background: #c4e4f5; }
  table.tbl-kes thead th.k-leaf  { background: #e1f1fa; min-width: 84px; }
  table.tbl-kes thead th.k-solo  { background: #d6ecf8; min-width: 96px; }
  table.tbl-kes thead th.k-extra { background: #e6eef5; min-width: 100px; }
  table.tbl-kes thead tr.k-num th { background: #f1f7fb; color: #6b8aa0; font-size: 11px; font-weight: 500; padding: 4px 6px; }

  /* ---------- BODY ---------- */
  table.tbl-kes tbody td { padding: 10px 12px; text-align: center; vertical-align: middle; background: #fff; }
  table.tbl-kes tbody tr:nth-child(even) td { background: #f6fbfe; }
  table.tbl-kes tbody tr:hover td { background: #e8f4fb; }
  table.tbl-kes tbody td.k-angka { font-variant-numeric: tabular-nums; font-weight: 600; color: #0b4a6b; }
  table.tbl-kes tbody td.k-teks { text-align: left; }
  table.tbl-kes tfoot td { background: #d4e9f7 !important; color: #08425f; font-weight: 700; padding: 10px 12px; text-align: center; }

  @media print {
    table.tbl-kes, table.tbl-kes * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .tbl-kes-wrap { box-shadow: none; border-radius: 0; overflow: visible; }
    table.tbl-kes { min-width: 0; font-size: 10px; }
    table.tbl-kes th, table.tbl-kes td { border-color: #7fa9c4; padding: 4px 5px !important; }
  }
</style>
@endonce
