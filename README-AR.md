<div align="center">  
  <a href="README.md"   >   TR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/TR.png" alt="TR" height="20" /></a>  
  <a href="README-EN.md"> | EN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/US.png" alt="EN" height="20" /></a>  
  <a href="README-AZ.md"> | AZ <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AZ.png" alt="AZ" height="20" /></a>  
  <a href="README-DE.md"> | DE <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/DE.png" alt="DE" height="20" /></a>  
  <a href="README-FR.md"> | FR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/FR.png" alt="FR" height="20" /></a>  
  <a href="README-AR.md"> | AR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AR.png" alt="AR" height="20" /></a>  
  <a href="README-NL.md"> | NL <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/NL.png" alt="NL" height="20" /></a>  
</div>

# دليل استخدام وحدة Domainnameapi

هذه الوحدة هي تكامل 'domainnameapi.com' لـ WiseCP.


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


## الرموز المرجعية ورموز الأخطاء مع الشروحات

| الكود | الشرح                                           | التفاصيل                                                                                                                                                               |
|-------|-------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 1000  | Command completed successfully                  | تمت العملية بنجاح                                                                                                                                                      |
| 1001  | Command completed successfully; action pending. | تمت العملية بنجاح؛ إلا أن هناك إجراء قيد الانتظار.                                                                                                                     |
| 2003  | Required parameter missing                      | معلومة مفقودة مطلوبة. مثال؛ عدم تقديم معلومات الهاتف في بيانات الاتصال.                                                                                                |
| 2105  | Object is not eligible for renewal              | الكائن غير مؤهل للتجديد، تم قفل عمليات التحديث عليه. يجب ألا يكون حالة الكائن "clientupdateprohibited". قد تنجم هذه المشكلة عن حالات أخرى.                             |
| 2200  | Authentication error                            | خطأ في المصادقة، الرمز الأماني غير صحيح أو النطاق مسجل في شركة تسجيل أخرى.                                                                                             |
| 2302  | Object exists                                   | اسم النطاق أو معلومات خادم الأسماء موجودة بالفعل في قاعدة البيانات. لا يمكن تسجيلها.                                                                                   |
| 2303  | Object does not exist                           | اسم النطاق أو معلومات خادم الأسماء غير موجودة في قاعدة البيانات. يجب إنشاء تسجيل جديد.                                                                                 |
| 2304  | Object status prohibits operation               | حالة النطاق تمنع العملية. النطاق غير مؤهل للتحديث، تم قفل عمليات التحديث عليه. حالة النطاق لا يجب أن تكون "clientupdateprohibited". قد تنجم هذه المشكلة عن حالات أخرى. |
