<?php
$token = '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'; // ⚠️ sem dej svůj token
$user = 'vmrosti';
$repo = 'BufetZastavka';
$branch = 'main'; // nebo jiná větev

$files = [
    'index.html',
    'export.html',
    'config.json',
    'update-config.php',
];

$successes = [];
$errors = [];

foreach ($files as $file) {
    $url = "https://api.github.com/repos/$user/$repo/contents/$file?ref=$branch";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "User-Agent: AutoUpdateScript"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $json = json_decode($response, true);
        $decoded = base64_decode($json['content']);

        $savePath = __DIR__ . DIRECTORY_SEPARATOR . $file;
        if (file_put_contents($savePath, $decoded) !== false) {
            $successes[] = $file;
        } else {
            $errors[] = "Nelze uložit $file";
        }
    } else {
        $errors[] = "Chyba při stahování $file (HTTP $httpCode)";
    }
}

if (!empty($successes)) {
    echo "✅ Aktualizováno: " . implode(', ', $successes);
}
if (!empty($errors)) {
    echo "\n❌ Chyby:\n" . implode("\n", $errors);
}
