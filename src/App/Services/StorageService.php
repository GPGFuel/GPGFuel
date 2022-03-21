<?php

namespace App\Services;

class StorageService {

    private $secretKey;
    const WKD_TMP_FOLDER = "StorageService::WKD_TMP_FOLDER";
    const WKD_FOLDER = "StorageService::WKD_FOLDER";

    function __construct() {
        $this->secretKey = $_ENV['APP_SECRET'];
    }

    private function getBaseDirectory($type) {
        switch ($type) {
            case StorageService::WKD_TMP_FOLDER:
                return $_ENV['TEMP_PATH'] ?? "storage/tmp";
            case StorageService::WKD_FOLDER:
                return $_ENV['WEBKEYDIRECTORY_PATH'] ?? "storage/webkeydirectory";
            default:
                return "storage";
        }
    }

    private function getFileLocation($fingerprint, $type) {
        $base = $this->getBaseDirectory($type);

        if (!file_exists($base)) {
            mkdir($base, 0733, true);
        }
        if (!is_dir($base)) {
            throw new \Exception("Directory does not exists");
        }
        return "$base/$fingerprint";
    }

    public function storePublicKey($fingerprint, $content) {
        $file = fopen($this->getFileLocation($fingerprint, StorageService::WKD_TMP_FOLDER), "w");
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
        $tmpFileLocation = $this->getFileLocation($fingerprint, StorageService::WKD_TMP_FOLDER);
        $finalFileLocation = $this->getFileLocation($fingerprint, StorageService::WKD_FOLDER);

        if (!file_exists($tmpFileLocation)) {
            throw new \Exception("File does not exists");
        }
        if (!rename($tmpFileLocation, $finalFileLocation)) {
            throw new \Exception("Could not move the file to a verified location");
        }
    }
}