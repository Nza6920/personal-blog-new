<?php

return [
    'common' => [
        'cancel' => 'Cancel',
    ],

    'index' => [
        'page_title' => 'All Articles',
        'search_placeholder' => 'Search...',
    ],

    'sidebar' => [
        'heading' => 'Management',
        'create_topic' => 'New Article',
        'view_logs' => 'View Logs',
        'hint' => 'Use this area for drafts, shortcuts, or quick stats.',
    ],

    'topic' => [
        'published' => 'Published',
        'unpublished' => 'Unpublished',
        'publish_action' => 'Publish',
        'unpublish_action' => 'Unpublish',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'delete_title' => 'Delete this article?',
        'delete_message' => 'This action cannot be undone.',
        'empty' => 'No data yet ~_~',
    ],

    'header' => [
        'title' => 'Blog Admin',
        'user_avatar_alt' => 'User avatar',
        'logout_title' => 'Confirm logout?',
        'logout_message' => 'You need to sign in again to access the admin panel.',
        'logout_trigger' => 'Logout',
        'logout_confirm' => 'Confirm logout',
    ],

    'footer' => [
        'site_icon_alt' => 'Site icon',
        'motto' => 'A journey of a thousand miles begins with a single step.',
        'back_home' => 'Back to main site',
    ],

    'profile' => [
        'page_title' => 'Profile',
        'avatar_alt' => 'User avatar',
        'avatar_upload_label' => 'Avatar upload',
        'avatar_upload_button' => 'Choose file',
        'avatar_upload_no_file' => 'No file selected',
        'avatar_upload_hint' => 'Choose an image file, then save profile changes to apply it.',
        'name_label' => 'Username',
        'email_label' => 'Email',
        'current_password_label' => 'Current password',
        'new_password_label' => 'New password',
        'new_password_confirmation_label' => 'Confirm new password',
        'created_at_label' => 'Created at',
        'updated_at_label' => 'Updated at',
        'two_factor' => [
            'title' => 'Two-factor authentication',
            'description' => 'Add an extra verification code step for admin sign-in.',
            'enabled' => 'Enabled',
            'disabled' => 'Disabled',
            'qr_tip' => 'Scan the QR code with your authenticator app and enter the 6-digit code when signing in.',
            'recovery_codes' => 'Recovery codes',
        ],
        'modals' => [
            'update_profile' => [
                'title' => 'Save profile changes?',
                'message' => 'Your avatar, username, and email will be updated.',
                'trigger' => 'Save profile',
                'confirm' => 'Confirm save',
            ],
            'update_password' => [
                'title' => 'Change password?',
                'message' => 'Use the new password the next time you sign in.',
                'trigger' => 'Change password',
                'confirm' => 'Confirm change',
            ],
            'refresh_recovery_codes' => [
                'title' => 'Refresh recovery codes?',
                'message' => 'All current recovery codes will become invalid. Save the new codes immediately.',
                'trigger' => 'Refresh recovery codes',
                'confirm' => 'Confirm refresh',
            ],
            'disable_two_factor' => [
                'title' => 'Disable two-factor authentication?',
                'message' => 'Sign-in will no longer require a dynamic verification code.',
                'trigger' => 'Disable two-factor auth',
                'confirm' => 'Confirm disable',
            ],
            'enable_two_factor' => [
                'title' => 'Enable two-factor authentication?',
                'message' => 'Please save your recovery codes after enabling.',
                'trigger' => 'Enable two-factor auth',
                'confirm' => 'Confirm enable',
            ],
        ],
    ],

    'editor' => [
        'edit_topic' => 'Edit Topic',
        'new_topic' => 'Create Topic',
        'back_list' => 'Back to list',
        'title_label' => 'Title',
        'title_placeholder' => 'Enter a title',
        'body_label' => 'Content',
        'body_placeholder' => 'Please enter at least three characters.',
        'body_type_label' => 'Text type',
        'body_type_markdown' => 'MARKDOWN',
        'body_type_html' => 'HTML',
        'background_label' => 'Background image',
        'background_upload_button' => 'Choose file',
        'background_upload_no_file' => 'No file selected',
        'background_upload_hint' => 'Common image formats are supported. Save to apply the selected background image.',
        'background_preview_alt' => 'Background preview',
        'save' => 'Save',
        'image_upload_failed' => 'Image upload failed.',
    ],
];
