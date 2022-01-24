<?php 
namespace App\helpers;

class text {
    public static function excerpt(string $content, int $limit = 40): string
    {
        if (mb_strlen($content) <= $limit){
            return $content;
        }
        $lastspace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastspace) . "...";
    }

}