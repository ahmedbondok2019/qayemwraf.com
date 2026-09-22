<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogCategoryTranslation;
use App\Models\BlogComment;
use App\Models\BlogTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds for QayemWraf blog categories and articles.
     *
     * @return void
     */
    public function run()
    {
        // 0. Clean up only obsolete legacy medical records if present (non-destructive)
        $legacySlugs = [
            'home-medical-equipment', 'home-medical-devices', 'medical-devices', 'clinic-equipment', 'home-care',
            'how-to-choose-best-home-blood-pressure-monitor-2026', 'how-to-choose-best-home-blood-pressure-monitor-2026-en'
        ];
        
        if (Schema::hasTable('blog_category_translations')) {
            $legacyCategoryIds = DB::table('blog_category_translations')
                ->whereIn('slug', $legacySlugs)
                ->pluck('blog_category_id')
                ->toArray();
                
            if (!empty($legacyCategoryIds)) {
                DB::table('blogs')->whereIn('blog_category_id', $legacyCategoryIds)->delete();
                DB::table('blog_category_translations')->whereIn('blog_category_id', $legacyCategoryIds)->delete();
                DB::table('blog_categories')->whereIn('id', $legacyCategoryIds)->delete();
            }
        }
        
        if (Schema::hasTable('blog_translations')) {
            $legacyBlogIds = DB::table('blog_translations')
                ->whereIn('slug', $legacySlugs)
                ->pluck('blog_id')
                ->toArray();
                
            if (!empty($legacyBlogIds)) {
                DB::table('blogs')->whereIn('id', $legacyBlogIds)->delete();
                DB::table('blog_translations')->whereIn('blog_id', $legacyBlogIds)->delete();
            }
        }

        // 1. Define Specialized Categories with Articles
        $categoriesData = [
            [
                'slug' => 'warehouse-racking-systems',
                'ar' => [
                    'title' => 'أنظمة الرفوف والمستودعات',
                    'slug' => 'warehouse-racking-systems',
                    'description' => 'يختص بالحلول الهندسية للشركات والمصانع الكبرى، ويغطي أنظمة الأرفف الثقيلة (Heavy Duty & Pallet Racking)، وحدات التخزين متوسطة التحمل (Medium Duty Shelving)، وأنظمة الميزانين (Mezzanine Floors) واستغلال الارتفاعات.',
                    'meta_title' => 'أنظمة الرفوف والمستودعات والباليت راك | قائم ورف',
                    'meta_description' => 'دليلك الهندسي الشامل لأنظمة أرفف المستودعات الثقيلة، الباليت راك، الميزانين، ووحدات التخزين متوسطة التحمل من شركة قائم ورف.',
                    'meta_keywords' => 'أنظمة الرفوف, أرفف مستودعات, باليت راك, أرفف ثقيلة, ميزانين, تخزين صناعي, قائم ورف',
                ],
                'en' => [
                    'title' => 'Warehouse Racking Systems',
                    'slug' => 'warehouse-racking-systems-en',
                    'description' => 'Specialized engineering solutions for large enterprises and factories, covering Heavy Duty & Pallet Racking, Medium Duty Shelving, and Mezzanine Floors to maximize vertical space.',
                    'meta_title' => 'Warehouse Racking Systems & Pallet Racks | QayemWraf',
                    'meta_description' => 'Comprehensive engineering guide to warehouse racking systems, heavy-duty pallet racks, mezzanine floors, and industrial storage by QayemWraf.',
                    'meta_keywords' => 'warehouse racking systems, pallet racking, heavy duty shelving, mezzanine floors, industrial racking, QayemWraf',
                ],
                'blogs' => [
                    [
                        'image' => '/_fixed/news.jpg',
                        'ar' => [
                            'title' => 'دليلك الشامل لاختيار أنظمة الرفوف المعدنية وحلول التخزين الذكية للمستودعات',
                            'slug' => 'guide-choosing-metal-racking-warehouse-storage-solutions',
                            'image' => '/_fixed/news.jpg',
                            'tags' => 'رفوف تخزين معدنية,أنظمة تخزين المستودعات,وحدات هيفي ديوتي,تجهيز مخازن,قائم ورف,أرفف المستودعات,باليت راك',
                            'Author' => 'فريق قائم ورف الهندسي',
                            'meta_title' => 'دليلك الشامل لاختيار أنظمة الرفوف المعدنية للمستودعات | قائم ورف',
                            'meta_description' => 'اكتشف كيف تختار أفضل أنظمة الرفوف المعدنية ووحدات التخزين الثقيل (Heavy Duty) لمستودعك مع «قائم ورف». نصائح لزيادة السعة الاستيعابية وخفض التكاليف.',
                            'meta_keywords' => 'رفوف تخزين معدنية, أنظمة تخزين المستودعات, وحدات هيفي ديوتي, تجهيز مخازن, قائم ورف, رفوف مستودعات, باليت راك',
                            'description' => '
                                <p class="lead">تعتبر إدارة المساحة والتنظيم الداخلي للمخازن والمستودعات من أهم العوامل التي تحسم كفاءة أي نشاط تجاري أو صناعي. إن الاعتماد على أنظمة تخزين عشوائية لا يهدر المساحة فحسب، بل يهدد سلامة البضائع والعاملين. من هنا تأتي أهمية الاستثمار في أنظمة الرفوف المعدنية المصممة هندسياً لتحمل أوزان ثقيلة واستغلال المساحات الرأسية بأعلى كفاءة ممكنة.</p>

                                <h2>1. ما هي أهمية الرفوف المعدنية في تجهيز المخازن؟</h2>
                                <p>توفر وحدات التخزين المعدنية المتطورة حلاً مثالياً لإعادة ترتيب مساحات العمل، ومن أبرز مميزاتها:</p>
                                <ul>
                                    <li><strong>استغلال الارتفاعات الرأسية:</strong> تحويل المساحات المهدرة إلى طاقات تخزينية مضاعفة والاستفادة من كامل الارتفاع المتاح للمستودع.</li>
                                    <li><strong>تسهيل حركة الجرد والنقل:</strong> تسريع عمليات الوصول للمنتجات والمنصات وتقليل وقت التحميل والتفريغ.</li>
                                    <li><strong>الحماية والمتانة:</strong> حماية المنتجات المخزنة من التلف والرطوبة ومخاطر السقوط والحوادث.</li>
                                </ul>

                                <h2>2. أنواع وحدات التخزين والرفوف الصناعية</h2>
                                <p>تختلف أنظمة التخزين بناءً على نوع النشاط وطبيعة البضاعة المراد تخزينها:</p>
                                <ul>
                                    <li><strong>وحدات الرفوف الثقيلة (Heavy Duty & Pallet Racking):</strong> مصممة لتحمل الأوزان العالية والمنصات الخشبية والمعدنية (Pallets)، وتناسب المستودعات الكبرى والمصانع ومراكز التوزيع.</li>
                                    <li><strong>وحدات التخزين متوسطة التحمل (Medium Duty):</strong> ممتازة للأصناف اليدوية والتخزين المتوسط للشركات ومحلات التجزئة ومخازن قطع الغيار والكراتين.</li>
                                    <li><strong>الرفوف المعيارية القابلة للتعديل (Boltless & Modular Shelving):</strong> تتيح لك تغيير المسافات بين المستويات بمرونة عالية لتناسب اختلاف وتغير أحجام المنتجات باستمرار.</li>
                                </ul>

                                <h2>3. كيف تختار نظام التخزين الأنسب لمنشأتك؟</h2>
                                <p>قبل الشراء والتركيب، هناك عدة معايير هندسية أساسية يجب مراعاتها لضمان كفاءة وسلامة المنظومة:</p>
                                <ol>
                                    <li><strong>حجم ووزن الحمولة لكل مستوى:</strong> اختيار سماكة الصاج والحديد ونوع الدهان المناسب (بودرة إلكتروستاتيك) للتحمل والبيئة التشغيلية.</li>
                                    <li><strong>طريقة التحميل (يدوي أم رافعات شوكية؟):</strong> لتحديد المسافات البينية وعرض الممرات (Aisle Width) الآمن لحركة الرافعات.</li>
                                    <li><strong>عوامل الأمان والاشتراطات الصناعية:</strong> التأكد من جودة القوائم (Uprights) والكمرات (Beams) وتثبيتها بالأرضيات الخرسانية بمسامير فيشر صلب بشكل محكم.</li>
                                </ol>

                                <div class="alert alert-primary my-4 p-4 rounded-3">
                                    <h3 class="h4 mb-3">لماذا تختار "قائم ورف" لتجهيز مستودعك؟</h3>
                                    <ul class="mb-0">
                                        <li>دراسة وتصميم هندسي دقيق لمساحة مستودعك لاستغلال كل متر متاح بأعلى سعة تخزينية.</li>
                                        <li>خامات حديد وصاج معتمد مطابقة للمواصفات ومقاومة للصدأ والتآكل والظروف الصناعية.</li>
                                        <li>خدمات توريد وتركيب احترافية تحت إشراف فريق هندسي متخصص وضمان معتمد.</li>
                                    </ul>
                                </div>

                                <h3>خاتمة ودعوة لاتخاذ قرار:</h3>
                                <p>هل ترغب في إعادة تنظيم مستودعك وزيادة طاقته الاستيعابية بأفضل معايير الأمان؟ تواصل مع فريق <strong>قائم ورف</strong> الآن لتحصل على استشارة فنية ومعاينة هندسية وعرض سعر مخصص لمشروعك!</p>
                            ',
                        ],
                        'en' => [
                            'title' => 'Industrial Metal Racking & Storage Shelving: The Ultimate Guide to Warehouse Optimization',
                            'slug' => 'industrial-metal-racking-storage-shelving-guide',
                            'image' => '/_fixed/news.jpg',
                            'tags' => 'Industrial racking systems,metal storage shelves,warehouse storage solutions,heavy-duty shelving,Qayem & Raf,pallet racking',
                            'Author' => 'Qayem & Raf Engineering Team',
                            'meta_title' => 'Industrial Metal Racking & Storage Shelving Guide | Qayem & Raf',
                            'meta_description' => 'Maximize your storage space and boost efficiency with durable metal racking and heavy-duty shelving systems from Qayem & Raf. Explore smart warehouse storage solutions.',
                            'meta_keywords' => 'Industrial racking systems, metal storage shelves, warehouse storage solutions, heavy-duty shelving, Qayem & Raf, pallet racking',
                            'description' => '
                                <p class="lead">In modern supply chain management and retail operations, warehouse efficiency directly impacts your bottom line. Traditional storage methods often lead to wasted floor space, damaged goods, and slow fulfillment processes. Investing in high-grade metal storage shelves and industrial racking systems is the most effective way to turn vertical airspace into valuable, secure storage capacity.</p>

                                <h2>1. Why High-Quality Racking Systems Are Essential</h2>
                                <p>Equipping your warehouse with engineered shelving units provides critical operational advantages:</p>
                                <ul>
                                    <li><strong>Maximizing Vertical Space:</strong> Utilize the entire height of your facility rather than just floor square footage, doubling your holding capacity.</li>
                                    <li><strong>Enhanced Safety and Durability:</strong> Heavy-duty steel structures prevent collapse risks, absorb dynamic loads, and safeguard inventory and personnel.</li>
                                    <li><strong>Streamlined Inventory Management:</strong> Clear labeling, rapid forklift access, and accelerated loading/unloading cycles improve overall order fulfillment.</li>
                                </ul>

                                <h2>2. Key Types of Industrial Storage Systems</h2>
                                <p>Depending on your operational requirements, payload weights, and handling equipment:</p>
                                <ul>
                                    <li><strong>Heavy-Duty Pallet Racking:</strong> Built to support extreme load capacities (up to tons per level), ideal for forklifts, bulk goods, and large distribution centers.</li>
                                    <li><strong>Medium-Duty Shelving Units:</strong> Designed for manual hand-loading, cartons, bins, and small-to-medium parts with robust load ratings.</li>
                                    <li><strong>Adjustable Boltless / Modular Shelves:</strong> Highly versatile units that allow fast height adjustments to match changing inventory sizes without complex tools.</li>
                                </ul>

                                <h2>3. Crucial Factors to Consider Before Buying</h2>
                                <p>To choose the right configuration for your facility, evaluate:</p>
                                <ol>
                                    <li><strong>Weight capacity per level:</strong> Ensure the uprights and beams support your heaviest load margins with safety tolerance ratios.</li>
                                    <li><strong>Aisle width & handling equipment:</strong> Verify sufficient clearance for manual carts, reach trucks, or full-size forklifts.</li>
                                    <li><strong>Corrosion & surface finish:</strong> Opt for electrostatically powder-coated steel to resist rust, moisture, and industrial wear.</li>
                                </ol>

                                <div class="alert alert-primary my-4 p-4 rounded-3">
                                    <h3 class="h4 mb-3">Transform Your Warehouse with Qayem & Raf</h3>
                                    <p>At Qayem & Raf, we specialize in designing, supplying, and installing tailored metal racking and warehouse solutions. Our products are engineered for maximum stability, load capacity, and long-term durability.</p>
                                    <ul class="mb-0">
                                        <li>Customized AutoCAD warehouse layout design and load optimization.</li>
                                        <li>Heavy-duty certified steel components with high corrosion resistance.</li>
                                        <li>Professional turnkey supply, delivery, and certified installation.</li>
                                    </ul>
                                </div>

                                <h3>Ready to upgrade your storage facility?</h3>
                                <p>Contact <strong>Qayem & Raf</strong> today for expert site planning, free consultation, and custom competitive quotes tailored to your business needs.</p>
                            ',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'warehouse-setup-planning',
                'ar' => [
                    'title' => 'تجهيز وتأسيس المخازن',
                    'slug' => 'warehouse-setup-planning',
                    'description' => 'يركز على الجانب التخطيطي والإداري للمساحات، كيفية تخطيط وتصميم مساحات التخزين لاستيعاب أقصى حمولة، حساب مسارات الرافعات الشوكية وعروض الممرات، ونصائح تنظيم الجرد وتسهيل عمليات الشحن والتفريغ.',
                    'meta_title' => 'تجهيز وتأسيس وتخطيط المخازن والمستودعات | قائم ورف',
                    'meta_description' => 'أفضل الطرق والخطوات الهندسية لتأسيس وتخطيط مساحات المستودعات وتحديد ممرات الرافعات وتسهيل حركة البضائع مع قائم ورف.',
                    'meta_keywords' => 'تجهيز مخازن, تأسيس المستودعات, تخطيط المخازن, مسارات الرافعات الشوكية, تنظيم الجرد, عمليات الشحن والتفريغ, قائم ورف',
                ],
                'en' => [
                    'title' => 'Warehouse Setup & Planning',
                    'slug' => 'warehouse-setup-planning-en',
                    'description' => 'Focuses on space layout and operational planning: designing storage areas for maximum load capacity, calculating forklift aisles and lane widths, and optimizing inventory and dispatch workflows.',
                    'meta_title' => 'Warehouse Setup, Layout & Planning | QayemWraf',
                    'meta_description' => 'Engineering tips and guidelines for warehouse layout planning, forklift aisle sizing, and streamlining material handling operations with QayemWraf.',
                    'meta_keywords' => 'warehouse setup, warehouse planning, layout design, forklift aisles, storage optimization, warehouse logistics, QayemWraf',
                ],
                'blogs' => [
                    [
                        'image' => '/_fixed/news.jpg',
                        'ar' => [
                            'title' => 'أنظمة الرفوف متوسطة التحمل (Medium Duty): الحل العملي لتنظيم المستودعات الداخلية ومخازن التجزئة',
                            'slug' => 'medium-duty-shelving-systems-guide',
                            'image' => '/_fixed/news.jpg',
                            'tags' => 'رفوف متوسطة التحمل,أنظمة تخزين المستودعات,تجهيز غرف التخزين,قواطع شبكية للمخازن,قائم ورف,مخازن التجزئة,Medium Duty Racks',
                            'Author' => 'فريق قائم ورف الهندسي',
                            'meta_title' => 'أنظمة الرفوف متوسطة التحمل لتنظيم المستودعات | قائم ورف',
                            'meta_description' => 'اكتشف مميزات الرفوف المعدنية متوسطة التحمل (Medium Duty) لتنظيم المستودعات الداخلية والمحلات التجارية مع «قائم ورف». أمان، مرونة، واستغلال مثالي للمساحات.',
                            'meta_keywords' => 'رفوف متوسطة التحمل, أنظمة تخزين المستودعات, تجهيز غرف التخزين, قواطع شبكية للمخازن, قائم ورف, تخزين يدوي, رفوف ميدي ديوتي',
                            'description' => '
                                <p class="lead">تواجه العديد من الشركات والأنشطة التجارية تحدياً كبيراً في تنظيم المنتجات اليدوية والبضائع التي لا تتطلب بالضرورة رافعات شوكية ثقيلة، لكنها تحتاج في الوقت ذاته إلى هياكل قوية وثابتة تتحمل الاستخدام اليومي المستمر. هنا تبرز أنظمة الرفوف متوسطة التحمل (Medium Duty Racks) كخيار هندسي متوازن يجمع بين المتانة العالية والمرونة القصوى في التعديل والترتيب.</p>

                                <h2>1. ما هي أنظمة التخزين متوسطة التحمل؟</h2>
                                <p>صُممت هذه الوحدات لتتحمل أوزاناً تتراوح غالباً بين 150 إلى 500 كجم لكل مستوى/رف، وتتميز بهيكل مكوّن من قوائم حديدية صلبة وكمرات مدعمة، وألواح صاج مسطحة تتيح رص الكراتين والقطع المفردة بسهولة وأمان.</p>

                                <h3>أبرز الاستخدامات:</h3>
                                <ul>
                                    <li>مخازن قطع الغيار ومستلزمات الصيانة والورش.</li>
                                    <li>المستودعات الداخلية لشركات التجارة الإلكترونية ومراكز التوزيع السريع.</li>
                                    <li>المخازن الخلفية لمحلات التجزئة والمعارض والسوبرماركت.</li>
                                    <li>غرف الحفظ والأرشيف والمستلزمات الطبية والأدوية.</li>
                                </ul>

                                <h2>2. دمج الأرفف مع القواطع والشبك الأمني</h2>
                                <p>كما يظهر في التطبيقات الهندسية العملية، يفضل الكثير من مديري المخازن دمج وحدات الأرفف مع قواطع شبكية معدنية (Wire Mesh Partitions)، وذلك لتحقيق عدة مزايا استراتيجية:</p>
                                <ul>
                                    <li><strong>تأمين الأصناف الهامة:</strong> عزل وحماية البضائع عالية القيمة أو التي تتطلب إشرافاً مخصصاً داخل أقفاص وشبك أمني مقفل.</li>
                                    <li><strong>التهوية والإضاءة:</strong> السماح بمرور الهواء والضوء الطبيعي ومياه رشاشات الحريق، مما يقلل مخاطر الرطوبة ويحقق اشتراطات السلامة.</li>
                                    <li><strong>تقسيم مناطق العمل:</strong> تنظيم مسارات التحضير والتجهيز والفصل الدقيق بين مساحات الاستلام والتسليم والفحص.</li>
                                </ul>

                                <h2>3. مزايا الاعتماد على حلول "قائم ورف"</h2>
                                <ul>
                                    <li><strong>تصميمات معيارية قابلة للتعديل:</strong> سهولة تامة في تغيير ورفع ارتفاعات الأرفف وفقاً لتغير أحجام البضائع والكراتين.</li>
                                    <li><strong>طلاء مقاوم للتآكل والخدوش:</strong> دهانات بودرة حرارية إلكتروستاتيك معالجة ضد الرطوبة وعوامل الصدأ لضمان عمر تشغيلي ممتد.</li>
                                    <li><strong>توزيع مدروس للأحمال:</strong> قواعد تثبيت أرضية خرسانية تمنع أي اهتزاز وتضمن أقصى درجات السلامة المهنية للكوادر والعمالة.</li>
                                </ul>

                                <div class="alert alert-primary my-4 p-4 rounded-3">
                                    <h3 class="h4 mb-3">هل تخطط لإعادة ترتيب مخزنك الداخلي؟</h3>
                                    <p class="mb-0">سواء كنت ترغب في إنشاء مساحة تخزين منظمة تلبي نمو مبيعاتك أو ترقية مستودعك الحالي، تواصل اليوم مع فريق <strong>«قائم ورف»</strong> لمعاينة موقعك وتقديم أفضل الحلول التخزينية المناسبة لميزانيتك ومساحتك بأعلى معايير الجودة.</p>
                                </div>
                            ',
                        ],
                        'en' => [
                            'title' => 'Medium-Duty Steel Shelving Systems: Maximizing Efficiency in Commercial Backrooms and Warehouses',
                            'slug' => 'medium-duty-steel-shelving-systems-efficiency',
                            'image' => '/_fixed/news.jpg',
                            'tags' => 'Medium duty shelving,industrial steel racks,warehouse partition mesh,retail storage solutions,Qayem & Raf,commercial backrooms',
                            'Author' => 'Qayem & Raf Engineering Team',
                            'meta_title' => 'Medium-Duty Steel Shelving Systems Guide | Qayem & Raf',
                            'meta_description' => 'Explore high-durability medium-duty steel shelving and wire mesh partition solutions from Qayem & Raf. Optimize your stockroom space and boost operational speed.',
                            'meta_keywords' => 'Medium duty shelving, industrial steel racks, warehouse partition mesh, retail storage solutions, Qayem & Raf, stockroom optimization',
                            'description' => '
                                <p class="lead">Not every commercial operation handles multi-ton palletized cargo requiring heavy forklifts. Many businesses require organized, high-density manual access for medium-weight boxes, industrial components, or fast-moving consumer goods. Medium-duty steel shelving systems provide the perfect intersection between structural strength, modular versatility, and cost efficiency.</p>

                                <h2>1. Why Medium-Duty Shelving is a Smart Investment</h2>
                                <p>Designed to handle loads between 150 kg and 500 kg per level, these units deliver dependable performance for active stockrooms:</p>
                                <ul>
                                    <li><strong>Hand-Loaded Efficiency:</strong> Ideal for picking operations, e-commerce packing areas, and parts distribution.</li>
                                    <li><strong>Modular Beam Adjustability:</strong> Level heights can be easily adjusted to match changing product carton sizes without complex re-engineering.</li>
                                    <li><strong>Durability & Finish:</strong> Formed from high-grade cold-rolled steel with durable electrostatic powder coating to resist chipping, abrasion, and moisture.</li>
                                </ul>

                                <h3>Key Applications:</h3>
                                <ul>
                                    <li>Spare parts warehouses and maintenance workshops.</li>
                                    <li>E-commerce fulfillment centers and rapid order sorting facilities.</li>
                                    <li>Commercial backrooms, retail storerooms, and showroom inventory.</li>
                                    <li>Medical storage, archival document rooms, and pharmaceutical facilities.</li>
                                </ul>

                                <h2>2. Enhancing Security with Wire Mesh Enclosures</h2>
                                <p>Pairing metal racks with industrial wire mesh partitions adds strategic operational value to commercial warehouses:</p>
                                <ul>
                                    <li><strong>Secured Inventory Control:</strong> Protect high-value tools, electronics, or sensitive items behind lockable mesh enclosures.</li>
                                    <li><strong>Optimal Airflow & Light Penetration:</strong> Retains full visibility and fire sprinkler coverage while keeping operations safe and compliant with civil defense standards.</li>
                                    <li><strong>Logical Zoning:</strong> Clearly delineates staging, quarantine, packaging, and stock inspection zones.</li>
                                </ul>

                                <h2>3. The Qayem & Raf Advantage</h2>
                                <p>At <strong>Qayem & Raf</strong>, we design storage infrastructure tailored to your exact facility layout:</p>
                                <ul>
                                    <li>Custom shelf dimensions and certified load-rated beams.</li>
                                    <li>Complete turn-key service: AutoCAD layout planning, rapid delivery, and certified on-site assembly.</li>
                                    <li>Rigorous safety adherence to protect staff and protect valuable inventory against tip-over risks.</li>
                                </ul>

                                <div class="alert alert-primary my-4 p-4 rounded-3">
                                    <h3 class="h4 mb-3">Ready to Optimize Your Storage Facility?</h3>
                                    <p class="mb-0">Upgrade your operational workflow with tailored storage layouts. Contact <strong>Qayem & Raf</strong> today for a professional site evaluation, technical drawings, and a custom quotation.</p>
                                </div>
                            ',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'safety-and-inspection',
                'ar' => [
                    'title' => 'السلامة والصيانة الصناعية',
                    'slug' => 'safety-and-inspection',
                    'description' => 'يخدم أصحاب الأعمال والمهندسين المهتمين بمعايير الأمان، معايير السلامة المهنية ومقاومة الحوادث وانهيار الأرفف، إرشادات الصيانة الدورية للأرفف المعدنية واختبارات الأحمال، وطرق الحماية من الصدأ والتآكل.',
                    'meta_title' => 'معايير السلامة والصيانة الصناعية للأرفف | قائم ورف',
                    'meta_description' => 'دليل السلامة المهنية في المستودعات، إرشادات الصيانة الدورية للأرفف المعدنية، اختبارات الأحمال، وطرق مقاومة الصدأ والتآكل.',
                    'meta_keywords' => 'سلامة المستودعات, صيانة الأرفف, اختبارات الأحمال, السلامة المهنية, حماية من الصدأ, فحص الأرفف, قائم ورف',
                ],
                'en' => [
                    'title' => 'Safety & Industrial Inspection',
                    'slug' => 'safety-and-inspection-en',
                    'description' => 'Dedicated to safety standards and facility management: occupational safety regulations, rack collapse prevention, periodic rack inspections, load capacity testing, and anti-corrosion protection.',
                    'meta_title' => 'Industrial Warehouse Safety & Rack Inspection | QayemWraf',
                    'meta_description' => 'Crucial warehouse safety standards, rack load capacity testing, periodic inspection protocols, and anti-corrosion protection standards by QayemWraf.',
                    'meta_keywords' => 'warehouse safety, rack inspection, load testing, occupational safety, corrosion protection, rack maintenance, QayemWraf',
                ],
                'blogs' => [],
            ],
            [
                'slug' => 'retail-commercial-storage',
                'ar' => [
                    'title' => 'حلول التخزين التجاري ومحلات التجزئة',
                    'slug' => 'retail-commercial-storage',
                    'description' => 'موجه للأنشطة التجارية والمتاجر: أرفف السوبرماركت والمحلات التجارية (Gondola Shelving)، وحدات التخزين الخفيفة والقابلة للتعديل (Boltless Shelving)، وأفكار تنظيم المخازن الخلفية (Backrooms) للمحلات.',
                    'meta_title' => 'حلول التخزين التجاري وأرفف السوبرماركت والتجزئة | قائم ورف',
                    'meta_description' => 'استكشف أفضل حلول أرفف المحلات التجارية والسوبرماركت (جوندولا) والأرفف سهلة التركيب بدون مسامير لتنظيم بضائع التجزئة والمخازن الخلفية.',
                    'meta_keywords' => 'أرفف سوبرماركت, أرفف محلات, أرفف بدون مسامير, تخزين تجاري, تنظيم المخازن الخلفية, جوندولا, قائم ورف',
                ],
                'en' => [
                    'title' => 'Retail & Commercial Storage Solutions',
                    'slug' => 'retail-commercial-storage-en',
                    'description' => 'Tailored for retail businesses and small to medium stores: Supermarket Gondola Shelving, flexible boltless light shelving units, and retail backroom space optimization strategies.',
                    'meta_title' => 'Retail & Commercial Storage Solutions | QayemWraf',
                    'meta_description' => 'Explore top commercial shelving, supermarket gondola displays, and adjustable boltless storage units for retail stores and backroom stock.',
                    'meta_keywords' => 'retail shelving, supermarket racks, gondola shelving, boltless shelves, commercial storage, retail backrooms, QayemWraf',
                ],
                'blogs' => [],
            ],
            [
                'slug' => 'projects-case-studies',
                'ar' => [
                    'title' => 'دراسات حالة وأعمال من الواقع',
                    'slug' => 'projects-case-studies',
                    'description' => 'يساعد على كسب ثقة العملاء وإثبات الكفاءة: تغطية مشاريع تجهيز مستودعات فعلية تم تنفيذها، مقارنات قبل وبعد تجهيز المساحة بالأرفف المعدنية، وتقارير وتجارب العملاء مع منتجات وخدمات «قائم ورف».',
                    'meta_title' => 'دراسات حالة ومشاريع واقعية لتجهيز المستودعات | قائم ورف',
                    'meta_description' => 'شاهد أعمال ومشاريع شركة قائم ورف في تجهيز المخازن والمستودعات ومقارنات قبل وبعد وقصص نجاح عملائنا.',
                    'meta_keywords' => 'مشاريع قائم ورف, تجهيز مستودعات, دراسات حالة, قبل وبعد, تركيب أرفف, قصص نجاح المستودعات',
                ],
                'en' => [
                    'title' => 'Projects & Case Studies',
                    'slug' => 'projects-case-studies-en',
                    'description' => 'Demonstrating real-world expertise and social proof: coverage of completed warehouse setup projects, before & after storage transformations, and client success stories with QayemWraf.',
                    'meta_title' => 'Warehouse Projects & Real-World Case Studies | QayemWraf',
                    'meta_description' => 'Discover real-world warehouse racking projects, before-and-after storage transformations, and turnkey installation case studies delivered by QayemWraf.',
                    'meta_keywords' => 'warehouse projects, case studies, rack installation, before after storage, client testimonials, QayemWraf',
                ],
                'blogs' => [],
            ],
        ];

        // 2. Insert or Update Categories without deleting anything
        $catIndex = 0;
        foreach ($categoriesData as $catGroup) {
            $catIndex++;
            
            // Check if category exists by Arabic or English slug
            $existingCatTrans = BlogCategoryTranslation::where('slug', Str::slug($catGroup['ar']['slug']))
                ->orWhere('slug', Str::slug($catGroup['en']['slug']))
                ->first();

            if ($existingCatTrans) {
                $category = BlogCategory::find($existingCatTrans->blog_category_id);
            } else {
                $category = BlogCategory::create([
                    'view_index' => $catIndex,
                    'status' => true,
                ]);
            }

            foreach (['ar', 'en'] as $lang) {
                BlogCategoryTranslation::firstOrCreate(
                    [
                        'blog_category_id' => $category->id,
                        'lang_id' => $lang,
                    ],
                    [
                        'title' => $catGroup[$lang]['title'],
                        'slug' => Str::slug($catGroup[$lang]['slug']),
                        'description' => $catGroup[$lang]['description'],
                        'meta_title' => $catGroup[$lang]['meta_title'],
                        'meta_description' => $catGroup[$lang]['meta_description'],
                        'meta_keywords' => $catGroup[$lang]['meta_keywords'],
                    ]
                );
            }

            // 3. Insert Category Blogs safely (Never overwrites or deletes existing articles/images!)
            if (! empty($catGroup['blogs'])) {
                $blogIndex = 0;
                foreach ($catGroup['blogs'] as $blogData) {
                    $blogIndex++;
                    
                    // Check if blog exists by Arabic or English slug or title
                    $existingBlogTrans = BlogTranslation::where('slug', Str::slug($blogData['ar']['slug']))
                        ->orWhere('slug', Str::slug($blogData['en']['slug']))
                        ->orWhere('title', $blogData['ar']['title'])
                        ->orWhere('title', $blogData['en']['title'])
                        ->first();

                    if ($existingBlogTrans) {
                        $blog = Blog::find($existingBlogTrans->blog_id);
                    } else {
                        $blog = Blog::create([
                            'blog_category_id' => $category->id,
                            'view_index' => $blogIndex,
                            'status' => true,
                        ]);
                    }

                    foreach (['ar', 'en'] as $lang) {
                        $existingTrans = BlogTranslation::where('blog_id', $blog->id)
                            ->where('lang_id', $lang)
                            ->first();

                        // Only create if translation does not exist; NEVER overwrite existing user-edited data/images!
                        if (! $existingTrans) {
                            $cardImg = $blogData[$lang]['card_image'] ?? $blogData[$lang]['image'] ?? '/_fixed/news.jpg';
                            $innerImg = $blogData[$lang]['inner_image'] ?? $blogData[$lang]['image'] ?? '/_fixed/news.jpg';

                            BlogTranslation::create([
                                'blog_id' => $blog->id,
                                'lang_id' => $lang,
                                'title' => $blogData[$lang]['title'],
                                'slug' => Str::slug($blogData[$lang]['slug']),
                                'image' => $cardImg,
                                'card_image' => $cardImg,
                                'inner_image' => $innerImg,
                                'tags' => $blogData[$lang]['tags'],
                                'description' => $blogData[$lang]['description'],
                                'Author' => $blogData[$lang]['Author'],
                                'meta_title' => $blogData[$lang]['meta_title'],
                                'meta_description' => $blogData[$lang]['meta_description'],
                                'meta_keywords' => $blogData[$lang]['meta_keywords'],
                            ]);
                        }
                    }
                }
            }
        }
    }
}
