<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogCategoryTranslation;
use App\Models\BlogTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds for EgiMedical blog articles.
     *
     * @return void
     */
    public function run()
    {
        // 0. Clean up existing blog records to ensure clean state
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BlogTranslation::truncate();
        Blog::truncate();
        BlogCategoryTranslation::truncate();
        BlogCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Define Blog Categories
        $categoriesData = [
            [
                'ar' => [
                    'title' => 'الأجهزة الطبية المنزلية',
                    'slug' => 'home-medical-equipment',
                    'description' => 'دليلك الشامل لاختيار واستخدام الأجهزة الطبية في المنزل كأجهزة قياس الضغط والسكر وأجهزة التنفس.',
                    'meta_title' => 'الأجهزة الطبية المنزلية | EgiMedical',
                    'meta_description' => 'استكشف أحدث الأجهزة الطبية المنزلية وطرق اختيار جهاز قياس الضغط ومولدات الأكسجين المناسبة لك.',
                    'meta_keywords' => 'أجهزة طبية, جهاز قياس الضغط, مولد أكسجين, قياس السكر, EgiMedical',
                ],
                'en' => [
                    'title' => 'Home Medical Devices',
                    'slug' => 'home-medical-devices',
                    'description' => 'Your comprehensive guide to selecting and using home healthcare devices like BP monitors, glucometers, and concentrators.',
                    'meta_title' => 'Home Medical Devices | EgiMedical',
                    'meta_description' => 'Explore the latest home healthcare monitors, blood pressure cuffs, and oxygen concentrators.',
                    'meta_keywords' => 'medical devices, blood pressure monitor, oxygen concentrator, glucometer, EgiMedical',
                ],
                'blogs' => [
                    [
                        'ar' => [
                            'title' => 'كيف تختار أفضل جهاز قياس ضغط الدم المنزلي لعام 2026؟',
                            'slug' => 'how-to-choose-best-home-blood-pressure-monitor-2026',
                            'image' => 'blogs/bp_monitor.jpg',
                            'tags' => 'أجهزة طبية,قياس الضغط,صحة القلب,مستلزمات طبية',
                            'Author' => 'د. أحمد محمود - استشاري الأجهزة الطبية',
                            'meta_title' => 'كيف تختار أفضل جهاز قياس ضغط الدم المنزلي 2026',
                            'meta_description' => 'نصائح هامة ودليل متكامل لاختيار جهاز قياس ضغط الدم الدقيق والمناسب للاستخدام المنزلي.',
                            'meta_keywords' => 'جهاز ضغط الدم, قياس الضغط بالمنزل, أجهزة ديجيتال, EgiMedical',
                            'description' => '
                                <h2>مقدمة عن أهمية المتابعة المنزلية لضغط الدم</h2>
                                <p>تعتبر المتابعة المنتظمة لضغط الدم في المنزل خطوة أساسية للوقاية من أمراض القلب والسكتات الدماغية. يساعدك اختيار الجهاز المناسب في الحصول على قراءات دقيقة يمكنك الاعتماد عليها وإرسالها لطبيبك المعالج.</p>
                                
                                <h2>أهم الأنواع المتاحة في السوق:</h2>
                                <ul>
                                    <li><strong>أجهزة قياس الضغط الإلكترونية (الذراع):</strong> الأكثر دقة ويوصى بها أطباء القلب عالمياً.</li>
                                    <li><strong>أجهزة قياس الضغط من المعصم:</strong> ممتازة للسفر والتنقل ولكنها تتطلب وضعية يد دقيقة.</li>
                                    <li><strong>الأجهزة الذكية المزودة بـ Bluetooth:</strong> تسمح بحفظ القراءات ومشاركتها عبر تطبيق الهاتف.</li>
                                </ul>

                                <blockquote>"القراءة المنتظمة والتسجيل اليومي يساعدان طبيبك في ضبط جرعات العلاج بدقة عالية."</blockquote>

                                <h2>شروط الحصول على قراءة دقيقة:</h2>
                                <p>يُنصح بالجلوس بهدوء لمدة 5 دقائق قبل القياس، وتجنب الكافيين أو التدخين قبل القياس بـ 30 دقيقة، مع التأكد من وضع الحزام على مستوى القلب مباشرة.</p>
                            ',
                        ],
                        'en' => [
                            'title' => 'How to Choose the Best Home Blood Pressure Monitor in 2026?',
                            'slug' => 'how-to-choose-best-home-blood-pressure-monitor-2026-en',
                            'image' => 'blogs/bp_monitor.jpg',
                            'tags' => 'medical devices,BP monitor,heart health,healthcare',
                            'Author' => 'Dr. Ahmed Mahmoud - Medical Devices Specialist',
                            'meta_title' => 'How to Choose the Best Home Blood Pressure Monitor 2026',
                            'meta_description' => 'Expert tips and complete guide to selecting an accurate home blood pressure monitor for your family.',
                            'meta_keywords' => 'blood pressure monitor, home BP test, digital BP machine, EgiMedical',
                            'description' => '
                                <h2>Introduction to Home Blood Pressure Monitoring</h2>
                                <p>Regular home blood pressure monitoring is essential for preventing cardiovascular complications. Choosing the right device ensures accurate readings that your physician can rely on.</p>

                                <h2>Top Types Available:</h2>
                                <ul>
                                    <li><strong>Upper Arm Digital Monitors:</strong> Recommended by cardiologists worldwide for maximum accuracy.</li>
                                    <li><strong>Wrist Blood Pressure Monitors:</strong> Highly portable and convenient for travelers.</li>
                                    <li><strong>Smart Bluetooth Monitors:</strong> Seamlessly sync your readings to your smartphone app.</li>
                                </ul>

                                <blockquote>"Consistent daily tracking provides doctors with vital insights for medication management."</blockquote>

                                <h2>Best Practices for Accurate Readings:</h2>
                                <p>Rest comfortably for 5 minutes before taking a measurement, avoid caffeine or smoking 30 minutes prior, and keep the cuff at heart level.</p>
                            ',
                        ],
                    ],
                    [
                        'ar' => [
                            'title' => 'أهمية مولدات الأكسجين المنزلية وطريقة صيانتها السليمة',
                            'slug' => 'importance-of-home-oxygen-concentrators-and-maintenance',
                            'image' => 'blogs/oxygen_concentrator.jpg',
                            'tags' => 'مولد أكسجين,أجهزة تنفس,صيانة أجهزة طبية,عناية مركزة',
                            'Author' => 'م. سارة علي - مهندسة معدات طبية',
                            'meta_title' => 'دليل مولدات الأكسجين المنزلية وصيانتها الدوريّة',
                            'meta_description' => 'تعرف على كيفية اختيار مولد الأكسجين المنزلي المناسب وطرق الصيانة للحفاظ على كفاءته.',
                            'meta_keywords' => 'مولد أكسجين 10 لتر, أكسجين منزلي, صيانة فلاتر الأكسجين, EgiMedical',
                            'description' => '
                                <h2>ما هو مولد الأكسجين المنزلي وكيف يعمل؟</h2>
                                <p>يقوم مولد الأكسجين بسحب الهواء الجوي وتنقيته من النيتروجين لتزويد المريض بأكسجين عالي النقاوة بنسبة تصل إلى 95%. يعتبر حل اقتصادياً وآمناً مقارنة بأسطوانات الأكسجين التقليدية.</p>

                                <h2>نصائح هامة عند الاستخدام والصيانة:</h2>
                                <ul>
                                    <li>غسل الفلتر الخارجي بالماء الدافئ أسبوعياً وتجفيفه جيداً قبل إعادة التركيب.</li>
                                    <li>استبدال المياه المعطرة أو المقطرة في مرطب الأكسجين يومياً لمنع تكون البكتيريا.</li>
                                    <li>وضع الجهاز في مكان مفتوح يبعد 30 سم على الأقل عن الجدران والأثاث.</li>
                                </ul>
                            ',
                        ],
                        'en' => [
                            'title' => 'Importance of Home Oxygen Concentrators and Proper Maintenance',
                            'slug' => 'importance-of-home-oxygen-concentrators-and-maintenance-en',
                            'image' => 'blogs/oxygen_concentrator.jpg',
                            'tags' => 'oxygen concentrator,respiratory care,medical maintenance,healthcare',
                            'Author' => 'Eng. Sarah Ali - Biomedical Engineer',
                            'meta_title' => 'Home Oxygen Concentrators Guide and Maintenance Tips',
                            'meta_description' => 'Learn how home oxygen concentrators work and essential maintenance steps to preserve purity and safety.',
                            'meta_keywords' => 'oxygen concentrator 10L, home oxygen therapy, oxygen filter cleaning, EgiMedical',
                            'description' => '
                                <h2>What is a Home Oxygen Concentrator?</h2>
                                <p>Oxygen concentrators pull ambient air, extract nitrogen, and deliver medical-grade oxygen at up to 95% purity. They provide a continuous, cost-effective alternative to heavy oxygen cylinders.</p>

                                <h2>Essential Maintenance & Safety Steps:</h2>
                                <ul>
                                    <li>Wash the gross particle filter weekly with warm water and dry thoroughly.</li>
                                    <li>Change the distilled water in the humidifier bottle daily to avoid bacterial growth.</li>
                                    <li>Position the unit at least 30 cm away from walls and furniture to ensure proper ventilation.</li>
                                </ul>
                            ',
                        ],
                    ],
                ],
            ],
            [
                'ar' => [
                    'title' => 'مستلزمات العناية والوقاية',
                    'slug' => 'care-and-protection-supplies',
                    'description' => 'كل ما تود معرفته عن مستلزمات التعقيم، الكمامات الطبية، القفازات، وأدوات الوقاية الفردية.',
                    'meta_title' => 'مستلزمات العناية والوقاية الطبية | EgiMedical',
                    'meta_description' => 'تسوق واقرأ عن أجود أدوات التعقيم والقفازات الطبية ومستلزمات العناية الشخصية.',
                    'meta_keywords' => 'قفازات طبية, كمامات, مطهرات, تعقيم طبي, EgiMedical',
                ],
                'en' => [
                    'title' => 'Care & Protection Supplies',
                    'slug' => 'care-and-protection-supplies',
                    'description' => 'All you need to know about medical disposables, sterilization, masks, gloves, and PPE gear.',
                    'meta_title' => 'Care & Protection Supplies | EgiMedical',
                    'meta_description' => 'Discover high-grade medical disposables, surgical gloves, disinfectants, and personal protection.',
                    'meta_keywords' => 'surgical masks, medical gloves, disinfectants, PPE supplies, EgiMedical',
                ],
                'blogs' => [
                    [
                        'ar' => [
                            'title' => 'الفرق بين القفازات اللاتكس والنيتريل والفينيل: أيهما الأنسب لك؟',
                            'slug' => 'difference-between-latex-nitrile-vinyl-gloves',
                            'image' => 'blogs/medical_gloves.jpg',
                            'tags' => 'قفازات نيتريل,قفازات لاتكس,مستلزمات وقاية,تعقيم',
                            'Author' => 'د. خالد توفيق - أخصائي مكافحة العدوى',
                            'meta_title' => 'مقارنة بين القفازات الطبية اللاتكس والنيتريل والفينيل',
                            'meta_description' => 'دليل شامل يوضح الفروق بين أنواع القفازات الطبية المختلفة والاستخدام الأمثل لكل نوع.',
                            'meta_keywords' => 'قفازات نيتريل, قفازات لاتكس, قفازات بدون بودرة, EgiMedical',
                            'description' => '
                                <h2>اختيار القفاز الطبي المناسب لاحتياجاتك</h2>
                                <p>تتعدد أنواع القفازات الطبية ويختلف كل نوع بحسب الخامة ومستوى الحماية ومقاومة الثقوب والحساسية الجلدية.</p>

                                <h2>1. قفازات النيتريل (Nitrile Gloves):</h2>
                                <p>الخيار الأكثر شعبية حالياً؛ خالية تماماً من اللاتكس (خالية من الحساسية)، وتمتاز بمقاومة عالية جداً للثقوب والمواد الكيميائية.</p>

                                <h2>2. قفازات اللاتكس (Latex Gloves):</h2>
                                <p>توفر أعلى درجات المرونة والراحة والشعور اللمسي الدقيق، لكنها قد تسبب حساسية لبعض الأشخاص.</p>

                                <h2>3. قفازات الفينيل (Vinyl Gloves):</h2>
                                <p>اقتصادية ومناسبة للمهام الخفيفة وقصيرة المدى مثل الفحص السريع والتعامل مع الأغذية.</p>
                            ',
                        ],
                        'en' => [
                            'title' => 'Difference Between Latex, Nitrile, and Vinyl Gloves: Which is Best for You?',
                            'slug' => 'difference-between-latex-nitrile-vinyl-gloves-en',
                            'image' => 'blogs/medical_gloves.jpg',
                            'tags' => 'nitrile gloves,latex gloves,medical disposables,infection control',
                            'Author' => 'Dr. Khaled Tawfik - Infection Control Specialist',
                            'meta_title' => 'Latex vs Nitrile vs Vinyl Medical Gloves Comparison',
                            'meta_description' => 'Comprehensive breakdown comparing medical glove materials, allergy risks, puncture resistance, and ideal uses.',
                            'meta_keywords' => 'nitrile gloves, powder-free gloves, latex allergy, vinyl disposable gloves, EgiMedical',
                            'description' => '
                                <h2>Choosing the Right Medical Gloves</h2>
                                <p>Medical gloves vary greatly in composition, puncture resistance, barrier protection, and allergen potential.</p>

                                <h2>1. Nitrile Gloves:</h2>
                                <p>100% latex-free (hypoallergenic), offering superior puncture resistance and high chemical barrier safety.</p>

                                <h2>2. Latex Gloves:</h2>
                                <p>Provide supreme elasticity, tactile sensitivity, and comfort, though latex proteins may cause allergic reactions in sensitive individuals.</p>

                                <h2>3. Vinyl Gloves:</h2>
                                <p>An economical choice suited for low-risk, short-duration healthcare tasks and food handling.</p>
                            ',
                        ],
                    ],
                ],
            ],
            [
                'ar' => [
                    'title' => 'نصائح وإرشادات صحية',
                    'slug' => 'health-and-medical-tips',
                    'description' => 'إرشادات طبية موثوقة من خبراء الرعاية الصحية للحفاظ على صحتك وصحة عائلتك.',
                    'meta_title' => 'نصائح وإرشادات صحية موثوقة | EgiMedical',
                    'meta_description' => 'مقالات صحية وإرشادات يومية للعناية بمرضى السكري والضغط وكبار السن.',
                    'meta_keywords' => 'نصائح صحية, السكري, كبار السن, العناية المنزلية, EgiMedical',
                ],
                'en' => [
                    'title' => 'Health & Medical Tips',
                    'slug' => 'health-and-medical-tips',
                    'description' => 'Trusted medical insights and wellness guides from healthcare experts to safeguard your family.',
                    'meta_title' => 'Trusted Health & Wellness Tips | EgiMedical',
                    'meta_description' => 'Read health advice and daily tips for managing diabetes, hypertension, and elder care.',
                    'meta_keywords' => 'health tips, diabetes care, elder care, home health, EgiMedical',
                ],
                'blogs' => [
                    [
                        'ar' => [
                            'title' => 'دليل العناية بالقدم السكرية والوقاية من المضاعفات',
                            'slug' => 'diabetic-foot-care-and-prevention-guide',
                            'image' => 'blogs/diabetic_care.jpg',
                            'tags' => 'مرض السكري,العناية بالقدم,صحة الأسرة,مستلزمات السكر',
                            'Author' => 'د. نادية حسن - أخصائية غدد صماء وسكري',
                            'meta_title' => 'دليل العناية بالقدم السكرية والوقاية من القروح',
                            'meta_description' => 'خطوات عملية يومية لمرضى السكري لحماية القدمين والوقاية من القروح والمضاعفات.',
                            'meta_keywords' => 'القدم السكرية, فحص السكر, جوارب سكرية, EgiMedical',
                            'description' => '
                                <h2>أهمية العناية اليومية بالقدم لمرضى السكري</h2>
                                <p>يؤدي ارتفاع السكر الفترات طويلة إلى ضعف الدورة الدموية وتأثر الأعصاب الطرفية. لذا فإن الفحص اليومي للقدم يمنع حدوث الجروح والقروح الخطيرة.</p>

                                <h2>خطوات الوقاية اليومية:</h2>
                                <ul>
                                    <li>فحص القدمين يومياً تحت إضاءة جيدة للتأكد من عدم وجود خدوش أو تغير في اللون.</li>
                                    <li>غسل القدمين بالماء الدافئ والصابون اللطيف مع التجفيف التام خاصة بين الأصابع.</li>
                                    <li>ترطيب الجلد لكعب القدم والامتناع عن وضع الكريم بين الأصابع.</li>
                                    <li>ارتداء جوارب قطنية مخصصة لمرضى السكري بدون حواف ضاغطة.</li>
                                </ul>
                            ',
                        ],
                        'en' => [
                            'title' => 'Diabetic Foot Care Guide and Complication Prevention',
                            'slug' => 'diabetic-foot-care-and-prevention-guide-en',
                            'image' => 'blogs/diabetic_care.jpg',
                            'tags' => 'diabetes care,foot health,diabetic supplies,wellness',
                            'Author' => 'Dr. Nadia Hassan - Endocrinologist',
                            'meta_title' => 'Diabetic Foot Care and Prevention Guide | EgiMedical',
                            'meta_description' => 'Practical daily steps for diabetic patients to protect their feet and prevent ulcers and nerve complications.',
                            'meta_keywords' => 'diabetic foot, blood glucose check, diabetic socks, EgiMedical',
                            'description' => '
                                <h2>Why Daily Foot Inspection Matters for Diabetics</h2>
                                <p>Prolonged high blood glucose can impair circulation and nerve sensitivity. Daily foot care is the single most effective way to prevent ulcers and severe complications.</p>

                                <h2>Daily Preventive Checklist:</h2>
                                <ul>
                                    <li>Inspect your feet every day under good light for cuts, blisters, or redness.</li>
                                    <li>Wash daily with lukewarm water and mild soap, drying completely between toes.</li>
                                    <li>Moisturize heels and soles, avoiding application between toes.</li>
                                    <li>Wear seamless, non-binding diabetic cotton socks with comfortable supportive footwear.</li>
                                </ul>
                            ',
                        ],
                    ],
                ],
            ],
        ];

        // 2. Iterate and Seed Database
        $catIndex = 0;
        foreach ($categoriesData as $catGroup) {
            $catIndex++;
            $category = BlogCategory::create([
                'view_index' => $catIndex,
                'status' => true,
            ]);

            foreach (['ar', 'en'] as $lang) {
                BlogCategoryTranslation::create([
                    'blog_category_id' => $category->id,
                    'title' => $catGroup[$lang]['title'],
                    'slug' => Str::slug($catGroup[$lang]['slug']),
                    'description' => $catGroup[$lang]['description'],
                    'meta_title' => $catGroup[$lang]['meta_title'],
                    'meta_description' => $catGroup[$lang]['meta_description'],
                    'meta_keywords' => $catGroup[$lang]['meta_keywords'],
                    'lang_id' => $lang,
                ]);
            }

            $blogIndex = 0;
            foreach ($catGroup['blogs'] as $blogData) {
                $blogIndex++;
                $blog = Blog::create([
                    'blog_category_id' => $category->id,
                    'view_index' => $blogIndex,
                    'status' => true,
                ]);

                foreach (['ar', 'en'] as $lang) {
                    BlogTranslation::create([
                        'blog_id' => $blog->id,
                        'title' => $blogData[$lang]['title'],
                        'slug' => Str::slug($blogData[$lang]['slug']),
                        'image' => $blogData[$lang]['image'],
                        'tags' => $blogData[$lang]['tags'],
                        'description' => $blogData[$lang]['description'],
                        'Author' => $blogData[$lang]['Author'],
                        'meta_title' => $blogData[$lang]['meta_title'],
                        'meta_description' => $blogData[$lang]['meta_description'],
                        'meta_keywords' => $blogData[$lang]['meta_keywords'],
                        'lang_id' => $lang,
                    ]);
                }
            }
        }
    }
}
