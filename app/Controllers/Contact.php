<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;
use DateTimeImmutable;
use DateTimeZone;

class Contact extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        $this->viewData['seo'] = [
            'title'       => 'تماس با مارکزا هوم | مشاوره خرید و اطلاعات کارخانه',
            'description' => 'راه‌های تماس با مارکزا هوم برای مشاوره خرید مبلمان، سفارش سفارشی و همکاری تجاری؛ مشاهده شماره تماس، ایمیل، آدرس کارخانه و ساعات پاسخ‌گویی.',
            'canonical'   => base_url('contact'),
            'og_image'    => base_url('assets/images/logo/logo-black-trans.png'),
        ];

        return view($this->viewPath . 'contact/index', $this->viewData);
    }

    public function submit()
    {
        $rules = [
            'full_name' => [
                'label' => 'نام و نام خانوادگی',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'mobile' => [
                'label' => 'شماره موبایل',
                'rules' => 'required|regex_match[/^09\d{9}$/]',
            ],
            'email' => [
                'label' => 'ایمیل',
                'rules' => 'required|valid_email|max_length[254]',
            ],
            'message' => [
                'label' => 'متن پیام',
                'rules' => 'required|min_length[10]|max_length[2000]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('contact'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        session();
        $sessionKey = hash('sha256', session_id());
        $timezone = new DateTimeZone('Asia/Tehran');
        $today = new DateTimeImmutable('today', $timezone);
        $tomorrow = $today->modify('+1 day');
        $messageModel = new ContactMessageModel();

        try {
            if ($messageModel->countForSessionBetween($sessionKey, $today->getTimestamp(), $tomorrow->getTimestamp()) >= 2) {
                return redirect()->to(base_url('contact'))
                    ->withInput()
                    ->with('error', 'حداکثر دو پیام در روز می‌توانید ارسال کنید.');
            }

            $messageModel->insert([
                'full_name'   => trim((string) $this->request->getPost('full_name')),
                'mobile'      => (string) $this->request->getPost('mobile'),
                'email'       => trim((string) $this->request->getPost('email')),
                'message'     => trim((string) $this->request->getPost('message')),
                'session_key' => $sessionKey,
                'ip_address'  => $this->request->getIPAddress(),
            ]);
        } catch (\Throwable $exception) {
            log_message('error', 'Contact message could not be saved: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return redirect()->to(base_url('contact'))
                ->withInput()
                ->with('error', 'ثبت پیام با خطا مواجه شد. لطفاً دوباره تلاش کنید.');
        }

        return redirect()->to(base_url('contact'))
            ->with('success', 'پیام شما با موفقیت ثبت شد. به‌زودی با شما تماس می‌گیریم.');
    }
}
