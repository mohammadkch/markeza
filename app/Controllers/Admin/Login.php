<?php

namespace App\Controllers\Admin;

class Login extends BaseController
{
    private const CAPTCHA_SESSION_KEY = 'admin_login_captcha';

    public function index()
    {
        if ($this->authLib->isLoggedIn()) {
            return redirect()->to('/admin/dashboard');
        }

        $msg = (int)$this->request->getVar("msg", FILTER_VALIDATE_INT);
        $msg_text = [
            '1' => 'نام کاربری یا گذرواژه نادرست است.',
            '2' => 'هنگام ورود خطایی رخ داده است.',
            '3' => 'حساب کاربری شما غیرفعال است.',
            '4' => 'کد امنیتی نادرست است. لطفاً دوباره تلاش کنید.',
        ];

        $this->viewData['msg_text'] = isset($msg_text[$msg]) ? $msg_text[$msg] : null;

        return view($this->viewPath . 'login/index', $this->viewData);
    }

    public function authenticate()
    {
        helper('sanitize');

        $captcha = trim((string) $this->request->getPost('captcha'));
        $expectedCaptcha = (string) session()->get(self::CAPTCHA_SESSION_KEY);
        session()->remove(self::CAPTCHA_SESSION_KEY);

        if (! preg_match('/^\d{4}$/', $captcha)
            || $expectedCaptcha === ''
            || ! hash_equals($expectedCaptcha, hash('sha256', $captcha))) {
            return redirect()->to('/admin/login?msg=4')->withInput();
        }

        $rules = [
            'username' => [
                'label' => 'نام کاربری',
                'rules' => 'required|min_length[3]|max_length[50]'
            ],
            'password' => [
                'label' => 'رمز عبور',
                'rules' => 'required|min_length[3]'
            ]
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            $errors = $validation->getErrors();
            $this->flash('validation_error');
            return redirect()->to('/admin/login?msg=1');
        }

        $userModel = model('App\Models\Admin\UserModel');

        $username = $this->request->getPost('username', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $password = $this->request->getPost('password', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);

        $user = $userModel->where('username', $username)
            ->where('password', $password)
            ->where('is_active', 1)
            ->first();

        if ($user === null) {
            $this->flash('user_not_found');
            return redirect()->to('/admin/login?msg=1');
        }

        $user_id = (int)$user['id'];

        if ($user_id < 1) {
            $this->flash('user_not_found');
            return redirect()->to('/admin/login?msg=1');
        }

        $userModel->updateLastLogin($user_id);

        $login_result = $this->authLib->login($user_id, [
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'avatar' => $user['avatar']
        ]);

        if ($login_result) {
            $this->flash('login_success');
            return redirect()->to('/admin/dashboard');
        }

        $this->flash('login_success');
        return redirect()->to('/admin/login?msg=2');
    }

    public function captcha()
    {
        $code = (string) random_int(1000, 9999);
        session()->set(self::CAPTCHA_SESSION_KEY, hash('sha256', $code));

        $width = 190;
        $height = 64;
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '">';
        $svg .= '<rect width="100%" height="100%" rx="10" fill="#e5e7eb"/>';

        for ($i = 0; $i < 18; $i++) {
            $x1 = random_int(0, $width);
            $y1 = random_int(0, $height);
            $x2 = random_int(0, $width);
            $y2 = random_int(0, $height);
            $color = sprintf('#%02x%02x%02x', random_int(35, 125), random_int(55, 145), random_int(55, 145));
            $svg .= '<line x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '" stroke="' . $color . '" stroke-width="' . random_int(1, 3) . '" opacity="0.65"/>';
        }

        for ($i = 0; $i < 90; $i++) {
            $svg .= '<circle cx="' . random_int(2, $width - 2) . '" cy="' . random_int(2, $height - 2) . '" r="' . random_int(1, 2) . '" fill="#1a3336" opacity="' . random_int(20, 65) / 100 . '"/>';
        }

        foreach (str_split($code) as $index => $digit) {
            $x = 28 + ($index * 42) + random_int(-3, 3);
            $y = 45 + random_int(-5, 5);
            $rotation = random_int(-18, 18);
            $svg .= '<text x="' . $x . '" y="' . $y . '" transform="rotate(' . $rotation . ' ' . $x . ' ' . $y . ')" font-family="Arial,sans-serif" font-size="38" font-weight="700" fill="#111827">' . $digit . '</text>';
        }

        $svg .= '</svg>';

        return $this->response
            ->setHeader('Content-Type', 'image/svg+xml; charset=UTF-8')
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setBody($svg);
    }

    public function logout()
    {
        service('adminAuth')->logout();
        session()->setFlashdata('success', 'با موفقیت وارد شدید');
        return redirect()->to('/admin/login');
    }
}
