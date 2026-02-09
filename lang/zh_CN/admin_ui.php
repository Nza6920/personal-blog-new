<?php

return [
    'common' => [
        'cancel' => '取消',
    ],

    'index' => [
        'page_title' => '所有文章',
        'search_placeholder' => '搜索...',
    ],

    'sidebar' => [
        'heading' => '管理工具',
        'create_topic' => '新建文章',
        'view_logs' => '日志查看',
        'hint' => '这里可以放草稿、快捷入口或统计信息。',
    ],

    'topic' => [
        'published' => '已发布',
        'unpublished' => '未发布',
        'publish_action' => '发布',
        'unpublish_action' => '取消发布',
        'edit' => '编辑',
        'delete' => '删除',
        'delete_title' => '确认删除这篇文章？',
        'delete_message' => '删除后无法恢复，请谨慎操作。',
        'empty' => '暂无数据 ~_~',
    ],

    'header' => [
        'title' => '博客后台',
        'user_avatar_alt' => '用户头像',
        'logout_title' => '确认退出登录？',
        'logout_message' => '退出后需要重新登录才能进入后台。',
        'logout_trigger' => '退出',
        'logout_confirm' => '确认退出',
    ],

    'footer' => [
        'site_icon_alt' => '站点图标',
        'motto' => '不积跬步，无以至千里',
        'back_home' => '返回主站',
    ],

    'profile' => [
        'page_title' => '个人资料',
        'avatar_alt' => '用户头像',
        'avatar_upload_label' => '头像上传',
        'avatar_upload_button' => '选择文件',
        'avatar_upload_no_file' => '未选择文件',
        'avatar_upload_hint' => '支持常见图片格式，选择新文件后保存资料即可生效。',
        'name_label' => '用户名',
        'email_label' => '邮箱',
        'current_password_label' => '当前密码',
        'new_password_label' => '新密码',
        'new_password_confirmation_label' => '确认新密码',
        'created_at_label' => '创建时间',
        'updated_at_label' => '更新时间',
        'two_factor' => [
            'title' => '双因素认证',
            'description' => '为后台登录增加一次动态验证码校验。',
            'enabled' => '已启用',
            'disabled' => '未启用',
            'qr_tip' => '使用认证器应用扫描二维码，然后在登录时输入 6 位验证码。',
            'recovery_codes' => '恢复码',
        ],
        'modals' => [
            'update_profile' => [
                'title' => '确认保存资料？',
                'message' => '将更新你的头像、用户名和邮箱信息。',
                'trigger' => '保存资料',
                'confirm' => '确认保存',
            ],
            'update_password' => [
                'title' => '确认修改密码？',
                'message' => '修改后请使用新密码重新登录后台。',
                'trigger' => '修改密码',
                'confirm' => '确认修改',
            ],
            'refresh_recovery_codes' => [
                'title' => '确认刷新恢复码？',
                'message' => '刷新后旧恢复码将全部失效，请及时保存新的恢复码。',
                'trigger' => '刷新恢复码',
                'confirm' => '确认刷新',
            ],
            'disable_two_factor' => [
                'title' => '确认关闭双因素认证？',
                'message' => '关闭后登录将不再需要动态验证码。',
                'trigger' => '关闭双因素认证',
                'confirm' => '确认关闭',
            ],
            'enable_two_factor' => [
                'title' => '确认启用双因素认证？',
                'message' => '启用后请保存恢复码，以防认证器不可用。',
                'trigger' => '启用双因素认证',
                'confirm' => '确认启用',
            ],
        ],
    ],

    'editor' => [
        'edit_topic' => '编辑话题',
        'new_topic' => '新建话题',
        'back_list' => '返回列表',
        'title_label' => '标题',
        'title_placeholder' => '请填写标题',
        'body_label' => '内容',
        'body_placeholder' => '请输入至少三个字符的内容。',
        'body_type_label' => '文本类型',
        'body_type_markdown' => 'MARKDOWN',
        'body_type_html' => 'HTML',
        'background_label' => '背景图片',
        'background_upload_button' => '选择文件',
        'background_upload_no_file' => '未选择文件',
        'background_upload_hint' => '支持常见图片格式，选择文件后保存即可更新背景图。',
        'background_preview_alt' => '背景预览',
        'save' => '保存',
        'image_upload_failed' => '图片上传失败。',
    ],
];
