<?php
namespace App\Enum;

final class Language
{
    public const ENGLISH = 'english';
    public const SWAHILI = 'swahili';

    public static function languageName(int $languageNumber)
    {
        return [
            1 => self::ENGLISH,
            2 => self::SWAHILI,
        ][$languageNumber];
    }
}
