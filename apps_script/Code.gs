/**
 * =========================================================================
 * GOOGLE APPS SCRIPT - EKSPOR LAPORAN E-PKK KE GOOGLE SHEETS
 * Tanggal Pembuatan : 09-10-2026
 * Deskripsi        : Menerima payload data JSON dari Web E-PKK, membuat/memakai
 *                    tab berdasarkan Pokja & Bidang, serta menimpa (overwrite)
 *                    data pada periode yang sama (bulan & tahun) agar tidak ganda.
 * =========================================================================
 */

function doPost(e) {
  try {
    // 1. Validasi penerimaan data dari permintaan POST
    if (!e) {
      throw new Error("Objek event permintaan tidak ditemukan.");
    }

    var rawContent = "";
    if (e.postData && e.postData.contents) {
      rawContent = e.postData.contents;
    } else if (e.parameter && e.parameter.data) {
      rawContent = e.parameter.data;
    } else {
      throw new Error("Data payload kosong (tidak ada postData atau parameter data).");
    }

    // 2. Parsing JSON payload
    var payload;
    try {
      payload = JSON.parse(rawContent);
    } catch (parseError) {
      // Cadangan: jika data dikirim sebagai form-urlencoded yang ter-escape
      if (e.parameter && e.parameter.data) {
        payload = JSON.parse(e.parameter.data);
      } else {
        throw new Error("Gagal membaca payload JSON: " + parseError.message);
      }
    }

    // Validasi baris data
    var dataRows = payload.data;
    if (!dataRows || !Array.isArray(dataRows) || dataRows.length === 0) {
      return createJsonResponse("empty", "Tidak ada baris data yang dikirim untuk diekspor.");
    }

    // 3. Menentukan Nama Tab / Sheet berdasarkan Pokja & Bidang
    var sheetName = tentukanNamaSheet(payload);

    // 4. Membuka spreadsheet aktif dan mengambil / membuat sheet yang sesuai
    var ss = SpreadsheetApp.getActiveSpreadsheet();
    var sheet = ss.getSheetByName(sheetName);
    if (!sheet) {
      sheet = ss.insertSheet(sheetName);
    }

    // 5. Menentukan Periode Ekspor (Bulan dan Tahun)
    var periodeInfo = tentukanPeriode(payload, dataRows);

    // 6. Menyusun Header dan Kolom
    var headers = Object.keys(dataRows[0]);
    
    // Pastikan header 'Periode' tersedia untuk pelacakan jika belum ada
    var periodeColIndex = -1;
    for (var h = 0; h < headers.length; h++) {
      if (headers[h].toLowerCase() === 'periode') {
        periodeColIndex = h;
        break;
      }
    }

    var includePeriodeCol = false;
    if (periodeColIndex === -1 && periodeInfo.label !== "") {
      includePeriodeCol = true;
      headers.push("Periode");
      periodeColIndex = headers.length - 1;
    }

    // 7. Membaca data yang sudah ada di sheet (jika ada) untuk deduplikasi periode
    var lastRow = sheet.getLastRow();
    var existingRows = [];
    var existingHeaders = [];

    if (lastRow > 1) {
      var lastCol = sheet.getLastColumn();
      var sheetValues = sheet.getRange(1, 1, lastRow, lastCol).getValues();
      existingHeaders = sheetValues[0];
      
      // Temukan index kolom periode atau tanggal pada sheet lama
      var existingPeriodeIdx = -1;
      var existingTanggalIdx = -1;
      for (var eh = 0; eh < existingHeaders.length; eh++) {
        var colName = String(existingHeaders[eh]).toLowerCase();
        if (colName === 'periode') existingPeriodeIdx = eh;
        if (colName === 'tanggal' || colName === 'tanggal laporan') existingTanggalIdx = eh;
      }

      for (var r = 1; r < sheetValues.length; r++) {
        var rowData = sheetValues[r];
        var rowPeriode = "";

        if (existingPeriodeIdx !== -1 && rowData[existingPeriodeIdx]) {
          rowPeriode = String(rowData[existingPeriodeIdx]).trim();
        } else if (existingTanggalIdx !== -1 && rowData[existingTanggalIdx]) {
          rowPeriode = ekstrakPeriodeDariString(String(rowData[existingTanggalIdx]));
        }

        // Jika baris ini bukan dari periode yang sedang diimpor, simpan (jangan ditimpa)
        if (!apakahSatuPeriode(rowPeriode, periodeInfo)) {
          existingRows.push(rowData);
        }
      }
    }

    // 8. Menyiapkan baris data baru dalam bentuk Array 2D
    var newRows = [];
    for (var i = 0; i < dataRows.length; i++) {
      var item = dataRows[i];
      var row = [];
      for (var c = 0; c < headers.length; c++) {
        var colKey = headers[c];
        if (colKey === "Periode" && includePeriodeCol) {
          row.push(periodeInfo.label);
        } else {
          var val = item[colKey];
          row.push(val !== undefined && val !== null ? val : "");
        }
      }
      newRows.push(row);
    }

    // Gabungkan data lama yang tidak tertimpa + data baru
    var combinedData = existingRows.concat(newRows);

    // Nomor urut ulang (jika ada kolom 'No')
    var noColIdx = -1;
    for (var n = 0; n < headers.length; n++) {
      if (headers[n].toLowerCase() === 'no') {
        noColIdx = n;
        break;
      }
    }
    if (noColIdx !== -1) {
      for (var idx = 0; idx < combinedData.length; idx++) {
        combinedData[idx][noColIdx] = idx + 1;
      }
    }

    // 9. Menulis data ke Sheet
    sheet.clearContents();

    // Tulis Header
    sheet.getRange(1, 1, 1, headers.length).setValues([headers]);
    
    // Format Header (Warna Biru Resmi PKK, Teks Tebal Putih)
    var headerRange = sheet.getRange(1, 1, 1, headers.length);
    headerRange.setFontWeight("bold");
    headerRange.setBackground("#0d6efd");
    headerRange.setFontColor("#ffffff");
    headerRange.setHorizontalAlignment("center");

    // Tulis Data jika ada
    if (combinedData.length > 0) {
      sheet.getRange(2, 1, combinedData.length, headers.length).setValues(combinedData);
    }

    // Freeze baris header pertama agar rapi saat di-scroll
    sheet.setFrozenRows(1);

    // Atur lebar kolom otomatis
    var totalCols = Math.min(headers.length, 30);
    for (var col = 1; col <= totalCols; col++) {
      sheet.autoResizeColumn(col);
    }

    // Dapatkan URL langsung ke tab yang sedang diproses menggunakan parameter #gid
    var sheetId = sheet.getSheetId();
    var tabUrl = ss.getUrl() + "#gid=" + sheetId;

    return createJsonResponse("success", "Data berhasil diekspor ke tab '" + sheetName + "' (" + dataRows.length + " baris diperbarui).", tabUrl, sheetId);

  } catch (error) {
    return createJsonResponse("error", "Terjadi kesalahan di Apps Script: " + error.message);
  }
}

/**
 * Fungsi pembantu untuk membuat response JSON ContentService (mendukung tautan langsung tab)
 */
function createJsonResponse(status, message, tabUrl, sheetId) {
  var output = {
    status: status,
    message: message,
    tab_url: tabUrl || "",
    sheet_id: sheetId !== undefined && sheetId !== null ? sheetId : null,
    timestamp: new Date().toISOString()
  };
  return ContentService.createTextOutput(JSON.stringify(output))
    .setMimeType(ContentService.MimeType.JSON);
}

/**
 * Menentukan nama tab spreadsheet yang ramah, ringkas, dan bebas karakter terlarang
 */
function tentukanNamaSheet(payload) {
  var pokja = (payload.pokja || "").toString().trim().toUpperCase();
  var bidang = (payload.bidang || "").toString().trim().toUpperCase();
  var subBidang = (payload.sub_bidang || "").toString().trim().toUpperCase();

  // Jika pokja belum dikirim, deteksi dari nama bidang
  if (!pokja) {
    if (bidang.indexOf("PENGHAYATAN") !== -1 || bidang.indexOf("GOTONG") !== -1) pokja = "POKJA 1";
    else if (bidang.indexOf("PENDIDIKAN") !== -1 || bidang.indexOf("PENGEMBANGAN") !== -1) pokja = "POKJA 2";
    else if (bidang.indexOf("PANGAN") !== -1 || bidang.indexOf("SANDANG") !== -1 || bidang.indexOf("PERUMAHAN") !== -1) pokja = "POKJA 3";
    else if (bidang.indexOf("KESEHATAN") !== -1 || bidang.indexOf("KELESTARIAN") !== -1 || bidang.indexOf("PERENCANAAN") !== -1 || bidang.indexOf("INOVASI") !== -1) pokja = "POKJA 4";
    else if (bidang.indexOf("UMUM") !== -1) pokja = "BIDANG UMUM";
    else pokja = "LAPORAN";
  }

  var name = "";
  if (pokja === "BIDANG UMUM") {
    name = "BIDANG UMUM";
  } else if (bidang && bidang !== "SEMUA") {
    name = pokja + " - " + bidang;
    if (subBidang && subBidang !== "SEMUA") {
      name += " (" + subBidang + ")";
    }
  } else {
    name = pokja;
  }

  // Karakter terlarang di Google Sheets: \ / ? * : [ ]
  name = name.replace(/[\\\/\?\*\:\[\]]/g, "-").replace(/\s+/g, " ").trim();
  if (name.length > 95) {
    name = name.substring(0, 95);
  }
  return name || "Laporan_PKK";
}

/**
 * Menentukan periode bulan & tahun dari payload atau baris data
 */
function tentukanPeriode(payload, dataRows) {
  var bulan = payload.bulan !== undefined && payload.bulan !== null ? String(payload.bulan).trim() : "";
  var tahun = payload.tahun !== undefined && payload.tahun !== null ? String(payload.tahun).trim() : "";

  // Jika payload belum memuat periode, cek dari kolom baris pertama
  if ((!bulan || !tahun) && dataRows && dataRows.length > 0) {
    var first = dataRows[0];
    var dateVal = first["Tanggal Laporan"] || first["Tanggal"] || first["created_at"];
    if (dateVal) {
      var parsed = ekstrakPeriodeObjek(String(dateVal));
      if (!bulan && parsed.bulan) bulan = parsed.bulan;
      if (!tahun && parsed.tahun) tahun = parsed.tahun;
    }
  }

  var label = "";
  if (bulan && tahun) {
    label = padZero(bulan) + "-" + tahun;
  } else if (tahun) {
    label = tahun;
  }

  return {
    bulan: bulan ? padZero(bulan) : "",
    tahun: tahun,
    label: label
  };
}

/**
 * Mengekstrak bulan dan tahun dari string tanggal (DD-MM-YYYY atau YYYY-MM-DD)
 */
function ekstrakPeriodeObjek(dateStr) {
  if (!dateStr) return { bulan: "", tahun: "" };
  // Format DD-MM-YYYY
  var match1 = dateStr.match(/(\d{1,2})-(\d{1,2})-(\d{4})/);
  if (match1) {
    return { bulan: padZero(match1[2]), tahun: match1[3] };
  }
  // Format YYYY-MM-DD
  var match2 = dateStr.match(/(\d{4})-(\d{1,2})-(\d{1,2})/);
  if (match2) {
    return { bulan: padZero(match2[2]), tahun: match2[1] };
  }
  return { bulan: "", tahun: "" };
}

function ekstrakPeriodeDariString(dateStr) {
  var obj = ekstrakPeriodeObjek(dateStr);
  if (obj.bulan && obj.tahun) return obj.bulan + "-" + obj.tahun;
  if (obj.tahun) return obj.tahun;
  return "";
}

/**
 * Memeriksa apakah baris lama memiliki periode yang sama dengan yang sedang diekspor
 */
function apakahSatuPeriode(rowPeriodeStr, targetPeriode) {
  if (!rowPeriodeStr || !targetPeriode.label) return false;
  rowPeriodeStr = rowPeriodeStr.trim();
  
  // Jika target periode memiliki bulan & tahun (misal: "10-2026")
  if (targetPeriode.bulan && targetPeriode.tahun) {
    return rowPeriodeStr === targetPeriode.label;
  }
  
  // Jika target periode hanya tahun (misal: "2026")
  if (targetPeriode.tahun) {
    return rowPeriodeStr === targetPeriode.tahun || rowPeriodeStr.endsWith("-" + targetPeriode.tahun);
  }

  return false;
}

function padZero(val) {
  var s = String(val);
  return s.length === 1 ? "0" + s : s;
}

/**
 * Fungsi pengujian sederhana untuk memeriksa ketersediaan doPost via browser
 */
function doGet() {
  return createJsonResponse("success", "Layanan Web App Google Apps Script E-PKK aktif dan siap menerima data POST.");
}
