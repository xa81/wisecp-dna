[![TR](https://github.com/domainreseller/wisecp-dna/assets/118720541/3ae7f50e-2763-4bf9-8060-c3dd3e321ff9)](README.md)
TR | [![EN](https://github.com/domainreseller/wisecp-dna/assets/118720541/654290e2-e8a0-40f8-b816-59fe7ae94418)](README-EN.md)
EN | [![AZ](https://github.com/domainreseller/wisecp-dna/assets/118720541/c5b30741-8f16-4f89-901e-37d63e9376a7)](README-AZ.md)
AZ | [![DE](https://github.com/domainreseller/wisecp-dna/assets/118720541/c2416f16-08c2-433e-b22b-f8b72c979090)](README-DE.md)
DE | [![FR](https://github.com/domainreseller/wisecp-dna/assets/118720541/a5e20dc0-d47e-4ce7-bd97-6d4ba80ddc18)](README-FR.md)
FR | [![AR](https://github.com/domainreseller/wisecp-dna/assets/118720541/8e4b474b-2be3-4323-99ff-f2e90aa4142d)](README-AR.md)
AR | [![NL](https://github.com/domainreseller/wisecp-dna/assets/118720541/ed7fe0e5-3775-40f3-bd71-c974de88a50d)](README-NL.md)
NL 

# دليل استخدام وحدة Domainnameapi

هذه الوحدة هي تكامل API لأسماء النطاقات في WiseCP.

## المتطلبات

- يتطلب WiseCP الإصدار 3 أو الأحدث.
- يتطلب PHP الإصدار 7.4 أو الأحدث.
- يجب تمكين امتداد PHP Soap.

## التثبيت

1. قم بنسخ مجلد "coremio" من المجلد الذي تم تنزيله إلى المجلد الذي تم تثبيت WiseCP فيه (مثال: /home/wisecp/public_html). لا تقم بتضمين ملفات `.gitignore` و `README.md` و `LICENSE`.
2. تأكد من صحة هيكل المجلدات. على سبيل المثال: /home/wisecp/public_html/coremio/modules/Registrars/DomainNameApi/DomainNameApi.php.
3. انتقل إلى لوحة التحكم الإدارية لـ WiseCP.
4. انتقل إلى قائمة المنتجات/الخدمات وحدد "تسجيل النطاق".
5. انقر فوق خطوة "التثبيت".

![شاشة التثبيت](https://github.com/domainreseller/wisecp-dna/assets/118720541/0cc8cca1-980e-4ae2-928a-28a809da87eb)

### بيانات مستخدم الوكيل

1. أدخل اسم مستخدم الوكيل وكلمة المرور.
2. انقر فوق زر "حفظ".

### اختبار الاتصال

1. انقر على زر "اختبار الاتصال" للتحقق مما إذا كان الاتصال قد تم بنجاح.

## استيراد TLD للنطاقات

1. انقر على علامة التبويب "استيراد TLD" لاستيراد امتدادات أسماء النطاق.
2. سيتم استيراد جميع الامتدادات بنجاح.

## استيراد أسماء النطاقات

1. انقر على علامة التبويب "استيراد" لاستيراد أسماء النطاقات.
2. ستظهر لك قائمة بالنطاقات المتاحة. حدد النطاق الذي ترغب في استيراده وقم بتعيينه للعم
