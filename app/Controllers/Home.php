<?php

namespace App\Controllers;

use App\Models\CollectionModel;

class Home extends BaseController
{
    public function index(): string
    {

        $collectionModel = new CollectionModel();
        $collections = $collectionModel->getAllActive();

        $this->viewData['banners'] = [
            ['image' => $this->viewData['assetsPath'] . 'images/banner/slider1_1160x530.webp', 'alt' => 'تصویری از خانه‌ای منظم، امن و پر از احساس'],
            ['image' => $this->viewData['assetsPath'] . 'images/banner/slider2_1160x530.webp', 'alt' => 'توجه به جزئیات، انتخاب متریال ممتاز و تلفیق سادگی با ظرافت'],
            ['image' => $this->viewData['assetsPath'] . 'images/banner/slider3_1160x530.webp', 'alt' => 'خلاقیت و نوآوری'],
            ['image' => $this->viewData['assetsPath'] . 'images/banner/slider4_1160x530.webp', 'alt' => 'روایتی از سنت و نوآوری'],
            ['image' => $this->viewData['assetsPath'] . 'images/banner/slider5_1160x530.webp', 'alt' => 'وقتی طراحی اصیل با طبیعت هم‌نشین می‌شود'],
        ];

        $this->viewData['services'] = [
            ['icon' => $this->viewData['assetsPath'] . 'images/feature/feature1.svg', 'title' => 'شخصی سازی آسان', 'summary' => 'لورم ایپسوم متن ساختگی...'],
            ['icon' => $this->viewData['assetsPath'] . 'images/feature/feature2.svg', 'title' => 'کدنویسی تمیز', 'summary' => 'لورم ایپسوم متن ساختگی...'],
            ['icon' => $this->viewData['assetsPath'] . 'images/feature/feature3.svg', 'title' => 'کاملا ریسپانسیو', 'summary' => 'لورم ایپسوم متن ساختگی...'],
            ['icon' => $this->viewData['assetsPath'] . 'images/16.png', 'title' => 'Tailwind CSS', 'summary' => 'لورم ایپسوم متن ساختگی...'],
        ];

        /*
        $this->viewData['collections'] = [
            ['title' => 'کالکشن پارما. ماژولار', 'slug' => 'collection-parma', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/parma-collection.webp'],
            ['title' => 'کالکشن جنوا', 'slug' => 'genova-collection', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/genova-collection.webp'],
            ['title' => 'کالکشن روما', 'slug' => 'collection-roma', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/roma-collection.webp'],
            ['title' => 'کالکشن ونیز. شزلون و ال شکل', 'slug' => 'collection-venice', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/venice-collection.webp'],
            ['title' => 'کالکشن ریوولی. تکنفره', 'slug' => 'collection-rivoli', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/rivoli-collection.webp'],
            ['title' => 'کالکشن ریلکس. بدون محدودیت!', 'slug' => 'collection-relax', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/relax-collection.webp'],
            ['title' => 'کالکشن مینولا', 'slug' => 'collection-minola', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/minola-collection.webp'],
            ['title' => 'کالکشن چستر فیلیپ', 'slug' => 'collection-chester-philip', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/chester-philip-collection.webp'],
            ['title' => 'کالکشن میلانو. تکنفره', 'slug' => 'collection-milano', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/milano-collection.webp'],
            ['title' => 'کالکشن مارکزا. ریکلاین برقی', 'slug' => 'collection-marchesa', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/marchesa-collection.webp'],
            ['title' => 'کالکشن راستیک', 'slug' => 'collection-rustic', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/rustic-collection.webp'],
            ['title' => 'کالکشن تورین. ریکلاین برقی', 'slug' => 'collection-rustic', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/torino-collection.webp'],
            ['title' => 'کالکشن فلورنس. چرم و پارچه', 'slug' => 'collection-florence', 'thumbnail' => $this->viewData['assetsPath'] . 'images/collection/florence-collection.webp'],

        ];
        */

        $this->viewData['collections'] = $collections;

      /*  $this->viewData['collections'] = [
            ['title' => 'کالکشن شماره یک', 'slug' => 'collection-1', 'thumbnail' => $this->viewData['assetsPath'] . 'images/project-30.jpg'],
            ['title' => 'کالکشن شماره دو', 'slug' => 'collection-2', 'thumbnail' => $this->viewData['assetsPath'] . 'images/blog-2.jpg'],
            ['title' => 'کالکشن شماره سه', 'slug' => 'collection-3', 'thumbnail' => $this->viewData['assetsPath'] . 'images/project-31.jpg'],
            ['title' => 'کالکشن شماره چهار', 'slug' => 'collection-4', 'thumbnail' => $this->viewData['assetsPath'] . 'images/blog-4.jpg'],
        ];*/

        $this->viewData['testimonials'] = [
            ['name' => 'سهیلا صادقی', 'role' => 'طراح گرافیک', 'avatar' => $this->viewData['assetsPath'] . 'images/avatar-2.jpg', 'text' => 'لورم ایپسوم متن ساختگی...'],
            ['name' => 'فرهاد یاسری', 'role' => 'طراح گرافیک', 'avatar' => $this->viewData['assetsPath'] . 'images/avatar-4.jpg', 'text' => 'لورم ایپسوم متن ساختگی...'],
        ];

        $this->viewData['latestPosts'] = [
            ['title' => 'جذاب ترین صندلی مینیمال', 'slug' => 'post-1', 'summary' => 'لورم ایپسوم...', 'thumbnail' => $this->viewData['assetsPath'] . 'images/blog-9.jpg', 'author_name' => 'نوید محمودی', 'author_role' => 'طراح گرافیک', 'author_avatar' => $this->viewData['assetsPath'] . 'images/avatar-1.jpg'],
            ['title' => 'پرفروش ترین مبل ایران', 'slug' => 'post-2', 'summary' => 'لورم ایپسوم...', 'thumbnail' => $this->viewData['assetsPath'] . 'images/blog-3.jpg', 'author_name' => 'سهیلا صادقی', 'author_role' => 'طراح گرافیک', 'author_avatar' => $this->viewData['assetsPath'] . 'images/avatar-2.jpg'],
            ['title' => 'نکات مهم هنگام خرید صندلی', 'slug' => 'post-3', 'summary' => 'لورم ایپسوم...', 'thumbnail' => $this->viewData['assetsPath'] . 'images/blog-10.jpg', 'author_name' => 'سارا توحیدی', 'author_role' => 'طراح گرافیک', 'author_avatar' => $this->viewData['assetsPath'] . 'images/avatar-3.jpg'],
            ['title' => 'صندلی های مینیمال اداری', 'slug' => 'post-4', 'summary' => 'لورم ایپسوم...', 'thumbnail' => $this->viewData['assetsPath'] . 'images/blog-12.jpg', 'author_name' => 'فرهاد یاسری', 'author_role' => 'طراح گرافیک', 'author_avatar' => $this->viewData['assetsPath'] . 'images/avatar-4.jpg'],
        ];

        $this->viewData['partners'] = [
            ['name' => 'شریک ۱', 'logo' => $this->viewData['assetsPath'] . 'images/logo-8.png'],
            ['name' => 'شریک ۲', 'logo' => $this->viewData['assetsPath'] . 'images/logo-9.png'],
            ['name' => 'شریک ۳', 'logo' => $this->viewData['assetsPath'] . 'images/logo-10.png'],
            ['name' => 'شریک ۴', 'logo' => $this->viewData['assetsPath'] . 'images/logo-11.png'],
        ];

        $this->viewData['seo'] = [
            'title'       => 'مارکزا | مبلمان چرم',
            'description' => 'فروشگاه مبلمان چرم مارکزا - بهترین کیفیت، شیک‌ترین طراحی',
        ];

        return view($this->viewPath . 'home/index', $this->viewData);
    }
}