<?php
/** Image upload endpoint — returns JSON. Used by the shared image modal. */
header('Content-Type: application/json');

$fail = function (string $msg) { echo json_encode(['ok' => false, 'error' => $msg]); exit; };

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST' || empty($_FILES['file'])) {
    $fail('No file received.');
}
$f = $_FILES['file'];
if ($f['error'] !== UPLOAD_ERR_OK) {
    $fail($f['error'] === UPLOAD_ERR_INI_SIZE || $f['error'] === UPLOAD_ERR_FORM_SIZE
        ? 'That file is too large.' : 'Upload failed, please try again.');
}
if ($f['size'] > 4 * 1024 * 1024) {
    $fail('Please keep images under 4 MB.');
}

// Validate by actually reading the image (no finfo/GD dependency).
$info = @getimagesize($f['tmp_name']);
$map  = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
if (!$info || !isset($map[$info[2]])) {
    $fail('Only JPG, PNG or WebP images are allowed.');
}
$ext = $map[$info[2]];

$dir = ROOT_PATH . '/public/assets/img/uploads';
if (!is_dir($dir) && !@mkdir($dir, 0775, true)) {
    $fail('Upload folder is not available.');
}
$name = date('Ymd') . '-' . bin2hex(random_bytes(6)) . '.' . $ext;
if (!move_uploaded_file($f['tmp_name'], $dir . '/' . $name)) {
    $fail('Could not save the file (folder permissions?).');
}

$rel = 'assets/img/uploads/' . $name;
echo json_encode(['ok' => true, 'path' => $rel, 'url' => url($rel)]);
