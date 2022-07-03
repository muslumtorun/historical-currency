# Geçmişe Dayalı Döviz Kurları - PHP Library
### a) Ne işe yarar
TCMB veritabanında yayınlanmış; belirtilen tarihte kayıtlı döviz kurlarına ait XML datalarını almanıza yarayan bir kütüphanedir. Sizde kendi API'nizi oluşturabilir ya da daha da geliştirebilir ve kendi projelerinizde farklı amaçlar için kullanabilirsiniz. Yayınlanmış olan örnek XML kaynağını incelemek için [https://tcmb.gov.tr/kurlar/today.xml](https://tcmb.gov.tr/kurlar/today.xml) adresini ziyaret edebilirsiniz.

### b) Özellikler
- Tarih belirtiebilme
- Belirtilen tarihe ait URL'nin türetilmesi
- Belirtilen tarihe ait ham XML verisinin eldesi
- Çoklu kur bilgileri ve kurlara ait kod listesi
- Belirtilen koda ait kurların alınması

### c) Bunlar aklınızda bulunsun
1. TCMB kayıtlarında hafta sonları için kur bilgi yer almaz. Dolayısıyla kütüphane o haftaya ait Cuma günü verilerini getirir.
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
$fetch = new TCMB\Historical\HCurrency("2021-05-16");
```
### 2. Metodlar
- `getCurrencies()` Belirtilen tarihe ait tüm kurları _**array**_ olarak getirir.
- `getCurrency()` Tek bir _**string**_ parametre alır ve parametreye göre kur bilgilerini _**array**_ olarak getirir. Default olarak _usd_ ayarlanmıştır.
- `listCurrencyCodes()` Geçerli kur kodlarını ve ülke bilgilerini _**array**__ olarak getirir.
- `isCurrencyCodeValid()` Tek bir _**string**_ parametre alır ve seçili parametrenin geçerliliğini kontrol eder. _true_ ya da _false_ döndürür.
- `getURL()` Çözümlenen TCMB url'sini _**string**_ olarak getirir.
- `getXML()` Belirtilen tarihe ait ham XML verisini _**string**_ olarak döndürür.
- `getDate()`Belirtilen tarihi _**string**_ olarak geri döndürür.

## Örnek
```php
$fetch = new TCMB\Historical\HCurrency("2022-06-29");
$eur = $fetch->getCurrency("eur");

$kur_adi = $eur["Isim"];
$kur_satis = $eur["BanknoteSelling"] //Forex için; ForexSelling
$kur_alis = $eur["BanknoteBuying"] //Forex için; ForexBuying
```
