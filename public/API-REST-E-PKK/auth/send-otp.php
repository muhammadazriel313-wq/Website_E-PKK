<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['otp']) || !isset($data['phone'])) {
    echo json_encode([
        'success' => false,
        'message' => 'OTP atau nomor HP tidak ditemukan.',
    ]);
    exit;
}

$token = "4mQ9kBGudtLxTPQYPAKT"; // token dari device kamu
$noHp = $data['phone'];
$kodeOtp = $data['otp'];

if (str_starts_with($noHp, '0')) {
    $noHp = '62' . substr($noHp, 1); // ubah 081xxx ke 6281xxx
}

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => [
        'target' => $noHp,
        'message' => "Kode verifikasi E-PKK Anda adalah: *$kodeOtp*"
    ],
    CURLOPT_HTTPHEADER => [
        "Authorization: $token"
    ],
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo json_encode([
        'success' => false,
        'message' => 'Curl error: ' . curl_error($curl),
    ]);
    curl_close($curl);
    exit;
}

curl_close($curl);

echo json_encode([
    'success' => true,
    'response' => json_decode($response, true),
]);
