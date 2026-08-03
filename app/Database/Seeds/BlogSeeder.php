<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use RuntimeException;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $thumbnailPaths = [
            'leather-sofa-buying-guide' => 'assets/images/blog/marchesa-banner-4.jpg',
            'natural-leather-care' => 'assets/images/blog/marchesa-banner-2.jpg',
            'sofa-color-for-interior-design' => 'assets/images/blog/about-in-a-row-1.webp',
            'modern-living-room-layout' => 'assets/images/blog/1781648941_Untitled-1-Recovered.webp',
        ];

        if ($this->db->table('blog_post')->countAllResults() > 0) {
            foreach ($thumbnailPaths as $slug => $thumbnail) {
                $this->db->table('blog_post')
                    ->where('slug', $slug)
                    ->update(['thumbnail' => $thumbnail]);
            }

            $leatherCarePost = $this->db->table('blog_post')
                ->select('id')
                ->where('slug', 'natural-leather-care')
                ->get()
                ->getRowArray();

            if ($leatherCarePost !== null) {
                $this->db->table('blog_post_block')
                    ->where('post_id', $leatherCarePost['id'])
                    ->where('block_type', 'image')
                    ->update([
                        'image_path' => 'assets/images/blog/about-3.webp',
                        'alt_text' => 'استادکار در حال آماده‌سازی چرم طبیعی',
                        'caption' => 'کیفیت نهایی محصول از انتخاب و آماده‌سازی دقیق چرم آغاز می‌شود.',
                        'updated_at' => time(),
                    ]);
            }

            return;
        }

        $user = $this->db->table('user')
            ->select('id')
            ->where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->get()
            ->getRowArray();

        if ($user === null) {
            throw new RuntimeException('An active user is required before seeding blog posts.');
        }

        $now = time();
        $posts = [
            [
                'user_id' => $user['id'],
                'title' => 'راهنمای انتخاب مبل چرمی برای فضای نشیمن',
                'slug' => 'leather-sofa-buying-guide',
                'excerpt' => 'برای انتخاب یک مبل چرمی ماندگار باید ابعاد فضا، کیفیت چرم و فرم نشیمن را هم‌زمان در نظر گرفت.',
                'thumbnail' => $thumbnailPaths['leather-sofa-buying-guide'],
                'banner' => 'assets/images/blog-1.jpg',
                'meta_title' => 'راهنمای انتخاب مبل چرمی | مارکزا هوم',
                'meta_description' => 'نکات مهم انتخاب مبل چرمی متناسب با فضای نشیمن، سبک دکوراسیون و نیازهای روزمره.',
                'is_active' => 1,
                'sort_order' => 1,
                'created_at' => $now - 86400,
                'updated_at' => $now - 86400,
            ],
            [
                'user_id' => $user['id'],
                'title' => 'روش صحیح نگهداری از چرم طبیعی',
                'slug' => 'natural-leather-care',
                'excerpt' => 'چرم طبیعی با مراقبت اصولی، زیبایی و انعطاف خود را برای سال‌ها حفظ می‌کند.',
                'thumbnail' => $thumbnailPaths['natural-leather-care'],
                'banner' => 'assets/images/blog-4.jpg',
                'meta_title' => 'نگهداری از چرم طبیعی مبلمان | مارکزا هوم',
                'meta_description' => 'روش تمیز کردن، محافظت و افزایش طول عمر چرم طبیعی مبلمان.',
                'is_active' => 1,
                'sort_order' => 2,
                'created_at' => $now - 172800,
                'updated_at' => $now - 172800,
            ],
            [
                'user_id' => $user['id'],
                'title' => 'انتخاب رنگ مبل متناسب با دکوراسیون خانه',
                'slug' => 'sofa-color-for-interior-design',
                'excerpt' => 'رنگ مبل می‌تواند تعادل بصری فضا را کامل کند یا به نقطه کانونی دکوراسیون تبدیل شود.',
                'thumbnail' => $thumbnailPaths['sofa-color-for-interior-design'],
                'banner' => 'assets/images/blog-6.jpg',
                'meta_title' => 'راهنمای انتخاب رنگ مبل | مارکزا هوم',
                'meta_description' => 'چگونه رنگ مبل را با نور، کف‌پوش و سبک دکوراسیون خانه هماهنگ کنیم.',
                'is_active' => 1,
                'sort_order' => 3,
                'created_at' => $now - 259200,
                'updated_at' => $now - 259200,
            ],
            [
                'user_id' => $user['id'],
                'title' => 'اصول چیدمان مبلمان در نشیمن‌های مدرن',
                'slug' => 'modern-living-room-layout',
                'excerpt' => 'یک چیدمان درست، مسیر حرکت را آزاد نگه می‌دارد و گفت‌وگو و آرامش را در مرکز فضا قرار می‌دهد.',
                'thumbnail' => $thumbnailPaths['modern-living-room-layout'],
                'banner' => 'assets/images/blog-8.jpg',
                'meta_title' => 'اصول چیدمان مبلمان مدرن | مارکزا هوم',
                'meta_description' => 'نکات کاربردی برای چیدمان متعادل و راحت مبلمان در فضای نشیمن مدرن.',
                'is_active' => 1,
                'sort_order' => 4,
                'created_at' => $now - 345600,
                'updated_at' => $now - 345600,
            ],
        ];

        $this->db->table('blog_post')->insertBatch($posts);

        $postIds = [];
        $rows = $this->db->table('blog_post')->select('id, slug')->get()->getResultArray();
        foreach ($rows as $row) {
            $postIds[$row['slug']] = $row['id'];
        }

        $blocks = [];
        $articleBlocks = [
            'leather-sofa-buying-guide' => [
                ['heading', 'تناسب مبل با ابعاد فضای شما', null, null, null, 2],
                ['text', 'پیش از انتخاب مدل، طول دیوارها، فاصله مسیرهای رفت‌وآمد و محل قرارگیری میز جلو مبلی را اندازه‌گیری کنید. مبل بزرگ در فضای محدود، حتی اگر طراحی زیبایی داشته باشد، آرامش بصری محیط را از بین می‌برد.', null, null, null, 2],
                ['image', null, 'assets/images/blog-2.jpg', 'مبل تک‌نفره در فضای نشیمن روشن', 'ابعاد مناسب، تنفس بصری بیشتری به چیدمان می‌دهد.', 2],
                ['heading', 'کیفیت چرم را از نزدیک بررسی کنید', null, null, null, 2],
                ['text', 'چرم طبیعی مرغوب بافتی زنده و لمس گرم دارد. یکنواخت نبودن بسیار جزئی سطح چرم بخشی از هویت طبیعی آن است. کیفیت دوخت، کشش مناسب روکش و تمیزی اتصال قطعات نیز به اندازه خود چرم اهمیت دارد.', null, null, null, 2],
                ['quote', 'مبل مناسب فقط یک وسیله نیست؛ بخشی از تجربه روزانه خانه و نقطه آغاز آرامش در فضای نشیمن است.', null, null, null, 2],
            ],
            'natural-leather-care' => [
                ['heading', 'گردوغبار را به‌آرامی پاک کنید', null, null, null, 2],
                ['text', 'برای نظافت روزمره از یک دستمال نرم و خشک استفاده کنید. در صورت نیاز، دستمال کمی مرطوب باشد و بلافاصله سطح چرم را خشک کنید. مواد شوینده خانگی و محلول‌های الکلی می‌توانند به پوشش محافظ چرم آسیب بزنند.', null, null, null, 2],
                ['image', null, 'assets/images/blog/about-3.webp', 'استادکار در حال آماده‌سازی چرم طبیعی', 'کیفیت نهایی محصول از انتخاب و آماده‌سازی دقیق چرم آغاز می‌شود.', 2],
                ['heading', 'فاصله از نور و حرارت مستقیم', null, null, null, 2],
                ['text', 'قرار گرفتن طولانی‌مدت در برابر آفتاب، بخاری یا شوفاژ ممکن است باعث خشکی و تغییر رنگ چرم شود. بهتر است میان مبل و منبع حرارت فاصله‌ای مناسب وجود داشته باشد و پرده‌ها در ساعت‌های پرنور روز بسته شوند.', null, null, null, 2],
                ['quote', 'رسیدگی منظم و ملایم، بسیار مؤثرتر از تمیزکاری سنگین و دیرهنگام است.', null, null, null, 2],
            ],
            'sofa-color-for-interior-design' => [
                ['heading', 'از نور طبیعی فضا شروع کنید', null, null, null, 2],
                ['text', 'رنگ‌ها در نورهای مختلف ظاهر متفاوتی دارند. برای فضاهای کم‌نور، رنگ‌های روشن و گرم می‌توانند محیط را بازتر نشان دهند؛ در مقابل، فضاهای پرنور ظرفیت استفاده از رنگ‌های عمیق‌تر را دارند.', null, null, null, 2],
                ['image', null, 'assets/images/blog-7.jpg', 'هماهنگی رنگ مبل با دکوراسیون مینیمال', 'نمونه رنگ را همیشه در نور واقعی فضای خانه بررسی کنید.', 2],
                ['heading', 'تعادل میان رنگ‌های اصلی و مکمل', null, null, null, 2],
                ['text', 'اگر دیوار و کف‌پوش خنثی هستند، مبل می‌تواند نقش رنگ اصلی را ایفا کند. اگر فضای شما از قبل رنگ‌های متنوعی دارد، انتخاب یک روکش آرام و خنثی نتیجه‌ای ماندگارتر خواهد داشت. کوسن‌ها بهترین ابزار برای افزودن رنگ‌های فصلی هستند.', null, null, null, 2],
                ['quote', 'رنگ درست، رنگی است که علاوه بر زیبایی امروز، پس از تغییر جزئیات دکوراسیون همچنان هماهنگ باقی بماند.', null, null, null, 2],
            ],
            'modern-living-room-layout' => [
                ['heading', 'نقطه کانونی نشیمن را مشخص کنید', null, null, null, 2],
                ['text', 'پنجره بزرگ، شومینه، اثر هنری یا حتی خود مبلمان می‌تواند نقطه کانونی باشد. جهت اصلی چیدمان را بر اساس این نقطه انتخاب کنید و اجازه دهید سایر عناصر در خدمت آن قرار بگیرند.', null, null, null, 2],
                ['image', null, 'assets/images/blog-11.jpg', 'چیدمان مبلمان در نشیمن مدرن', 'فاصله‌های حساب‌شده، رفت‌وآمد را ساده و فضا را منظم می‌کند.', 2],
                ['heading', 'فضای گفت‌وگو بسازید', null, null, null, 2],
                ['text', 'نشیمن‌ها را آن‌قدر از هم دور نکنید که ارتباط افراد دشوار شود. میز مرکزی باید در دسترس باشد، اما مسیر حرکت را مسدود نکند. در سالن‌های بزرگ می‌توان با یک فرش، محدوده گفت‌وگو را از سایر بخش‌ها جدا کرد.', null, null, null, 2],
                ['quote', 'چیدمان موفق میان زیبایی، آسایش و حرکت آزادانه تعادل برقرار می‌کند.', null, null, null, 2],
            ],
        ];

        foreach ($articleBlocks as $slug => $items) {
            foreach ($items as $index => $item) {
                $blocks[] = [
                    'post_id' => $postIds[$slug],
                    'block_type' => $item[0],
                    'content' => $item[1],
                    'image_path' => $item[2],
                    'alt_text' => $item[3],
                    'caption' => $item[4],
                    'heading_level' => $item[5],
                    'sort_order' => $index + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        $this->db->table('blog_post_block')->insertBatch($blocks);
    }
}
