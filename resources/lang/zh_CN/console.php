<?php

return [
    'init' => [
        'success' => '初始化成功',
        'fail' => '初始化过程中发生错误',
        'info' => '已创建分组 :group，基础类路径：:class',
    ],

    'make' => [
        'write_class_name' => '请输入类名',
        'write_route_name' => '请输入路由名称',
        'write_middlewares' => '请输入中间件，用逗号加空格分隔',
        'select_contracts' => '请选择测试需要实现的接口',
        'write_success' => '类 :path 创建成功',
        'rewrite_success' => '类 :path 覆盖成功',
        'route_not_found' => '未找到名称为 :name 的路由',
        'test_already_exists' => '测试 ":path" 已存在，是否覆盖？',
        'skipped' => '测试 ":path" 已跳过',
    ],

    'test' => [
        'skipped' => [
            'invalid_data' => '由于调用的类未实现无效数据接口，测试被跳过。',
            'invalid_parameters' => '由于调用的类未实现无效参数接口，测试被跳过。',
        ],

        'errors' => [
            'route' => [
                'not_found' => '未找到名称为 :route_name 的路由！',
                'not_contain_middlewares' => '路由不包含中间件 :name',
                'different_amount_middlewares' => '路由包含的中间件数量不一致。',
            ],

            'resource' => [
                'parse' => '获取资源结构 :resource 时出错。错误：" :error"',
            ],
        ],
    ],

    'tests' => [
        'select_route_groups' => '选择路由组',
        'select_routes_by_group' => '按组选择路由',
    ],
];
