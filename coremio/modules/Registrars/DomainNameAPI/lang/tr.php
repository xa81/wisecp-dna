<?php

return [
    'name'                 => 'DomainNameAPI',
    'description'          => "Popüler alan adı tescil firmalarından biri olan domainnameapi.com ile domain api üzerinden tüm alan adı işlemlerini anlık olarak sağlayabilirsiniz. Bunun için domainnameapi.com müşteri hesabı bilgilerinizi aşağıdaki alanlara tanımlayınız.",
    'importTldButton'      => "750+ Uzantıyı İçeri Aktar",
    'fields'               => [
        'balance'       => "Bakiye",
        'username'      => "Bayi Kullanıcı Adınız",
        'password'      => "Bayi Şifreniz",
        'test-mode'     => 'Test Modu',
        'privacyFee'    => "Whois Gizleme Ücreti",
        'adp'           => "Maliyetleri Oto Güncelle",
        'importTld'     => "Uzantıları İçeri Aktar",
        'cost-currency' => "Maliyet Para Birimi",
    ],
    'desc'                 => [
        'privacyFee'    => "<br>Müşterilerinizden whois bilgisi gizlemek için ücret talep edebilirsiniz.",
        'test-mode'     => "Test modunda işlem yapmak için aktif ediniz.",
        'adp'           => "Maliyetleri her gün otomatik olarak çeker ve belirlediğiniz kâr oranında satış fiyatlarını tanımlar.",
        'importTld-1'   => "Api üzerinde kayıtlı tüm uzantıları otomatik olarak içeri aktar.",
        'importTld-2'   => "Api üzerinde kayıtlı bulunan tüm alan adı uzantıları ve maliyetleri toplu olarak içeri aktarılacaktır.",
        'cost-currency' => '',
    ],
    'tabDetail'            => 'Api Bilgileri',
    'tabImport'            => "Alan Adlarını İçeri Aktar",
    'testButton'           => "Bağlantıyı test et",
    'importNote'           => "Servis sağlayıcı üzerinde bulunan alan adlarını, mevcut müşterilerinize kolaylıkla aktarabilirsiniz. Bu işlemi yaptığınızda, ilgili alan adları sipariş olarak müşterilerinize tanımlanır. Sistemde zaten kayıtlı olan alan adları yeşil olarak renklendirilmiştir.",
    'importStartButton'    => "İçeri Aktar",
    'saveButton'           => "Ayarları Kaydet",
    'error1'               => "Api bilgileri mevcut değil.",
    'error2'               => "Domain ve uzantı bilgisi gelmedi.",
    'error3'               => "Kişi kimliği alınırken hata oluştu.",
    'error4'               => "Durum bilgisi alınamadı.",
    'error5'               => "Transfer bilgisi alınamadı.",
    'error6'               => "Api sağlayıcısı üzerinde işlem yaptıktan sonra, siparişin durumunu aktif edebilirsiniz.",
    'error7'               => "Sunucunuzda PHP Soap kurulu değil veya etkin değil. Lütfen servis sağlayıcınızdan destek isteyiniz.",
    'error8'               => "Lütfen api bilgilerini giriniz.",
    'error9'               => "İçe Aktarma İşlemi Başarısız Oldu",
    'error10'              => "Bir hata oluştu.",
    'error11'              => "Firma ünvanı en az 2 kelime içermelidir.",
    'success1'             => "Ayarlar Başarıyla Kaydedildi.",
    'success2'             => "Bağlantı testi başarılı.",
    'success3'             => "İçeri Aktarma Başarıyla Tamamlandı.",
    'success4'             => "Uzantılar Başarıyla İçeri Aktarıldı.",
    'headerImport'         => "Aşağıdaki Alan adları İçe Aktarılacak",
    'noImportDomains'      => "İçe aktarılacak alan adı bulunamadı.",
    'importQuestion'       => " domain aktarılacak. Emin misiniz?",
    'yes'                  => "Evet",
    'no'                   => "Hayır",
    'importProcessing'     => "İçe aktarma işlemi sürüyor...",
    'process'              => 'İşlem',
    'importFinished'       => 'İçe aktarma işlemi tamamlandı.',
    'okey'                 => 'Tamam',
    'tabImportTld'         => 'Uzantıları İçeri Aktar',
    'importTldNote'        => 'Api üzerinde kayıtlı bulunan seçtiğiniz adı uzantıları ve maliyetleri seçip toplu olarak içeri aktarabilirsiniz. Tüm fiyatlama usd üzerinden hesaplanmakta. Otomatik seknron dışı bırakmak için Excl(Exclude) seçeneğini işaretleyiniz',
    'tld'                  => 'Uzantı',
    'dna'                  => 'DNA?',
    'cost'                 => 'Maliyet',
    'current'              => 'Satış',
    'margin'               => 'Kâr',
    'register'             => 'Kayıt',
    'renew'                => 'Yenileme',
    'transfer'             => 'Transfer',
    'noTldSelected'        => 'Hiç TLD seçilmedi',
    'noTldSelectedDesc'    => 'Lütfen içeri aktarılacak TLD seçin',
    'numofTLDSelected'     => ' uzantıyı senkronluyorsunuz, emin misiniz?',
    'numofTLDSynced'       => ' uzantı senkronizasyonu bitti',
    'numofTLDSyncedTxt'    => 'İşlem başarıyla tamamlandı',
    'numofTLDNotSynced'    => 'Hata',
    'numofTLDNotSyncedTxt' => 'Bir hata oluştu. Lütfen tekrar deneyin.',
    'stillProcessing'      => 'İşlem devam ediyor...',


];
