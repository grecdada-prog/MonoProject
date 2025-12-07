<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CameroonPhoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * Formats acceptés:
     * - +237 XXX XXX XXX (9 chiffres)
     * - +237XXXXXXXXX
     * - 237 XXX XXX XXX
     * - 6XXXXXXXX ou 2XXXXXXXX (préfixes valides au Cameroun)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Nettoyer le numéro (retirer espaces et tirets)
        $cleaned = preg_replace('/[\s\-]/', '', $value);

        // Pattern 1: +237XXXXXXXXX (9 chiffres)
        $pattern1 = '/^\+237[26]\d{8}$/';

        // Pattern 2: 237XXXXXXXXX (sans +)
        $pattern2 = '/^237[26]\d{8}$/';

        // Pattern 3: 6XXXXXXXX ou 2XXXXXXXX (format local)
        $pattern3 = '/^[26]\d{8}$/';

        if (!preg_match($pattern1, $cleaned) &&
            !preg_match($pattern2, $cleaned) &&
            !preg_match($pattern3, $cleaned)) {
            $fail('Le numéro de téléphone doit être un numéro camerounais valide (ex: +237 6XX XXX XXX ou 6XX XXX XXX).');
        }
    }

    /**
     * Normalise un numéro camerounais au format international
     */
    public static function normalize(string $phone): string
    {
        $cleaned = preg_replace('/[\s\-]/', '', $phone);

        // Si commence par +237, retourner tel quel
        if (str_starts_with($cleaned, '+237')) {
            return $cleaned;
        }

        // Si commence par 237, ajouter +
        if (str_starts_with($cleaned, '237')) {
            return '+' . $cleaned;
        }

        // Si commence par 6 ou 2 (format local), ajouter +237
        if (preg_match('/^[26]\d{8}$/', $cleaned)) {
            return '+237' . $cleaned;
        }

        return $cleaned;
    }
}
