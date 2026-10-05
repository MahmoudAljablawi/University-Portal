<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_arabic_is_rendered_on_guest_screens_with_rtl_direction(): void
    {
        $this->withSession(['locale' => 'ar'])
            ->get('/login')
            ->assertOk()
            ->assertSee('lang="ar"', false)
            ->assertSee('dir="rtl"', false)
            ->assertSee('مرحبًا بعودتك')
            ->assertSee('البريد الإلكتروني')
            ->assertSee('تذكرني');
    }

    public function test_guest_can_switch_language_before_signing_in(): void
    {
        $this->from('/login')
            ->get('/language/ar')
            ->assertRedirect('/login')
            ->assertSessionHas('locale', 'ar');

        $this->get('/login')
            ->assertOk()
            ->assertSee('مرحبًا بعودتك');
    }

    public function test_arabic_validation_messages_are_localized(): void
    {
        app()->setLocale('ar');

        $validator = Validator::make(
            ['name' => null],
            ['name' => 'required']
        );

        $this->assertSame('حقل الاسم مطلوب.', $validator->errors()->first('name'));
    }

    public function test_authentication_and_authorization_messages_are_localized(): void
    {
        app()->setLocale('ar');

        $this->assertSame('تأكيد عنوان بريدك الإلكتروني', __('Verify Your Email Address'));
        $this->assertSame('بيانات الاعتماد المدخلة غير صحيحة.', __('The provided credentials are incorrect.'));
        $this->assertSame(
            'عذرًا، لا تملك الصلاحية للوصول إلى هذه الصفحة.',
            __('Sorry, you are not authorized to access this page.')
        );
    }

    public function test_pagination_summary_words_are_localized(): void
    {
        app()->setLocale('ar');

        $this->assertSame('عرض', __('Showing'));
        $this->assertSame('إلى', __('to'));
        $this->assertSame('من', __('of'));
        $this->assertSame('الفصول الدراسية', __('academic semesters'));
    }
}
