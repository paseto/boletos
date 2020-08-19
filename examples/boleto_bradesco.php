<?php
require '../vendor/autoload.php';

use Boleto\Banco\Bradesco;
use Boleto\Boleto;


$oBoleto = new Boleto();

$oBoleto->setBanco(new Bradesco());

$oBoleto->setNumeroMoeda("9");
$oBoleto->setDataVencimento(DateTime::createFromFormat('d/m/Y', "07/07/2014"));
$oBoleto->setDataDocumento(DateTime::createFromFormat('d/m/Y', "10/07/2014"));
$oBoleto->setDataProcessamento(DateTime::createFromFormat('d/m/Y', "10/07/2014"));
$oBoleto->addDemonstrativo('Pagamento de Compra na Móveis Simonetti');
$oBoleto->addInstrucao("- Sr. Caixa, não receber após o vencimento");
$oBoleto->addInstrucao("- Pedido cancelado após o vencimento");
$oBoleto->addInstrucao("- Em caso de dúvidas entre em contato conosco: www.moveissimonetti.com.br");
$oBoleto->setValorBoleto("1200,00");
$oBoleto->setNossoNumero("50000012151");
$oBoleto->setNumeroDocumento("50000012151");

$oCedente = new \Boleto\Cedente();
$oCedente->setNome("Loja Moveis Mix");
$oCedente->setAgencia("1859");
$oCedente->setDvAgencia("7");
$oCedente->setConta("3176");
$oCedente->setDvConta("3");
$oCedente->setEndereco("Rua Carlos Castro, N&ordm; 245, Centro");
$oCedente->setCidade("Pinheiros");
$oCedente->setUf("ES");
$oCedente->setCpfCnpj("128.588.555-13");

$oBoleto->setCedente($oCedente);

$oSacado = new \Boleto\Sacado();
$oSacado->setNome("Vinicius Silva");
$oSacado->setTipoLogradouro("Rua");
$oSacado->setEnderecoLogradouro("Bartolomeu da Gama");
$oSacado->setNumeroLogradouro("100");
$oSacado->setCidade("São Mateus");
$oSacado->setUf("ES");
$oSacado->setCep("29980-000");

$oBoleto->setSacado($oSacado);

$oGeradorBoleto = new \Boleto\GeradorBoleto();
$gerar = $oGeradorBoleto->gerar($oBoleto);
$gerar->Output();
