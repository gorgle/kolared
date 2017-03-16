<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'rbacType' => [
        \yii\rbac\Item::TYPE_PERMISSION => 'Permission',
        \yii\rbac\Item::TYPE_ROLE => 'Role',
    ],
];
