<?php

namespace App\Services;

class StorageService {

    private $secretKey;

    function __construct() {
        $this->secretKey = $_ENV['APP_SECRET'];
    }

    private function getFileLocation($fingerprint, $type) {
        $base = "storage/$type";
        if (!file_exists($base)) {
            mkdir($base, 0733, true);
        }
        if (!is_dir($base)) {
            throw new \Exception("Directory does not exists");
        }
        return "$base/$fingerprint";
    }

    function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }


    public function storePublicKey($fingerprint, $content) {
        $file = fopen($this->getFileLocation($fingerprint, "tmp"), "w");
        fwrite($file, $content);
        fclose($file);
    }

    private function signFingerprint($fingerprint) {
        return hash_hmac('sha256',  $fingerprint, $this->secretKey);
    }

    public function generateSignature($fingerprint) {
        return $this->signFingerprint($fingerprint);
    }

    public function verifySignature($fingerprint, $signature) {
        if ($this->signFingerprint($fingerprint) !== $signature) {
            throw new \Exception("Signature is invalid");
        }
    }

    public function setVerified($fingerprint) {
        $tmpFileLocation = $this->getFileLocation($fingerprint, "tmp");
        $finalFileLocation = $this->getFileLocation($fingerprint, "final");

        if (!file_exists($tmpFileLocation)) {
            throw new \Exception("File does not exists");
        }
        if (!rename($tmpFileLocation, $finalFileLocation)) {
            throw new \Exception("Could not move the file to a verified location");
        }
    }
}