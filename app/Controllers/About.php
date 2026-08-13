<?php
namespace App\Controllers;

class About extends BaseController
{
    public function index(): string
    {
        $this->viewData['seo'] = [
            'title'       => 'درباره مارکزا هوم | مبلمان چرمی لوکس و دست‌ساز',
            'description' => 'با داستان مارکزا هوم، هنر ساخت مبلمان چرمی لوکس، طراحی الهام‌گرفته از ایتالیا و تعهد ما به کیفیت، ظرافت و دوام آشنا شوید.',
            'canonical'   => base_url('about'),
            'og_image'    => base_url('assets/images/about/about-top-1.webp'),
        ];
        return view($this->viewPath . 'about/index', $this->viewData);
    }
}
