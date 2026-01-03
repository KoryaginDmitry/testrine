<?php

return [
    'init' => [
        'success' => '初期化に成功しました',
        'fail' => '初期化中にエラーが発生しました',
        'info' => 'グループ :group を作成しました。ベースクラスのパス: :class',
    ],

    'make' => [
        'write_class_name' => 'クラス名を入力してください',
        'write_route_name' => 'ルート名を入力してください',
        'write_middlewares' => 'ミドルウェアをカンマとスペースで区切って入力してください',
        'select_contracts' => 'テストで実装するインターフェースを選択してください',
        'write_success' => 'クラス :path が正常に作成されました',
        'rewrite_success' => 'クラス :path が正常に上書きされました',
        'route_not_found' => '名前が :name のルートが見つかりません',
        'test_already_exists' => 'テスト ":path" は既に存在します。上書きしますか？',
        'skipped' => 'テスト ":path" はスキップされました',
    ],

    'test' => [
        'skipped' => [
            'invalid_data' => '呼び出されたクラスが無効データ用インターフェースを実装していないため、テストはスキップされました。',
            'invalid_parameters' => '呼び出されたクラスが無効パラメータ用インターフェースを実装していないため、テストはスキップされました。',
        ],

        'errors' => [
            'route' => [
                'not_found' => '名前が :route_name のルートが見つかりません！',
                'not_contain_middlewares' => 'ルートにミドルウェア :name が含まれていません',
                'different_amount_middlewares' => 'ルートに含まれるミドルウェアの数が異なります。',
            ],

            'resource' => [
                'parse' => 'リソース :resource の構造取得中にエラーが発生しました。エラー: ":error"',
            ],
        ],
    ],
];
