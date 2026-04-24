<?php

namespace Core;

class Security
{
    public static function csrf_tokken(): string
    {

        $token = bin2hex(random_bytes(32));
        self::set_up_csrf_token($token);

        return <<<HTML
  <input type="hidden" name="csrf_token" value="{$_SESSION['csrf']}"/>
HTML;

    }


    private static function set_up_csrf_token(string $tokken): void
    {
        $_SESSION['csrf'] = $tokken;
    }

    public static function verify_csrf_token(): bool
    {
        if ($_POST['csrf_token'] != $_SESSION['csrf']) {
            return false;
        }
        return true;
    }

}
