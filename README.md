# Geçmişe Dayalı Döviz Kurları - PHP Library
### Ne işe yarar
TCMB veritabanında yayınlanmış; belirtilen tarihte kayıtlı döviz kurlarına ait XML datalarını almanıza yarayan bir kütüphanedir. Sizde kendi API'nizi oluşturabilir ya da daha da geliştirebilir ve kendi projelerinizde farklı amaçlar için kullanabilirsiniz. Yayınlanmış olan örnek XML kaynağını incelemek için [https://tcmb.gov.tr/kurlar/today.xml](https://tcmb.gov.tr/kurlar/today.xml) adresini ziyaret edebilirsiniz.

### Özellikler
- Tarih belirtiebilme
- Belirtilen tarihe ait URL'nin türetilmesi
- Belirtilen tarihe ait ham XML verisinin eldesi
- Çoklu kur bilgileri ve kurlara ait kod listesi
- Belirtilen koda ait kurların alınması

### Bunlar aklınızda bulunsun
1. TCMB kayıtlarında hafta sonları için kur bilgi yer almaz. Dolayısıyla kütüphane o haftaya ait Cuma günü verilerini getirir.
2. 01 Mayıs 1996 tarihinden sonraki kayıtlara ulaşılabilinmektedir.

## Kullanım bilgileri
Tüm metodlar `HCurrency` sınıfı üzerinden çağrıacak olup, bu sınıf şu anda genişletilmeye kapalıdır. `HCurrency`sınıfı **_string_** türünde tek bir parametre kabul eder. _**Parametre formatı:**  yyyy-mm-dd_

### 1. Sınıfın çağrılması
```php
$fetch = new TCMB\Historical\HCurrency("2021-05-16");
```

### 2. Tüm kurlar
```php
$fetch->getCurrencies();
```
Dönen yanıt:
```php
array(
  array("buying" => 0, "selling" => 0, "name" => "Currency Name", "name_tr" => "Kur Adı", "date" => null),
  array("buying" => 0, "selling" => 0, "name" => "Currency Name", "name_tr" => "Kur Adı", "date" => null),
  array("buying" => 0, "selling" => 0, "name" => "Currency Name", "name_tr" => "Kur Adı", "date" => null),
  ...
  ...
  .
)
```

### 3. Seçili kur bilgileri almak
```php
// default olarak usd belirtilmiştir
$fetch->getCurrency("eur");
```
Dönen yanıt:
```php
array("buying" => 0, "selling" => 0, "name" => "Currency Name", "name_tr" => "Kur Adı", "date" => null)
```

### 4. Url bilgisi
```php
$fetch->getURL();
```
Dönen yanıt: `string`

### 5. Raw XML verisi
```php
$fetch->getXML();
```
Dönen yanıt: `string`

### 6. Kur kodu geçerliğinin kontrolü
```php
//string olarak tek bir parametre alır ve boolean döndürür
$fetch->isCurrencyCodeValid("usd");
```

Dönen yanıt:
`true`ya da `false`

### 7. Geçerli kur kodlarının listesi
```php
$fecth->listCurrencyCodes();
```
Dönen yanıt:
```php
array(
  array("name" => "Currency Name", "name_tr" => "Kur Adı", "code" => "USD"),
  ...
  .
)
```

## Örnek
```php
$fetch = new TCMB\Historical\HCurrency("2022-06-29");
$usd = $fetch->getCurrency("usd");

echo "{$usd['date']} Tarihli {$usd['name_tr']} Kur Bilgileri <br/>";
echo "Dolar Alış: {$usd['buying']}";
echo "Dolar Satış: {$usd['selling']}";
```
