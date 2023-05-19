[[TR ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/3ae7f50e-2763-4bf9-8060-c3dd3e321ff9)]](README.md)
| [[EN ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/654290e2-e8a0-40f8-b816-59fe7ae94418)]](README-EN.md)
| [[AZ ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/c5b30741-8f16-4f89-901e-37d63e9376a7)]](README-AZ.md)
| [[DE  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/c2416f16-08c2-433e-b22b-f8b72c979090)]](README-DE.md)
 | [[FR  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/a5e20dc0-d47e-4ce7-bd97-6d4ba80ddc18)]](README-FR.md)
 | [[AR  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/8e4b474b-2be3-4323-99ff-f2e90aa4142d)]](README-AR.md)
 | [[NL  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/ed7fe0e5-3775-40f3-bd71-c974de88a50d)]](README-NL.md)

# Domainnameapi Modülü 

Bu modül, WiseCP için geliştirilmiş bir 'domainnameapi.com' entegrasyonudur.

## Gereksinimler

- WiseCP'nin 3 ve üzeri sürümü gerekmektedir.
- PHP'nin 7.4 ve üzeri sürümü gerekmektedir.
- PHP Soap eklentisi etkinleştirilmelidir.

## Kurulum

1. İndirdiğiniz klasör içindeki "coremio" klasörünün WISECP kurulu olduğu klasörün içine atın. (Örnek: /home/wisecp/public_html) `.gitignore`, `README.md`, `LICENSE` dosyalarını atmayın.
2. Klasör yapısının doğru olduğundan emin olun. (Örnek: /home/wisecp/public_html/coremio/modules/Registrars/DomainNameApi/DomainNameApi.php)
3. WiseCP'nin yönetim paneline gidin.
4. Ürünler/Hizmetler menüsüne gelin ve "Alan Adı Tescili"ni seçin.
5. Kurulum adımına tıklayın.

![Kurulum Ekran](https://github.com/domainreseller/wisecp-dna/assets/118720541/0cc8cca1-980e-4ae2-928a-28a809da87eb)

### Bayi Kullanıcı Bilgileri

1. Bayi kullanıcı adını ve şifresini girin.
2. "Kaydet" düğmesine tıklayın.

### Bağlantıyı Test Etme

1. "Bağlantıyı Test Et" düğmesine tıklayarak bağlantının sorunsuz bir şekilde kurulup kurulmadığını kontrol edin.

## Alan TLD'lerini İçeri Aktarma

1. "Uzantıları İçeri Aktar" sekmesine tıklayarak alan adı uzantılarını içeri aktarın.
2. Tüm uzantılar başarıyla içeri aktarılacaktır.

## Alan Adlarını İçeri Aktarma

1. "İçeri Aktar" sekmesine tıklayarak alan adlarını görüntüleyin.
2. Listede görünen domainleri göreceksiniz. İçeri aktarmak istediğiniz domaini istediğiniz müşteriye eşitleyin ve "İçeri Aktar" düğmesine tıklayın.

Bu kadar! Artık Domainnameapi modülünü WiseCP'de başarıyla kullanabilirsiniz.
