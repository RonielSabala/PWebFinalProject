<?php

namespace App\Utils;

use DateTime;


class PrintUtils
{
    private static $getPrintableTextRegex = '#
        \[(?<md_text>[^\]]+)\]\((?<md_url>https?://[^\s)]+)\)
        |(?<url>https?://[^\s<]+|www\.[^\s<]+)
        |(?<email>[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,})
    #ixu
    ';

    public static function getPrintableText(string $text): string
    {
        if ($text === '') return '';

        $lastPos = 0;
        $out = '';
        $subject = $text;
        $matches = [];
        $res = preg_match_all(self::$getPrintableTextRegex, $subject, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        if ($res === false) {
            return nl2br($text);
        }

        foreach ($matches as $m) {
            $matchText = $m[0][0];
            $matchPos  = $m[0][1];
            if ($matchPos > $lastPos) {
                $chunk = substr($subject, $lastPos, $matchPos - $lastPos);
                $chunk = trim($chunk);
                if ($chunk !== '') {
                    $out .= '<p class="desc-text-run">' . nl2br(htmlspecialchars($chunk, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) . '</p>';
                }
            }

            if (!empty($m['md_url'][0])) {
                $url = $m['md_url'][0];
                $label = $m['md_text'][0];
                $href = $url;
            } elseif (!empty($m['url'][0])) {
                $raw = $m['url'][0];
                if (stripos($raw, 'www.') === 0) {
                    $href = 'https://' . $raw;
                } else {
                    $href = $raw;
                }
                $label = $raw;
            } else {
                $email = $m['email'][0];
                $href = 'mailto:' . $email;
                $label = $email;
            }

            $esc_label = $label;
            $esc_href = $href;
            $target = (stripos($href, 'mailto:') === 0) ? '' : ' target="_blank" rel="noopener noreferrer"';
            $out .= '<a class="description-link" href="' . $esc_href . '"' . $target . '>' . $esc_label . '</a>';
            $lastPos = $matchPos + strlen($matchText);
        }

        if ($lastPos < strlen($subject)) {
            $tail = substr($subject, $lastPos);
            if (trim($tail) !== '') {
                $out .= '<p class="desc-text-run">' . nl2br(htmlspecialchars($tail, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) . '</p>';
            }
        }

        return $out;
    }

    public static function getPrintableDate(string $date): string
    {
        return (new DateTime($date))->format('d/m/Y H:i');
    }

    public static function getPrintableJson(string $json_string): string
    {
        $data = json_decode($json_string, true);
        $prettify_key = function ($k) {
            return ucwords(str_replace(['_', '-'], [' ', ' '], $k));
        };

        $html = '<div class="json-blob"><div class="card"><dl>';
        foreach ($data as $key => $value) {
            $html .= '<dt>' . htmlspecialchars($prettify_key($key)) . '</dt>';
            $html .= '<dd>';
            if (is_array($value)) {
                $is_assoc = array_keys($value) !== range(0, count($value) - 1);
                if ($is_assoc) {
                    $html .= '<div class="mono small">' . htmlspecialchars(json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) . '</div>';
                } else {
                    foreach ($value as $item) {
                        if (is_array($item)) {
                            $html .= '<span class="badge">' . htmlspecialchars(json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) . '</span>';
                        } else {
                            $html .= '<span class="badge">' . htmlspecialchars((string)$item) . '</span>';
                        }
                    }
                }
            } elseif (is_bool($value)) {
                $html .= '<span class="mono">' . ($value ? 'true' : 'false') . '</span>';
            } elseif (is_string($value) && preg_match('~^https?://~i', $value)) {
                $safe = htmlspecialchars($value);
                $html .= '<a href="' . $safe . '" target="_blank" rel="noopener noreferrer">Ver enlace</a>';
            } elseif (is_string($value) && mb_strlen($value) > 120) {
                $html .= '<div class="long small">' . nl2br(htmlspecialchars($value)) . '</div>';
            } elseif (is_int($value) || is_float($value)) {
                $html .= '<span class="mono">' . htmlspecialchars((string)$value) . '</span>';
            } else {
                $html .= htmlspecialchars((string)$value);
            }

            $html .= '</dd>';
        }

        $html .= '</dl></div></div>';
        return $html;
    }
}
