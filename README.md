# Turkish Identity Validator (TCKN & VKN)

🇹🇷 T.C. Kimlik Numarası (TCKN) ve Vergi Kimlik Numarası (VKN) doğrulama paketi

PHP 8.4+ için geliştirilmiş, basit ve hızlı bir doğrulama kütüphanesidir.

## Özellikler

- ✅ TCKN (T.C. Kimlik Numarası) doğrulama
- ✅ VKN (Vergi Kimlik Numarası) doğrulama
- ✅ Otomatik tip algılama
- ✅ Detaylı doğrulama sonuçları
- ✅ %100 test coverage
- ✅ PHP 8.4+ ile modern kod yapısı
- ✅ Bağımlılık yok (sıfır dependency)

## Kurulum

```bash
composer require yourvendor/tr-identity-validator
```

## Kullanım

### Basit Kullanım

```php
use TrIdentityValidator\IdentityValidator;

$validator = new IdentityValidator();

// TCKN Doğrulama
$isValid = $validator->validateTckn('10000000146');
// true

// VKN Doğrulama
$isValid = $validator->validateVkn('1234567801');
// true
```

### Otomatik Tip Algılama

```php
$result = $validator->validateAuto('10000000146');

/*
Array
(
    [valid] => true
    [number] => 10000000146
    [type] => TCKN
    [detected_type] => TCKN
    [length] => 11
    [algorithm] => Turkish Ministry of Interior TCKN Algorithm
)
*/
```

### Detaylı Sonuç Alma

```php
// TCKN için detaylı sonuç
$result = $validator->validateTcknWithDetails('10000000146');

// VKN için detaylı sonuç
$result = $validator->validateVknWithDetails('1234567801');
```

### Doğrudan Validator Sınıflarını Kullanma

```php
use TrIdentityValidator\Validators\TcknValidator;
use TrIdentityValidator\Validators\VknValidator;

$tcknValidator = new TcknValidator();
$vknValidator = new VknValidator();

$isValidTckn = $tcknValidator->validate('10000000146');
$isValidVkn = $vknValidator->validate('1234567801');
```

## API Referansı

### IdentityValidator

Ana validator sınıfı. Tüm doğrulama işlemlerini yönetir.

#### Metodlar

- `validateTckn(string $tckn): bool` - TCKN doğrular
- `validateVkn(string $vkn): bool` - VKN doğrular
- `validateTcknWithDetails(string $tckn): array` - Detaylı TCKN doğrulama
- `validateVknWithDetails(string $vkn): array` - Detaylı VKN doğrulama
- `validateAuto(string $number): array` - Otomatik tip algılama ile doğrulama
- `getTcknValidator(): TcknValidator` - TCKN validator instance'ı döner
- `getVknValidator(): VknValidator` - VKN validator instance'ı döner

### TcknValidator

T.C. Kimlik Numarası doğrulama sınıfı.

#### Metodlar

- `validate(string $tckn): bool` - TCKN doğrular
- `validateWithDetails(string $tckn): array` - Detaylı sonuç döner

### VknValidator

Vergi Kimlik Numarası doğrulama sınıfı.

#### Metodlar

- `validate(string $vkn): bool` - VKN doğrular
- `validateWithDetails(string $vkn): array` - Detaylı sonuç döner

## Algoritmalar

### TCKN Algoritması

İçişleri Bakanlığı'nın yayınladığı TCKN algoritması kullanılır:

1. 11 haneli olmalı
2. İlk hane 0 olamaz
3. 10. hane: (1. + 3. + 5. + 7. + 9. hanelerin toplamı × 7) - (2. + 4. + 6. + 8. hanelerin toplamı) mod 10
4. 11. hane: İlk 10 hanenin toplamı mod 10

### VKN Algoritması

Gelir İdaresi Başkanlığı'nın yayınladığı VKN algoritması kullanılır:

1. 10 haneli olmalı
2. Her hane için: ((hane + sıra) mod 10) × 2^sıra mod 9 (0 ise 9)
3. Son hane: (10 - (toplam mod 10)) mod 10

## Test

```bash
composer test
```

veya

```bash
./vendor/bin/phpunit
```

## Gereksinimler

- PHP 8.4 veya üstü

## Lisans

MIT License

## Katkıda Bulunma

Pull request'ler memnuniyetle karşılanır. Büyük değişiklikler için lütfen önce bir issue açın.

## Yasal Uyarı

Bu paket sadece algoritma doğrulaması yapar. MERNİS veya herhangi bir devlet sistemine bağlanmaz. Gerçek kişi doğrulaması için resmi sistemleri kullanmanız gerekmektedir.

## Destek

Sorularınız için issue açabilir veya e-posta gönderebilirsiniz.

---

Made with ❤️ for Turkish Developers
