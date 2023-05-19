<div align="center">  
  <a href="README.md"   >   TR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/TR.png" alt="TR" height="20" /></a>  
  <a href="README-EN.md"> | EN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/US.png" alt="EN" height="20" /></a>  
  <a href="README-AZ.md"> | AZ <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AZ.png" alt="AZ" height="20" /></a>  
  <a href="README-DE.md"> | DE <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/DE.png" alt="DE" height="20" /></a>  
  <a href="README-FR.md"> | FR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/FR.png" alt="FR" height="20" /></a>  
  <a href="README-AR.md"> | AR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AR.png" alt="AR" height="20" /></a>  
  <a href="README-NL.md"> | NL <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/NL.png" alt="NL" height="20" /></a>  
</div>

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
