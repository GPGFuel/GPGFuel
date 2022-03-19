<?php

namespace App;

use InvalidArgumentException;

class Utilities {
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
}
