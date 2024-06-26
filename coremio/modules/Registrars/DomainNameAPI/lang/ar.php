<?php

return [
    'name'                 => "اسم المجال",
    'description'          => "مع Domainnameapi.com ، أحد مسجلي أسماء النطاقات المشهورين ، يمكن إجراء جميع معاملات اسم المجال على الفور من خلال واجهة برمجة تطبيقات المجال. للقيام بذلك ، حدد معلومات حساب عميل domainnameapi.com الخاص بك في الحقول التالية.",
    'importTldButton'      => "استيراد",
    'fields'               => [
        'balance'       => "توازن",
        'username'      => "اسم مستخدم الموزع",
        'password'      => "كلمة مرور الموزع",
        'test-mode'     => "وضع الاختبار",
        'privacyFee'    => "رسوم حماية Whois",
        'adp'           => "تحديث التسعير تلقائيًا",
        'importTld'     => "ملحقات الاستيراد",
        'cost-currency' => "عملة التكلفة",
    ],
    'desc'                 => [
        'privacyFee'    => "<br> اطلب رسوم خدمة حماية whois.",
        'test-mode'     => "التفعيل للمعالجة في وضع الاختبار",
        'adp'           => "تسحب الأسعار تلقائيًا يوميًا ويتم تعيين السعر بمعدل الربح",
        'importTld-1'   => "استيراد جميع الملحقات تلقائيًا",
        'importTld-2'   => "سيتم استيراد جميع ملحقات النطاق والتكاليف المسجلة على API بشكل جماعي.",
    ],
    'tabDetail'            => "معلومات API",
    'tabImport'            => "استيراد",
    'testButton'           => "اختبار الاتصال",
    'importNote'           => "يمكنك بسهولة نقل أسماء النطاقات المسجلة بالفعل في نظام الموفر. يتم إنشاء أسماء النطاقات المستوردة كملحق ، ويتم تمييز أسماء النطاقات المسجلة حاليًا في النظام باللون الأخضر.",
    'importStartButton'    => "استيراد",
    'saveButton'           => "احفظ التغييرات",
    'error1'               => "معلومات API غير متوفرة",
    'error2'               => "معلومات المجال والامتداد غير موجودة",
    'error3'               => "حدث خطأ أثناء استرداد معرف جهة الاتصال",
    'error4'               => "فشل في الحصول على معلومات الحالة",
    'error5'               => "لا يمكن استرداد معلومات النقل",
    'error6'               => "بعد الانتهاء من معالجة موفر واجهة برمجة التطبيقات ، يمكنك تنشيط حالة الطلب",
    'error7'               => "PHP Soap غير مثبت على الخادم الخاص بك. اتصل بموفر الاستضافة الخاص بك لمزيد من المعلومات.",
    'error8'               => "يرجى إدخال معلومات API",
    'error9'               => "فشلت عملية الاستيراد",
    'error10'              => "حدث خطأ",
    'error11'              => "يجب أن يحتوي الاسم التجاري على أقل من كلمتين",
    'success1'             => "تم حفظ الإعدادات بنجاح",
    'success2'             => "نجح اختبار الاتصال",
    'success3'             => "تم الاستيراد بنجاح",
    'success4'             => "تم استيراد الملحقات بنجاح",
    'headerImport'         => "سيتم استيراد أسماء النطاقات أدناه",
    'noImportDomains'      => "لم يتم العثور على أسماء نطاقات للاستيراد.",
    'importQuestion'       => " سيتم استيراد النطاق. هل أنت متأكد؟",
    'yes'                  => "نعم",
    'no'                   => "لا",
    'importProcessing'     => "عملية الاستيراد جارية...",
    'process'              => 'عملية',
    'importFinished'       => 'اكتملت عملية الاستيراد.',
    'okey'                 => 'حسناً',
    'tabImportTld'         => 'استيراد الامتدادات',
    'importTldNote'        => 'يمكنك اختيار واستيراد الامتدادات والتكاليف المسجلة في API بشكل جماعي. يتم حساب جميع التسعيرات بالدولار الأمريكي. لتعطيل المزامنة التلقائية، اختر خيار Excl(Exclude)',
    'tld'                  => 'امتداد',
    'dna'                  => 'DNA؟',
    'cost'                 => 'تكلفة',
    'current'              => 'بيع',
    'margin'               => 'ربح',
    'register'             => 'تسجيل',
    'renew'                => 'تجديد',
    'transfer'             => 'نقل',
    'noTldSelected'        => 'لم يتم اختيار أي TLD',
    'noTldSelectedDesc'    => 'يرجى اختيار TLD للاستيراد',
    'numofTLDSelected'     => ' أنت تقوم بمزامنة الامتداد، هل أنت متأكد؟',
    'numofTLDSynced'       => 'تم الانتهاء من مزامنة الامتداد',
    'numofTLDSyncedTxt'    => 'اكتملت العملية بنجاح',
    'numofTLDNotSynced'    => 'خطأ',
    'numofTLDNotSyncedTxt' => 'حدث خطأ. يرجى المحاولة مرة أخرى.',
    'stillProcessing'      => 'العملية مستمرة...',
];
