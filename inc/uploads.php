<?php

/**
 * Armazena uma imagem enviada pelo formulário usando uma extensão definida
 * pelo MIME real do arquivo, nunca pelo nome fornecido pelo cliente.
 */
function store_image_upload(?array $file, string $prefix = 'img_'): ?string
{
    if ($file === null || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK || empty($file['tmp_name']) ||
        !is_uploaded_file($file['tmp_name'])) {
        throw new RuntimeException('O arquivo enviado é inválido.');
    }

    $maxBytes = 5 * 1024 * 1024;
    if (($file['size'] ?? 0) > $maxBytes) {
        throw new RuntimeException('Cada imagem deve ter no máximo 5 MB.');
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp'
    ];

    if (!isset($allowedMimes[$mime]) || @getimagesize($file['tmp_name']) === false) {
        throw new RuntimeException('Envie uma imagem JPG, PNG, GIF ou WEBP válida.');
    }

    $uploadDir = ABSPATH . 'img' . DIRECTORY_SEPARATOR . 'produtos' . DIRECTORY_SEPARATOR;
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
        throw new RuntimeException('Não foi possível preparar o diretório de imagens.');
    }

    $safePrefix = preg_replace('/[^a-z0-9_-]/i', '', $prefix) ?: 'img_';
    $filename = $safePrefix . bin2hex(random_bytes(16)) . '.' . $allowedMimes[$mime];
    $destination = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Não foi possível salvar a imagem enviada.');
    }

    return 'img/produtos/' . $filename;
}

/** Processa o campo galeria[] no formato usado pelo PHP. */
function store_multiple_image_uploads(?array $files, string $prefix = 'gal_'): array
{
    if ($files === null || !isset($files['name']) || !is_array($files['name'])) {
        return [];
    }

    $stored = [];
    foreach ($files['name'] as $index => $_name) {
        $entry = [
            'name' => $files['name'][$index] ?? '',
            'type' => $files['type'][$index] ?? '',
            'tmp_name' => $files['tmp_name'][$index] ?? '',
            'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
            'size' => $files['size'][$index] ?? 0
        ];

        if ($entry['error'] === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        $stored[] = store_image_upload($entry, $prefix);
    }

    return $stored;
}

/** Permite apenas caminhos locais de imagem, sem traversal ou atributos HTML. */
function normalize_image_path(?string $path): ?string
{
    $path = trim((string)$path);
    if ($path === '') {
        return null;
    }

    if (preg_match('/[\x00-\x1F]/', $path) ||
        strpos($path, '..') !== false ||
        !preg_match('#\Aimg/[A-Za-z0-9/_\-.]+\.(?:jpe?g|png|gif|webp)\z#i', $path)) {
        throw new InvalidArgumentException('Informe um caminho local de imagem válido.');
    }

    return $path;
}
