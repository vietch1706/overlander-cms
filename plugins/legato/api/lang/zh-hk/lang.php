<?php return [
    'auth' => [
        'login' => [
            'fail' => '登入失敗。電郵或密碼不正確。請重新登入。',
            'inactive' => '用戶無效',
        ],
        'logout' => [
            'logged_out' => '用戶登出',
        ],
        'error' => [
            'access_denied' => '未獲得許可',
            'invalid' => '無效用戶',
            'user_not_found' => '未有此用戶',
            'auth_fail' => '驗證失敗',
            'token_not_found' => '未有此憑證',
            'firebase_token_invalid' => '此憑證已過期或無效',
        ],
    ],
    'plugin' => [
        'name' => 'API',
        'description' => '這是API插件',
    ],
    'permissions' => [
        'manage' => 'API管理',
    ],
    'settings' => [
        'configuration' => 'API插件配置',
    ],
    'model' => [
        'id' => 'ID',
        'title' => '標題',
        'status' => '狀態',
        'created_at' => '創建於',
        'updated_at' => '更新於',
        'deleted_at' => '刪除於',
        'created_by' => '創建者',
        'updated_by' => '者更新',
    ],
];
