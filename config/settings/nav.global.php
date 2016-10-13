<?php
/**
 * gredu_labs.
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */
return [
    'navigation' => [
        'main' => [
            'index' => [
                'label' => 'Αρχική',
                'route' => 'index',
                'class' => 'hidden',
            ],
            'school' => [
                'label' => 'Το σχολείο',
                'route' => 'school',
                'pages' => [
                    'info' => [
                        'label' => 'Πληροφορίες',
                        'route' => 'school',
                        'icon' => 'info',
                    ],
                    'staff' => [
                        'label' => 'Εκπαιδευτικοί',
                        'route' => 'school.staff',
                        'icon' => 'users',
                    ],
                    'labs' => [
                        'label' => 'Χώροι',
                        'route' => 'school.labs',
                        'icon' => 'building-o',
                    ],
                    'assets' => [
                        'label' => 'Εξοπλισμός',
                        'route' => 'school.assets',
                        'icon' => 'tv',
                    ],
                    'software' => [
                        'label' => 'Λογισμικό',
                        'route' => 'school.software',
                        'icon' => 'th',
                    ],
                ],
            ],
            'app-form' => [
                'label' => 'Αίτηση',
                'route' => 'application_form',
            ],
            'receive-equip' => [
                'label' => 'Παραλαβή εξοπλισμού',
                'route' => 'receive_equip',
            ],
            'open-data' => [
                'label' => 'Ανοικτά δεδομένα',
                'route' => 'open_data',
            ],
            'university_form' => [
                'label' => 'Ιδρύματα',
                'route' => 'university_form',
            ],
            'teacher_form' => [
                'label' => 'Εκπαιδευτικοί',
                'route' => 'teacher_form',
            ],
            'approved-applications' => [
                'label' => 'Αιτήσεις που εγκρίθηκαν',
                'route' => 'application_form.approved',
            ],
            'about' => [
                'label' => 'Σχετικά με τη δράση',
                'route' => 'about',
            ],
            'forum' => [
                'label' => 'Φόρουμ βοήθειας',
                'href' => '/#forum',
                'external' => true,
                'target' => '_blank',
            ],
        ],
        'admin' => [
            'adminhome' => [
                'label' => 'Σελίδα διαχειριστή',
                'route' => 'admin',
            ],
        ]
    ],
];
