<?php

return [
    'init' => [
        'success' => 'Initialisierung erfolgreich abgeschlossen',
        'fail' => 'Bei der Initialisierung ist ein Fehler aufgetreten',
        'info' => 'Gruppe :group erstellt, Basisklassenpfad: :class',
    ],

    'make' => [
        'write_class_name' => 'Klassennamen eingeben',
        'write_route_name' => 'Routennamen eingeben',
        'write_middlewares' => 'Middlewares durch Komma getrennt eingeben (mit Leerzeichen)',
        'select_contracts' => 'Wählen Sie die Interfaces aus, die der Test implementieren soll',
        'write_success' => 'Klasse :path erfolgreich erstellt',
        'rewrite_success' => 'Klasse :path erfolgreich überschrieben',
        'route_not_found' => 'Route mit dem Namen :name nicht gefunden',
        'test_already_exists' => 'Der Test ":path" existiert bereits. Überschreiben?',
        'skipped' => 'Test ":path" übersprungen',
    ],

    'test' => [
        'skipped' => [
            'invalid_data' => 'Der Test wurde übersprungen, da die aufgerufene Klasse das Interface für ungültige Daten nicht implementiert.',
            'invalid_parameters' => 'Der Test wurde übersprungen, da die aufgerufene Klasse das Interface für ungültige Parameter nicht implementiert.',
        ],

        'errors' => [
            'route' => [
                'not_found' => 'Route mit dem Namen :route_name nicht gefunden!',
                'not_contain_middlewares' => 'Die Route enthält das Middleware :name nicht',
                'different_amount_middlewares' => 'Die Route enthält eine andere Anzahl von Middlewares.',
            ],

            'resource' => [
                'parse' => 'Fehler beim Abrufen der Ressourcenstruktur :resource. Fehler: ":error"',
            ],
        ],
    ],

    'tests' => [
        'select_route_groups' => 'Routengruppen auswählen',
        'select_routes_by_group' => 'Routen nach Gruppe auswählen',
    ],
];
