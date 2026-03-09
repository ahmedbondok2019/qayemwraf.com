<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticTranslation;

class DashboardLayoutTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $translations = [
            // Navbar & General Layout
            ['key' => 'dashboard.Dashboard Title', 'ar' => 'لوحة التحكم', 'en' => 'Dashboard'],
            ['key' => 'dashboard.Notifications', 'ar' => 'التنبيهات', 'en' => 'Notifications'],
            ['key' => 'dashboard.New', 'ar' => 'جديد', 'en' => 'New'],
            ['key' => 'dashboard.No notifications', 'ar' => 'لا توجد تنبيهات', 'en' => 'No notifications'],
            ['key' => 'dashboard.Profile', 'ar' => 'الملف الشخصي', 'en' => 'Profile'],
            ['key' => 'dashboard.Logout', 'ar' => 'تسجيل الخروج', 'en' => 'Logout'],
            
            // Login Page
            ['key' => 'login.Page Title', 'ar' => 'تسجيل الدخول | لوحة إدارة مكتبة الكتب', 'en' => 'Login | Library Management Dashboard'],
            ['key' => 'login.Sidebar Welcome Header', 'ar' => 'لوحة إدارة مكتبة الكتب', 'en' => 'Library Management Dashboard'],
            ['key' => 'login.Sidebar Welcome Desc', 'ar' => 'قم بتسجيل الدخول للوصول إلى لوحة التحكم الشاملة لمكتبتك. يمكنك إدارة الكتب، المستخدمين، الإعارات، والتقارير بكل سهولة.', 'en' => 'Login to access your comprehensive library dashboard. You can manage books, users, loans, and reports with ease.'],
            ['key' => 'login.Feature 1', 'ar' => 'إدارة فهرس الكتب الإلكتروني', 'en' => 'Manage electronic book catalog'],
            ['key' => 'login.Feature 2', 'ar' => 'تتبع أعضاء المكتبة', 'en' => 'Track library members'],
            ['key' => 'login.Feature 3', 'ar' => 'تنظيم عمليات الإعارة والإرجاع', 'en' => 'Organize loan and return processes'],
            ['key' => 'login.Feature 4', 'ar' => 'تقارير وإحصائيات مفصلة', 'en' => 'Detailed reports and statistics'],
            ['key' => 'login.Right Header', 'ar' => 'مكتبة الكتب', 'en' => 'Book Library'],
            ['key' => 'login.Right Subheader', 'ar' => 'نظام إدارة المكتبة المتكامل', 'en' => 'Integrated Library Management System'],
            ['key' => 'login.Email Label', 'ar' => 'البريد الإلكتروني', 'en' => 'Email'],
            ['key' => 'login.Email Placeholder', 'ar' => 'أدخل البريد الإلكتروني', 'en' => 'Enter Email'],
            ['key' => 'login.Password Label', 'ar' => 'كلمة المرور', 'en' => 'Password'],
            ['key' => 'login.Password Placeholder', 'ar' => 'أدخل كلمة المرور', 'en' => 'Enter Password'],
            ['key' => 'login.Remember Me', 'ar' => 'تذكرني', 'en' => 'Remember Me'],
            ['key' => 'login.Login Button', 'ar' => 'تسجيل الدخول', 'en' => 'Login'],
            ['key' => 'login.Footer Text', 'ar' => 'النظام مخصص للموظفين والمشرفين فقط. &copy; 2026 مكتبة الكتب', 'en' => 'The system is for employees and supervisors only. &copy; 2026 Book Library'],
            ['key' => 'login.Footer Contact Part 1', 'ar' => 'للحصول على مساعدة،', 'en' => 'For help,'],
            ['key' => 'login.Footer Contact Part 2', 'ar' => 'اتصل بمدير النظام', 'en' => 'contact the system administrator'],
        ];

        foreach ($translations as $trans) {
            StaticTranslation::updateOrCreate(
                ['key' => $trans['key']],
                [
                    'translations' => [
                        'ar' => $trans['ar'],
                        'en' => $trans['en']
                    ]
                ]
            );
        }
    }
}
