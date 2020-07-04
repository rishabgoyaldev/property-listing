<?php
/**
 * Sanitizes data to remove special and html chars
 *
 * @param string $data Data to be sanitized
 *
 * @return string
 */
function sanitizeData(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Gets array of data and sanitizes each field in data
 *
 * @param array $data Array of data to be sanitized
 * @param array $ignoreFields Array of fields to be ignored while sanitizing
 *
 * @return array
 */
function sanitizeDataArray(array $data, array $ignoreFields = []): array {
    foreach ($data as $key => $value) {
        if (!in_array($key, $ignoreFields)) {
            $data[$key] = sanitizeData($value);
        }
    }

    return $data;
}

/**
 * Makes a get request using cURL
 *
 * @param string $url URL to which cURL request is to be made
 *
 * @return array
 */
function curlGetRequest(string $url): array {
    $request = curl_init();
    $headers = [
        'Accept: application/json',
        'Content-Type: application/json'
    ];
    curl_setopt($request, CURLOPT_URL, $url);
    curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($request, CURLOPT_HEADER, 0);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    $data = json_decode(curl_exec($request), true);
    curl_close($request);

    return $data;
}

/**
* Generates a 10 character long random string
*
* @return string
*/
function getRandomString(): string {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < 10; $i++) {
        $index = rand(0, strlen($chars) - 1);
        $string .= $chars[$index];
    }

    return $string;
}