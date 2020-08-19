# Gerador de Boletos PDF

[![Build Status](https://travis-ci.org/paseto/boletos.svg?branch=master)](https://travis-ci.org/paseto/boletos)
[![Latest Stable Version](https://poser.pugx.org/paseto/boletos/v/stable)](https://packagist.org/packages/paseto/boletos)
[![Total Downloads](https://poser.pugx.org/paseto/boletos/downloads)](https://packagist.org/packages/paseto/boletos)
![](https://img.shields.io/github/license/paseto/boleto.svg)

Gera boletos em PDF padrão CNAB 400.

### Setup

```sh
$ composer require paseto/boletos
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
