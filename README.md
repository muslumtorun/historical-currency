# Güncel ve Geçmişe Dayalı Döviz Kurları - PHP [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

### a) Ne işe yarar
TCMB veritabanında yayınlanmış, belirtilen tarihte kayıtlı döviz kurlarına ait XML datalarını almanıza yarayan bir kütüphanedir. Sizde kendi API servisinizi oluşturabilir ya da daha da geliştirebilir ve kendi projelerinizde farklı amaçlar için kullanabilirsiniz. Yayınlanmış olan örnek XML kaynağını incelemek için [https://tcmb.gov.tr/kurlar/today.xml](https://tcmb.gov.tr/kurlar/today.xml) adresini ziyaret edebilirsiniz.

### b) Özellikler
- Günün kur bilgileri,
- Seçili tarihe ait tekil ya da çoğul kur bilgileri,
- Forex ya da bankaya ait değerlerin tercihi,
- Verilerin ham XML, JSON ve Array olarak elde edilmesi,
- Dataya giden çözümlenmiş TCMB URL'si

### c) Bunlar aklınızda bulunsun
1. TCMB kayıtlarında hafta sonları için kur bilgisi yer almaz. Dolayısıyla kütüphane o haftaya ait Cuma günü verilerini getirir.
2. 01 Mayıs 1996 tarihinden sonraki kayıtlara ulaşılabilinmektedir.
3. Bazı kur bilgileri TCMB tarafından boş bırakılmış olabilir.

## Kullanım bilgileri
Tüm metodlar `HCurrency` sınıfı üzerinden çağrıacak olup, bu sınıf şu anda genişletilmeye kapalıdır. `HCurrency`sınıfı **_string_** türünde tek bir parametre kabul eder. _**Parametre formatı:**  yyyy-mm-dd_

**TCMB'den dönen yanıt:** Her bir kolon `array` içerisindeki `key`'leri temsil eder.
| CrossOrder | Kod | CurrencyCode | Unit | Isim       | CurrencyName | ForexBuying | ForexSelling | BanknoteBuying | BanknoteSelling | CrossRateUSD | CrossRateOther |
|------------|-----|--------------|------|------------|--------------|-------------|--------------|----------------|-----------------|--------------|----------------|
| 0          | USD | USD          | 1    | ABD Doları | US Dollar    | 0.00        | 0.00         | 0.00           | 0.00            |              |                |

### 1. Sınıfın çağrılması
```php
$fetch = new TCMB\Historical\HCurrency("2021-05-16"); //günün kurları için boş bırakınız
```
### 2. Metodlar
- `getCurrencies()` Belirtilen tarihe ait tüm kurları _**array**_ olarak getirir.
- `getCurrency()` Tek bir _**string**_ parametre alır ve parametreye göre kur bilgilerini _**array**_ olarak getirir. Default olarak _usd_ ayarlanmıştır.
- `listCurrencyCodes()` Geçerli kur kodlarını ve ülke bilgilerini _**array**_ olarak getirir.
- `isCurrencyCodeValid()` Tek bir _**string**_ parametre alır ve seçili parametrenin geçerliliğini kontrol eder. _true_ ya da _false_ döndürür.
- `getURL()` Çözümlenen TCMB url'sini _**string**_ olarak getirir.
- `getXML()` Belirtilen tarihe ait ham XML verisini _**string**_ olarak döndürür.
- `getJSON()`Belirtilen tarihe ait verileri _**string**_ olarak _**JSON**_ formatında verir.
- `getDate()`Belirtilen tarihi _**string**_ olarak geri döndürür.

### 3. Kur Tipleri
```php
use TCMB\Historical\Types\CurrencyCode;
```

- `CurrencyCode::USD`Amerikan Doları
- `CurrencyCode::EUR`Euro
- ...

Diğer türler için Types'leri inceleyebilirsiniz.

### 4. Cevap (Karşıdan dönen) Tipleri
```php
use TCMB\Historical\Types\Response;
```

- `Response::Kod`Uluslar arası kur kodu
- `CurrencyCode::BanknoteBuying`Banka alış değerleri
- ...

Diğer türler için Types'leri inceleyebilirsiniz.


## Örnek
```php
use TCMB\Historical\HCurrency;
use TCMB\Historical\Types\CurrencyCode;
use TCMB\Historical\Types\Response;

//bugün için parametreyi boş bırakın
$fetch = new HCurrency("2022-06-29");

//euro bilgileri için
$eur = $fetch->getCurrency(CurrencyCode::EUR);

$kur_adi = $eur(Response::ISIM);
$kur_satis = $eur(Response::BANKNOTESELLING);
$kur_alis = $eur(Response::BANKNOTEBUYING);
```
