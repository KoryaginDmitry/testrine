<?php

return [
    'init' => [
        'success' => 'Initialisation réussie',
        'fail' => 'Une erreur est survenue lors de l’initialisation',
        'info' => 'Groupe créé :group, chemin de la classe de base : :class',
    ],

    'make' => [
        'write_class_name' => 'Entrez le nom de la classe',
        'write_route_name' => 'Entrez le nom de la route',
        'write_middlewares' => 'Entrez les middlewares séparés par des virgules (avec espace)',
        'select_contracts' => 'Sélectionnez les interfaces que le test doit implémenter',
        'write_success' => 'Classe :path créée avec succès',
        'rewrite_success' => 'Classe :path écrasée avec succès',
        'route_not_found' => 'Route avec le nom :name introuvable',
        'test_already_exists' => 'Le test ":path" existe déjà. Voulez-vous l’écraser ?',
        'skipped' => 'Test ":path" ignoré',
    ],

    'test' => [
        'skipped' => [
            'invalid_data' => 'Le test a été ignoré car la classe appelée n’implémente pas l’interface des données invalides.',
            'invalid_parameters' => 'Le test a été ignoré car la classe appelée n’implémente pas l’interface des paramètres invalides.',
        ],

        'errors' => [
            'route' => [
                'not_found' => 'Route avec le nom :route_name introuvable !',
                'not_contain_middlewares' => 'La route ne contient pas le middleware :name',
                'different_amount_middlewares' => 'La route contient un nombre différent de middlewares.',
            ],

            'resource' => [
                'parse' => 'Erreur lors de la récupération de la structure de la ressource :resource. Erreur : ":error"',
            ],
        ],
    ],
];
