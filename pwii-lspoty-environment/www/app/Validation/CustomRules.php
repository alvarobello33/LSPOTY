<?php

namespace App\Validation;

class CustomRules
{
    public function check_email_domain(string $str): bool
    {
        if (!filter_var($str, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        //Comprovar q el email contingui un dels tres dominis
        $allowedDomains = ['@students.salle.url.edu', '@ext.salle.url.edu', '@salle.url.edu'];

        foreach ($allowedDomains as $domain) {
            if (str_ends_with($str, $domain)) {
                return true;
            }
        }
        return false;
    }

    public function check_password_strength(string $str): bool
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $str);
    }
}
