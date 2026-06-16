<?php
namespace App\Controllers;

class About extends BaseController
{
    public function index(): string
    {
        $this->viewData['seo'] = [
            'title'       => 'درباره ما | مارکزا هوم',
            'description' => 'آشنایی با مارکزا هوم، سازنده مبلمان چرم لوکس ایتالیایی دست‌ساز',
            'canonical'   => base_url('about'),
        ];
        return view($this->viewPath . 'about/index', $this->viewData);
    }
}