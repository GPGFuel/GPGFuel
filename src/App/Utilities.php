<?php

namespace App;

use InvalidArgumentException;
use SKleeschulte\Base32;

class Utilities {
    /**
     * Return email addresses under specific domains.
     * 
     * @param string[] $emails Array of email addresses
     * @param string[] $domains Array of domains
     * @return string[] Filtered emails
     */
    static function filterEmailAddresses($emails, $domains) {
        if (!is_array($emails)) {
            throw new InvalidArgumentException('$emails must be an array');
        }

        if (!is_array($domains)) {
            throw new InvalidArgumentException('$domains must be an array');
        }

        $filteredEmails = [];
        foreach ($emails as $email) {
            $email = strtolower($email);
            $emailParts = explode('@', $email);
            if (count($emailParts) != 2) {
                continue;
            }

            $domain = $emailParts[1];
            if (in_array($domain, $domains)) {
                $filteredEmails[] = $email;
            }
        }

        return $filteredEmails;
    }

    /**
     * Calculate Web Key Directory hash from email address
     * 
     * @param string $email
     * @return string
     */
    static function emailToWDKHash($email) {
        $email = strtolower($email);
        $emailParts = explode('@', $email);
        if (count($emailParts) != 2) {
            throw new InvalidArgumentException('Invalid email address');
        }

        $local = $emailParts[0];
        $sha1 = hash('sha1', $local, true);
        $wdk = Base32::encodeByteStrToZooko($sha1);
        
        return $wdk;
    }

    /**
     * Get unique users contained in the GPG key
     * 
     * @param \OpenPGP_Message $key
     * @return \OpenPGP_UserIDPacket[]
     */
    static function getUniqueUsers(\OpenPGP_Message $key) {
        $users = [];
        foreach ($key as $packet) {
            if ($packet instanceof \OpenPGP_UserIDPacket) {
                $users[] = $packet;
            }
        }

        return $users;
    }
}
