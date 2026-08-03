<?php

namespace App\Controllers;

class Branches extends BaseController
{
    public function index(): string
    {
        $this->viewData['branches'] = [
            [
                'city' => 'مشهد',
                'address' => 'مشهد، آرمیتاژ، طبقه دوم تجاری، واحد ۲۷۳',
                'mobile' => '09151160408',
                'phone' => '8335247',
                'manager' => 'آقای روغنی',
                'image' => null,
            ],
            [
                'city' => 'البرز',
                'address' => 'طالقانی شمالی، بعد از پل آزادگان، خیابان شهید شجاعی، روبه‌روی برج قائم',
                'mobile' => '09123301712',
                'phone' => null,
                'manager' => 'آقای صالحی',
                'image' => null,
            ],
            [
                'city' => 'اراک',
                'address' => 'خیابان عباس‌آباد، نبش موزه مفاخر، مرکز تجاری یاسمن',
                'mobile' => '09182609791',
                'phone' => '08632212129',
                'manager' => 'آقای حسین‌آبادی',
                'image' => null,
            ],
            [
                'city' => 'لاهیجان',
                'address' => 'بلوار شهید انصاری، روبه‌روی دادگستری',
                'mobile' => '09111435774',
                'phone' => null,
                'manager' => 'آقای نقیبی',
                'image' => null,
            ],
            [
                'city' => 'شیراز',
                'address' => 'شیراز، انتهای قدوسی غربی، جنب سوپراستور مهکام',
                'mobile' => '09171118106',
                'phone' => null,
                'manager' => 'خانم قناعت‌پیشه',
                'image' => null,
            ],
            [
                'city' => 'رویان (فروشگاه آکاژو)',
                'address' => 'بین سی‌سنگان و نوشهر، علی‌آباد عسگرخان، جنب امیر شکلات',
                'mobile' => '09128005749',
                'phone' => null,
                'manager' => 'آقای طاهایی',
                'image' => null,
            ],
            [
                'city' => 'همدان',
                'address' => 'میدان بیمه، ابتدای بلوار عمار، بعد از سازمان امور مالیاتی، نبش کوچه حقیقت، طبقه بالای اوان خودرو، گالری دیزانا',
                'mobile' => '09120625565',
                'phone' => null,
                'manager' => 'آقای حمیدی',
                'image' => null,
            ],
            [
                'city' => 'اصفهان',
                'address' => 'بازار مبل رهنان، پلاک ۳۰۵',
                'mobile' => '09133664454',
                'phone' => null,
                'manager' => 'آقای فتحی',
                'image' => null,
            ],
        ];

        $this->viewData['defaultBranchImage'] = $this->viewData['assetsPath'] . 'images/feature/feature2.svg';
        $this->viewData['seo'] = [
            'title' => 'نمایندگی‌های مارکزا هوم',
            'description' => 'آدرس و اطلاعات تماس نمایندگی‌های مارکزا هوم در سراسر ایران',
            'canonical' => base_url('branches'),
        ];

        return view($this->viewPath . 'branches/index', $this->viewData);
    }
}
