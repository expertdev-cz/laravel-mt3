<?php

declare(strict_types=1);

return [
    'form' => [
        'title' => 'Název',
        'url' => 'URL',
        'icon' => 'Ikona',
        'classes' => 'CSS třídy',
        'rel' => 'Rel atribut',
        'linkable_type' => 'Typ',
        'linkable_id' => 'ID',
    ],
    'resource' => [
        'name' => [
            'label' => 'Název',
        ],
        'locations' => [
            'label' => 'Umístění',
            'empty' => 'Nepřiřazeno',
        ],
        'items' => [
            'label' => 'Položky',
        ],
        'is_visible' => [
            'label' => 'Viditelnost',
            'visible' => 'Viditelné',
            'hidden' => 'Skryté',
        ],
    ],
    'actions' => [
        'add' => [
            'label' => 'Přidat do menu',
        ],
        'edit' => 'Upravit',
        'delete' => 'Smazat',
        'indent' => 'Odsadit',
        'unindent' => 'Zrušit odsazení',
        'locations' => [
            'label' => 'Umístění',
            'heading' => 'Správa umístění',
            'description' => 'Vyberte, které menu se má zobrazit na jednotlivých umístěních.',
            'submit' => 'Aktualizovat',
            'form' => [
                'location' => [
                    'label' => 'Umístění',
                ],
                'menu' => [
                    'label' => 'Přiřazené menu',
                ],
            ],
            'empty' => [
                'heading' => 'Nejsou registrována žádná umístění',
            ],
        ],
    ],
    'items' => [
        'expand' => 'Rozbalit',
        'collapse' => 'Sbalit',
        'empty' => [
            'heading' => 'V tomto menu nejsou žádné položky.',
        ],
    ],
    'custom_link' => 'Vlastní odkaz',
    'custom_text' => 'Vlastní text',
    'open_in' => [
        'label' => 'Otevřít v',
        'options' => [
            'self' => 'Stejné kartě',
            'blank' => 'Nové kartě',
            'parent' => 'Nadřazené kartě',
            'top' => 'Horní kartě',
        ],
    ],
    'notifications' => [
        'created' => [
            'title' => 'Odkaz byl vytvořen',
        ],
        'locations' => [
            'title' => 'Umístění menu byla aktualizována',
        ],
    ],
    'panel' => [
        'empty' => [
            'heading' => 'Žádné položky nenalezeny',
            'description' => 'V tomto panelu nejsou žádné položky.',
        ],
        'pagination' => [
            'previous' => 'Předchozí',
            'next' => 'Další',
        ],
    ],
];
