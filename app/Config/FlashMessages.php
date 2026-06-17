<?php

namespace App\Config;

class FlashMessages
{
    public static $success = [
        // collection messages
        'collection_create_success' => [
            'message' => 'کالکشن با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'collection_update_success' => [
            'message' => 'کالکشن با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'collection_delete_success' => [
            'message' => 'کالکشن با موفقیت حذف شد.',
            'type' => 'success'
        ],
        'detail_create_success' => [
            'message' => 'مشخصه با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'detail_update_success' => [
            'message' => 'مشخصه با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'detail_delete_success' => [
            'message' => 'مشخصه با موفقیت حذف شد.',
            'type' => 'success'
        ],
        'image_create_success' => [
            'message' => 'تصویر با موفقیت اضافه شد.',
            'type' => 'success'
        ],
        'image_update_success' => [
            'message' => 'تصویر با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'image_delete_success' => [
            'message' => 'تصویر با موفقیت حذف شد.',
            'type' => 'success'
        ],
        'material_create_success' => [
            'message' => 'متریال با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'material_update_success' => [
            'message' => 'متریال با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'material_delete_success' => [
            'message' => 'متریال با موفقیت حذف شد.',
            'type' => 'success'
        ],
        'faq_create_success' => [
            'message' => 'سوال با موفقیت ایجاد شد.',
            'type' => 'success'
        ],
        'faq_update_success' => [
            'message' => 'سوال با موفقیت بروزرسانی شد.',
            'type' => 'success'
        ],
        'faq_delete_success' => [
            'message' => 'سوال با موفقیت حذف شد.',
            'type' => 'success'
        ],
    ];

    public static $error = [
        // collection errors
        'collection_not_found' => [
            'message' => 'کالکشن مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'collection_create_error' => [
            'message' => 'مشکلی در ایجاد کالکشن پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'collection_update_error' => [
            'message' => 'مشکلی در بروزرسانی کالکشن پیش آمده. لطفاً دوباره تلاش کنید.',
            'type' => 'error'
        ],
        'detail_not_found' => [
            'message' => 'مشخصه مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'detail_create_error' => [
            'message' => 'مشکلی در ایجاد مشخصه پیش آمده.',
            'type' => 'error'
        ],
        'detail_update_error' => [
            'message' => 'مشکلی در بروزرسانی مشخصه پیش آمده.',
            'type' => 'error'
        ],
        'image_not_found' => [
            'message' => 'تصویر مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'image_create_error' => [
            'message' => 'مشکلی در آپلود تصویر پیش آمده.',
            'type' => 'error'
        ],
        'image_update_error' => [
            'message' => 'مشکلی در بروزرسانی تصویر پیش آمده.',
            'type' => 'error'
        ],
        'image_upload_error' => [
            'message' => 'خطا در آپلود تصویر: ',
            'type' => 'error'
        ],
        'material_not_found' => [
            'message' => 'متریال مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'material_create_error' => [
            'message' => 'مشکلی در ایجاد متریال پیش آمده.',
            'type' => 'error'
        ],
        'material_update_error' => [
            'message' => 'مشکلی در بروزرسانی متریال پیش آمده.',
            'type' => 'error'
        ],
        'login_error' => [
            'message' => 'خطا در ورود کاربر.',
            'type' => 'error'
        ],
        'faq_not_found' => [
            'message' => 'سوال مورد نظر وجود ندارد.',
            'type' => 'error'
        ],
        'faq_create_error' => [
            'message' => 'مشکلی در ایجاد سوال پیش آمده.',
            'type' => 'error'
        ],
        'faq_update_error' => [
            'message' => 'مشکلی در بروزرسانی سوال پیش آمده.',
            'type' => 'error'
        ],

    ];

    public static $info = [
        'loading' => [
            'message' => 'در حال پردازش اطلاعات...',
            'type' => 'info'
        ],
        'no_data' => [
            'message' => 'هیچ داده‌ای برای نمایش وجود ندارد.',
            'type' => 'info'
        ],
    ];

    public static function get($key, $customMessage = null)
    {
        if (isset(self::$success[$key])) {
            $msg = self::$success[$key];
        }
        elseif (isset(self::$error[$key])) {
            $msg = self::$error[$key];
        }
        elseif (isset(self::$info[$key])) {
            $msg = self::$info[$key];
        }
        else {
            return [
                'message' => $customMessage ?? 'عملیات با موفقیت انجام شد.',
                'type' => 'info'
            ];
        }

        if ($customMessage) {
            $msg['message'] = $customMessage;
        }

        return $msg;
    }
}