<?php

return [
    'sections' => [
        'hero' => [
            'label' => 'Hero',
            'preview_anchor' => '#hero',
            'defaults' => [
                'video_path' => 'video/hero.mp4',
                'poster_image_path' => null,
                'stats' => [
                    [
                        'id' => 'attendees',
                        'icon' => 'fas fa-users',
                        'value' => 5000,
                        'suffix' => '+',
                        'label' => [
                            'en' => 'Global Attendees',
                            'ar' => 'الحضور العالمي',
                        ],
                    ],
                    [
                        'id' => 'speakers',
                        'icon' => 'fas fa-microphone-alt',
                        'value' => 120,
                        'suffix' => '+',
                        'label' => [
                            'en' => 'Expert Speakers',
                            'ar' => 'خبير متحدث',
                        ],
                    ],
                    [
                        'id' => 'sessions',
                        'icon' => 'fas fa-calendar-check',
                        'value' => 60,
                        'suffix' => '',
                        'label' => [
                            'en' => 'Sessions',
                            'ar' => 'ورشة عمل',
                        ],
                    ],
                    [
                        'id' => 'countries',
                        'icon' => 'fas fa-globe-americas',
                        'value' => 50,
                        'suffix' => '+',
                        'label' => [
                            'en' => 'Countries',
                            'ar' => 'دولة مشاركة',
                        ],
                    ],
                ],
            ],
        ],
        'registration' => [
            'label' => 'Registration',
            'preview_anchor' => '#register',
            'defaults' => [
                'title' => [
                    'en' => 'Registration',
                    'ar' => 'التسجيل',
                ],
                'description' => [
                    'en' => 'Choose your role to begin the registration process. Visitors and exhibitors have different registration flows.',
                    'ar' => 'اختر دورك لبدء عملية التسجيل. الزوار والعارضون لديهم مسارات تسجيل مختلفة.',
                ],
                'visitor_card' => [
                    'title' => [
                        'en' => 'Visitor / Client',
                        'ar' => 'زائر / عميل',
                    ],
                    'description' => [
                        'en' => 'Attend the conference and explore opportunities',
                        'ar' => 'احضر المؤتمر واستكشف الفرص',
                    ],
                    'cta_label' => [
                        'en' => 'Select',
                        'ar' => 'اختر',
                    ],
                ],
                'visitor_form' => [
                    'title' => [
                        'en' => 'Visitor Registration',
                        'ar' => 'تسجيل الزائر',
                    ],
                    'cta_submit' => [
                        'en' => 'Submit Registration',
                        'ar' => 'إرسال التسجيل',
                    ],
                    'cta_contact' => [
                        'en' => 'Contact Us',
                        'ar' => 'تواصل معنا',
                    ],
                    'fields' => [
                        [
                            'name' => 'full_name',
                            'type' => 'text',
                            'label' => ['en' => 'Full Name *', 'ar' => 'الاسم الكامل *'],
                            'placeholder' => ['en' => 'John Doe', 'ar' => 'جون دو'],
                        ],
                        [
                            'name' => 'email',
                            'type' => 'email',
                            'label' => ['en' => 'Email *', 'ar' => 'البريد الإلكتروني *'],
                            'placeholder' => ['en' => 'john@example.com', 'ar' => 'john@example.com'],
                        ],
                        [
                            'name' => 'phone',
                            'type' => 'tel',
                            'label' => ['en' => 'Phone', 'ar' => 'الهاتف'],
                            'placeholder' => ['en' => '+966 50 000 0000', 'ar' => '+966 50 000 0000'],
                        ],
                        [
                            'name' => 'job_title',
                            'type' => 'text',
                            'label' => ['en' => 'Job Title', 'ar' => 'المسمى الوظيفي'],
                            'placeholder' => ['en' => 'Marketing Manager', 'ar' => 'مدير التسويق'],
                        ],
                        [
                            'name' => 'company_name',
                            'type' => 'text',
                            'label' => ['en' => 'Company / Organization', 'ar' => 'الشركة / الجهة'],
                            'placeholder' => ['en' => 'Umbrella Inc.', 'ar' => 'شركة أمبريلا'],
                        ],
                        [
                            'name' => 'heard_about',
                            'type' => 'select',
                            'label' => ['en' => 'How did you hear about us?', 'ar' => 'كيف سمعت عنا؟'],
                            'options' => [
                                ['value' => 'social_media', 'en' => 'Social Media', 'ar' => 'وسائل التواصل الاجتماعي'],
                                ['value' => 'ads', 'en' => 'Advertising', 'ar' => 'الإعلانات'],
                                ['value' => 'friends', 'en' => 'Friends / Colleagues', 'ar' => 'الأصدقاء / الزملاء'],
                                ['value' => 'other', 'en' => 'Other', 'ar' => 'أخرى'],
                            ],
                        ],
                        [
                            'name' => 'heard_about_other_text',
                            'type' => 'text',
                            'label' => ['en' => 'Please specify', 'ar' => 'يرجى التحديد'],
                            'placeholder' => ['en' => 'Conference website', 'ar' => 'موقع المؤتمر'],
                        ],
                    ],
                ],
                'exhibitor_card' => [
                    'title' => [
                        'en' => 'Sponsors',
                        'ar' => 'الرعاة',
                    ],
                    'description' => [
                        'en' => 'Showcase your products and connect with attendees',
                        'ar' => 'اعرض منتجاتك وتواصل مع الحضور',
                    ],
                    'cta_label' => [
                        'en' => 'Select',
                        'ar' => 'اختر',
                    ],
                ],
                'exhibitor_form' => [
                    'title' => [
                        'en' => 'Exhibitor Application',
                        'ar' => 'طلب العرض',
                    ],
                    'step_one' => [
                        'en' => 'Contact',
                        'ar' => 'التواصل',
                    ],
                    'step_two' => [
                        'en' => 'Company',
                        'ar' => 'الشركة',
                    ],
                    'cta_next' => [
                        'en' => 'Next Step',
                        'ar' => 'الخطوة التالية',
                    ],
                    'cta_submit' => [
                        'en' => 'Submit Application',
                        'ar' => 'إرسال الطلب',
                    ],
                    'fields_step_one' => [
                        [
                            'name' => 'exhibitor_full_name',
                            'type' => 'text',
                            'label' => ['en' => 'Full Name *', 'ar' => 'الاسم الكامل *'],
                            'placeholder' => ['en' => 'John Doe', 'ar' => 'جون دو'],
                        ],
                        [
                            'name' => 'exhibitor_email',
                            'type' => 'email',
                            'label' => ['en' => 'Email *', 'ar' => 'البريد الإلكتروني *'],
                            'placeholder' => ['en' => 'john@company.com', 'ar' => 'john@company.com'],
                        ],
                        [
                            'name' => 'exhibitor_phone',
                            'type' => 'tel',
                            'label' => ['en' => 'Phone *', 'ar' => 'الهاتف *'],
                            'placeholder' => ['en' => '+966 50 000 0000', 'ar' => '+966 50 000 0000'],
                        ],
                        [
                            'name' => 'exhibitor_job',
                            'type' => 'text',
                            'label' => ['en' => 'Job Title *', 'ar' => 'المسمى الوظيفي *'],
                            'placeholder' => ['en' => 'Marketing Manager', 'ar' => 'مدير التسويق'],
                        ],
                        [
                            'name' => 'organization',
                            'type' => 'text',
                            'label' => ['en' => 'Company / Organization', 'ar' => 'الشركة / الجهة'],
                            'placeholder' => ['en' => 'Umbrella Inc.', 'ar' => 'شركة أمبريلا'],
                        ],
                        [
                            'name' => 'location_selection',
                            'type' => 'text',
                            'label' => ['en' => 'Book Location *', 'ar' => 'حجز الموقع *'],
                            'placeholder' => ['en' => 'Select on the hall map', 'ar' => 'اختر من خريطة القاعة'],
                        ],
                    ],
                    'fields_step_two' => [
                        [
                            'name' => 'vat_number',
                            'type' => 'text',
                            'label' => ['en' => 'VAT (Value Added Tax) *', 'ar' => 'ضريبة القيمة المضافة *'],
                            'placeholder' => ['en' => '300000000000003', 'ar' => '300000000000003'],
                        ],
                        [
                            'name' => 'cr_number',
                            'type' => 'text',
                            'label' => ['en' => 'CR Number', 'ar' => 'رقم السجل التجاري'],
                            'placeholder' => ['en' => '1010101010', 'ar' => '1010101010'],
                        ],
                        [
                            'name' => 'cr_copy',
                            'type' => 'file',
                            'label' => ['en' => 'CR Copy (Commercial Registration)', 'ar' => 'نسخة السجل التجاري'],
                            'hint' => ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'],
                        ],
                        [
                            'name' => 'company_logo',
                            'type' => 'file',
                            'label' => ['en' => 'Company Logo', 'ar' => 'شعار الشركة'],
                            'hint' => ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'],
                        ],
                        [
                            'name' => 'corporate_profile',
                            'type' => 'file',
                            'label' => ['en' => 'Corporate Profile', 'ar' => 'الملف التعريفي للشركة'],
                            'hint' => ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'],
                        ],
                        [
                            'name' => 'national_address_document',
                            'type' => 'file',
                            'label' => ['en' => 'National Address Document', 'ar' => 'مستند العنوان الوطني'],
                            'hint' => ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'],
                        ],
                    ],
                ],
                'icon_card' => [
                    'title' => [
                        'en' => 'Icons',
                        'ar' => 'الأيقونات',
                    ],
                    'description' => [
                        'en' => 'Apply to be an Icon partner.',
                        'ar' => 'تقدم لتكون شريك الأيقونات.',
                    ],
                    'cta_label' => [
                        'en' => 'Select',
                        'ar' => 'اختر',
                    ],
                ],
                'icon_form' => [
                    'title' => [
                        'en' => 'Icon Registration',
                        'ar' => 'تسجيل الأيقونات',
                    ],
                    'step_one' => [
                        'en' => 'Company Details',
                        'ar' => 'تفاصيل الشركة',
                    ],
                    'step_two' => [
                        'en' => 'Attachments',
                        'ar' => 'المرفقات',
                    ],
                    'cta_next' => [
                        'en' => 'Next Step',
                        'ar' => 'الخطوة التالية',
                    ],
                    'cta_back' => [
                        'en' => 'Back',
                        'ar' => 'رجوع',
                    ],
                    'cta_submit' => [
                        'en' => 'Submit Application',
                        'ar' => 'إرسال الطلب',
                    ],
                    'fields_step_one' => [
                        [
                            'name' => 'full_name',
                            'type' => 'text',
                            'label' => ['en' => 'Full Name *', 'ar' => 'الاسم الكامل *'],
                            'placeholder' => ['en' => 'John Doe', 'ar' => 'جون دو'],
                        ],
                        [
                            'name' => 'email',
                            'type' => 'email',
                            'label' => ['en' => 'Email *', 'ar' => 'البريد الإلكتروني *'],
                            'placeholder' => ['en' => 'john@company.com', 'ar' => 'john@company.com'],
                        ],
                        [
                            'name' => 'phone',
                            'type' => 'tel',
                            'label' => ['en' => 'Phone *', 'ar' => 'الهاتف *'],
                            'placeholder' => ['en' => '+966 50 000 0000', 'ar' => '+966 50 000 0000'],
                        ],
                        [
                            'name' => 'job_title',
                            'type' => 'text',
                            'label' => ['en' => 'Job Title *', 'ar' => 'المسمى الوظيفي *'],
                            'placeholder' => ['en' => 'Marketing Manager', 'ar' => 'مدير التسويق'],
                        ],
                        [
                            'name' => 'organization',
                            'type' => 'text',
                            'label' => ['en' => 'Company / Organization', 'ar' => 'الشركة / الجهة'],
                            'placeholder' => ['en' => 'Umbrella Inc.', 'ar' => 'شركة أمبريلا'],
                        ],
                        [
                            'name' => 'location_selection',
                            'type' => 'text',
                            'label' => ['en' => 'Book Location *', 'ar' => 'حجز الموقع *'],
                            'placeholder' => ['en' => 'Select on the hall map', 'ar' => 'اختر من خريطة القاعة'],
                        ],
                    ],
                    'fields_step_two' => [
                        [
                            'name' => 'vat_number',
                            'type' => 'text',
                            'label' => ['en' => 'VAT (Value Added Tax)', 'ar' => 'ضريبة القيمة المضافة'],
                            'placeholder' => ['en' => '300000000000003', 'ar' => '300000000000003'],
                        ],
                        [
                            'name' => 'cr_number',
                            'type' => 'text',
                            'label' => ['en' => 'CR Number', 'ar' => 'رقم السجل التجاري'],
                            'placeholder' => ['en' => '1010101010', 'ar' => '1010101010'],
                        ],
                        [
                            'name' => 'cr_copy',
                            'type' => 'file',
                            'label' => ['en' => 'CR Copy (Commercial Registration)', 'ar' => 'نسخة السجل التجاري'],
                            'hint' => ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'],
                        ],
                        [
                            'name' => 'company_logo',
                            'type' => 'file',
                            'label' => ['en' => 'Company Logo', 'ar' => 'شعار الشركة'],
                            'hint' => ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'],
                        ],
                        [
                            'name' => 'corporate_profile',
                            'type' => 'file',
                            'label' => ['en' => 'Corporate Profile', 'ar' => 'الملف التعريفي للشركة'],
                            'hint' => ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'],
                        ],
                        [
                            'name' => 'national_address_document',
                            'type' => 'file',
                            'label' => ['en' => 'National Address Document', 'ar' => 'مستند العنوان الوطني'],
                            'hint' => ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'],
                        ],
                    ],
                ],
            ],
        ],
        'about' => [
            'label' => 'About',
            'preview_anchor' => '#about',
            'defaults' => [
                'background_video' => 'video/video.mp4',
                'title' => [
                    'en' => 'About Us',
                    'ar' => 'من نحن',
                ],
                'mission' => [
                    'title' => [
                        'en' => 'Our Mission',
                        'ar' => 'مهمتنا',
                    ],
                    'paragraphs' => [
                        [
                            'en' => 'Our mission is to create a world-class platform that brings together visionaries, innovators, and industry leaders from across the globe. We aim to foster collaboration, inspire innovation, and drive meaningful connections that shape the future of business.',
                            'ar' => 'مهمتنا هي إنشاء منصة عالمية المستوى تجمع أصحاب الرؤى والمبتكرين وقادة الصناعة من جميع أنحاء العالم. نهدف إلى تعزيز التعاون وإلهام الابتكار وإنشاء علاقات هادفة تشكل مستقبل الأعمال.',
                        ],
                        [
                            'en' => 'Through carefully curated sessions, exhibitions, and networking opportunities, we provide an unparalleled experience for all attendees.',
                            'ar' => 'من خلال الجلسات والمعارض وفرص التواصل المنتقاة بعناية، نقدم تجربة لا مثيل لها لجميع الحضور.',
                        ],
                    ],
                ],
                'goals' => [
                    [
                        'title' => ['en' => 'Innovation', 'ar' => 'الابتكار'],
                        'description' => ['en' => 'Showcase cutting-edge technologies and solutions', 'ar' => 'عرض أحدث التقنيات والحلول'],
                    ],
                    [
                        'title' => ['en' => 'Networking', 'ar' => 'التواصل'],
                        'description' => ['en' => 'Connect industry leaders and professionals', 'ar' => 'ربط قادة الصناعة والمهنيين'],
                    ],
                    [
                        'title' => ['en' => 'Growth', 'ar' => 'النمو'],
                        'description' => ['en' => 'Drive business opportunities and partnerships', 'ar' => 'تعزيز فرص الأعمال والشراكات'],
                    ],
                ],
            ],
        ],
        'contact' => [
            'label' => 'Contact',
            'preview_anchor' => '#contact',
            'defaults' => [
                'title' => [
                    'en' => 'Contact Us',
                    'ar' => 'تواصل معنا',
                ],
                'description' => [
                    'en' => 'Have questions? We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.',
                    'ar' => 'لديك أسئلة؟ نود أن نسمع منك. أرسل لنا رسالة وسنرد في أقرب وقت ممكن.',
                ],
                'form_title' => [
                    'en' => 'Send us a message',
                    'ar' => 'أرسل لنا رسالة',
                ],
                'form_button' => [
                    'en' => 'Send Message',
                    'ar' => 'إرسال الرسالة',
                ],
                'map_embed' => 'https://www.google.com/maps?q=Riyadh+International+Convention+%26+Exhibition+Center&output=embed',
                'location_title' => [
                    'en' => 'Event Location',
                    'ar' => 'موقع الحدث',
                ],
                'location_address' => [
                    'en' => 'Riyadh International Convention & Exhibition Center, King Abdullah Road, Riyadh, Saudi Arabia',
                    'ar' => 'مركز الرياض الدولي للمؤتمرات والمعارض، طريق الملك عبدالله، الرياض، المملكة العربية السعودية',
                ],
                'support_cards' => [
                    [
                        'id' => 'arabic_support',
                        'title' => ['en' => 'Arabic Support', 'ar' => 'التواصل باللغة العربية'],
                        'columns' => [
                            [
                                'heading' => ['en' => 'Ahmed', 'ar' => 'أحمد'],
                                'contacts' => [
                                    ['type' => 'phone', 'value' => '+966566668892'],
                                    ['type' => 'phone', 'value' => '+966541164491'],
                                ],
                            ],
                            [
                                'heading' => ['en' => 'Tamim', 'ar' => 'تميم'],
                                'contacts' => [
                                    ['type' => 'phone', 'value' => '+966594650976'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'id' => 'english_support',
                        'title' => ['en' => 'English Support', 'ar' => 'التواصل باللغة الإنجليزية'],
                        'columns' => [
                            [
                                'heading' => ['en' => 'Support', 'ar' => 'الدعم'],
                                'contacts' => [
                                    ['type' => 'phone', 'value' => '+966566668892'],
                                    ['type' => 'phone', 'value' => '+966541164491'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'id' => 'email_support',
                        'title' => ['en' => 'Email Support', 'ar' => 'التواصل بالبريد'],
                        'columns' => [
                            [
                                'heading' => ['en' => 'Team', 'ar' => 'الفريق'],
                                'contacts' => [
                                    ['type' => 'email', 'value' => 'tamim@umbrella.sa'],
                                    ['type' => 'email', 'value' => 'aomar@umbrella.sa'],
                                    ['type' => 'email', 'value' => 'hello@umbrella.sa'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
