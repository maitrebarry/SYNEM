<?php

namespace App\Support;

class MemberCardTemplates
{
    public static function all(): array
    {
        return [
            'horizon' => [
                'label' => 'Horizon',
                'description' => 'Bandeau supérieur fort et lecture immédiate.',
                'primary' => '#0f4c81',
                'secondary' => '#f4b400',
                'accent' => '#ffffff',
            ],
            'tricolor' => [
                'label' => 'Tricolore',
                'description' => 'Bloc identité à gauche, informations à droite.',
                'primary' => '#14532d',
                'secondary' => '#f59e0b',
                'accent' => '#f8fafc',
            ],
            'minimal' => [
                'label' => 'Minimal',
                'description' => 'Style épuré orienté administration.',
                'primary' => '#1e293b',
                'secondary' => '#38bdf8',
                'accent' => '#f8fafc',
            ],
            'split' => [
                'label' => 'Split',
                'description' => 'Séparation verticale photo et identité.',
                'primary' => '#7c2d12',
                'secondary' => '#fb7185',
                'accent' => '#fff7ed',
            ],
            'signature' => [
                'label' => 'Signature',
                'description' => 'Accent typographique avec zone signature.',
                'primary' => '#3f3cbb',
                'secondary' => '#14b8a6',
                'accent' => '#eef2ff',
            ],
            'executive' => [
                'label' => 'Executive',
                'description' => 'Présentation institutionnelle sobre.',
                'primary' => '#111827',
                'secondary' => '#d97706',
                'accent' => '#f9fafb',
            ],
            'heritage' => [
                'label' => 'Heritage',
                'description' => 'Approche emblématique avec accent drapeau.',
                'primary' => '#166534',
                'secondary' => '#dc2626',
                'accent' => '#fefce8',
            ],
        ];
    }

    public static function resolve(string $key, ?string $primary = null, ?string $secondary = null, ?string $accent = null): array
    {
        $templates = static::all();
        $template = $templates[$key] ?? $templates['horizon'];

        return [
            'key' => $key,
            'label' => $template['label'],
            'description' => $template['description'],
            'primary' => static::sanitizeColor($primary, $template['primary']),
            'secondary' => static::sanitizeColor($secondary, $template['secondary']),
            'accent' => static::sanitizeColor($accent, $template['accent']),
        ];
    }

    private static function sanitizeColor(?string $value, string $fallback): string
    {
        if (!$value) {
            return $fallback;
        }

        return preg_match('/^#[0-9A-Fa-f]{6}$/', $value) ? $value : $fallback;
    }
}