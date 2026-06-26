<?php
/**
 * Utility — resolve a (possibly shortened) Google Maps URL and return the
 * final destination URL so the client-side JS can extract coordinates from it.
 *
 * GET /admin/util/resolve-url?url=<encoded-url>
 * Returns JSON: { "resolved": "https://..." }  or  { "error": "..." }
 *
 * Only allows Google Maps domains to prevent this becoming an open proxy.
 */

$allowed_hosts = [
    'maps.app.goo.gl',
    'goo.gl',
    'maps.google.com',
    'www.google.com',
    'google.com',
];

header('Content-Type: application/json');

$url = trim($_GET['url'] ?? '');
if (!$url) {
    echo json_encode(['error' => 'No URL provided.']);
    exit;
}

$host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
if (!in_array($host, $allowed_hosts, true)) {
    echo json_encode(['error' => 'URL is not a recognised Google Maps domain.']);
    exit;
}

// Follow up to 5 redirect hops and return the final URL.
if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_NOBODY         => true,   // HEAD only — no body needed
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; EclatAdmin/1.0)',
    ]);
    curl_exec($ch);
    $err      = curl_errno($ch);
    $resolved = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);

    if ($err || !$resolved) {
        echo json_encode(['error' => 'Could not reach that URL.']);
        exit;
    }
} else {
    // Fallback: stream-context HEAD with follow_location.
    $context = stream_context_create([
        'http' => [
            'method'          => 'HEAD',
            'follow_location' => 1,
            'max_redirects'   => 5,
            'timeout'         => 5,
            'ignore_errors'   => true,
            'header'          => "User-Agent: Mozilla/5.0 (compatible; EclatAdmin/1.0)\r\n",
        ],
    ]);
    $headers = @get_headers($url, true, $context);
    if ($headers === false) {
        echo json_encode(['error' => 'Could not reach that URL. Check outbound HTTP access.']);
        exit;
    }
    // get_headers() with follow_location gives us the final response headers,
    // but doesn't expose the final URL directly.  Reconstruct from Location chain.
    $loc = $headers['Location'] ?? $headers['location'] ?? null;
    if (is_array($loc)) {
        $resolved = end($loc);
    } elseif ($loc) {
        $resolved = $loc;
    } else {
        $resolved = $url; // already the final URL, no redirect occurred
    }
}

echo json_encode(['resolved' => $resolved]);
