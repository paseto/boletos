# Gerador de Boletos PDF

[![Build Status](https://travis-ci.org/paseto/boleto-sicredi.svg?branch=master)](https://travis-ci.org/paseto/boleto-sicredi)
[![Latest Stable Version](https://poser.pugx.org/paseto/boleto-sicredi/v/stable)](https://packagist.org/packages/paseto/boleto-sicredi)
[![Total Downloads](https://poser.pugx.org/paseto/boleto-sicredi/downloads)](https://packagist.org/packages/paseto/boleto-sicredi)
![](https://img.shields.io/github/license/paseto/boleto-sicredi.svg)

Gera boletos em PDF padrão CNAB 400.

### Setup

```sh
$ composer require paseto/boleto-sicredi
```

### Usage

Verificar exemplos na pasta `examples`

### Impressão em lote

Instance PDF class
```sh
$pdf = new \fpdf\FPDF();
...
foreach ($array as $key => $value){
    ...
    $stream = base64_encode($GeradorBoleto->gerar($Boleto)->Output('doc.pdf','S'));
    $GeradorBoleto->gerar($Boleto, $pdf); 
}
 $pdf->Output('doc.pdf', 'I');
```

## Contributing
 
1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D
