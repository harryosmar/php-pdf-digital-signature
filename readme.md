# PDF Generator with Digital Signature applied


## How to setup & run

```
composer install

# this will generate .pdf file in storage/logs/
php bin/console.php app:pdf-generate

# Open https://account.ascertia.com/demos/PDFSignatureVerificationStep1 to verify the newly generated file
``` 



## How the Digital Signature applied

```
# generate new .crt file, it's contained certificate & private key
openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout filename.crt -out filename.crt

# convert .crt to binar .p12 file
openssl pkcs12 -export -in tcpdf.crt -out filename.p12

# get private key from .p12 file, it will ask for passphrase/password, so the generated private key will be encrypted
openssl pkcs12 -in filename.p12 -nocerts -out filename.key

# get certificate from .p12 file
openssl pkcs12 -in filename.p12 -clcerts -nokeys -out filename.crt
``` 

```php
<?php
/** @var TCPDF $pdf */
$pdf->setSignature('file://PATH-TO-CRT-FILE', 'file://PATH-TO-PRIVATE-KEY-FILE', 'PRIVATE-KEY-FILE-PASSPHRASE', '', 2, $info);
```