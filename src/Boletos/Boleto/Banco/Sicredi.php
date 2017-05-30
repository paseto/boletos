<?php

namespace Boletos\Boleto\Banco;

use Boletos\Boleto\Banco as BancoAbstract;
use Boletos\Boleto\Boleto;
use Boletos\Boleto\Util\Numero;
use Boletos\Boleto\Util\Modulo;

class Sicredi extends BancoAbstract
{
    protected function init()
    {
        $this->setCarteira('C');
        $this->setEspecie('R$');
        $this->setEspecieDocumento('OS');
        $this->setCodigo('748');
        $this->setDigitoVerificador('X');
        $this->setNome('Sicredi');        
        $this->setAceite('N');
        $this->setLogomarca('logosicredi.jpg');
        $this->setLocalPagamento('Pagável em qualquer Banco até o vencimento');
    }

  /**
   * @param Boleto $boleto
   *
   * @return int|string
   */
  public function getDigitoVerificadorNossoNumero(Boleto $boleto)
  {
      $nnum = $boleto->getCedente()->getAgencia().$this->getPosto().$boleto->getCedente()->getConta().date('y').$this->getByte().$boleto->getNossoNumero();

    //$nnum = $this->getNossoNumeroSemDigitoVerificador($boleto);
    //dv do nosso número
    return $this->digitoVerificadorNossonumero($nnum);
  }

  /**
   * @param Boleto $boleto
   *
   * @return string
   */
  public function getNossoNumeroSemDigitoVerificador(Boleto $boleto)
  {
      return date('y').$this->getByte().$boleto->getNossoNumero();
  }

  /**
   * @param Boleto $boleto
   *
   * @return string
   */
  public function getNossoNumeroComDigitoVerificador(Boleto $boleto)
  {
      return date('y').$this->getByte().$boleto->getNossoNumero();
  }

  /**
   * @param Boleto $boleto
   *
   * @return string
   */
  public function getCarteiraENossoNumeroComDigitoVerificador(Boleto $boleto)
  {
      return date('y').'/'.$this->getByte().$boleto->getNossoNumero().'-'.$this->getNossoNumeroComDigitoVerificador($boleto);
  }

  /**
   * @param Boleto $boleto
   *
   * @return string
   */
  public function getDigitoVerificadorCodigoBarras(Boleto $boleto)
  {
      $cl = ($this->getCarteira() == 'C' ? '3' : '1').
        '1'.
        Numero::formataNumero($boleto->getNossoNumeroSemDigitoVerificador().$boleto->getDigitoVerificadorNossoNumero(), 9, 0).
        Numero::formataNumero($boleto->getCedente()->getAgencia(), 4, 0).
        Numero::formataNumero($this->getPosto(), 2, 0).
        Numero::formataNumero($boleto->getCedente()->getConta(), 5, 0).
        '10';
      $campoLivre = $cl.$this->digitoVerificadorCampoLivre($cl);

      $numero = $this->getCodigo().$boleto->getNumeroMoeda().$boleto->getFatorVencimento().Numero::formataNumero($boleto->getValorBoleto(), 10, 0).$campoLivre;

      $resto2 = Modulo::modulo11($numero, 9, 1);
      if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
          $dv = 1;
      } else {
          $dv = 11 - $resto2;
      }

      return $dv;
  }

  /**
   * @param $numero
   *
   * @return int|string
   */
  public function digitoVerificadorNossonumero($numero)
  {
      $resto2 = Modulo::modulo11($numero, 9, 1);
      $digito = 11 - $resto2;
      if ($digito > 9) {
          $dv = 0;
      } else {
          $dv = $digito;
      }

      return $dv;
  }

  /**
   * @param $numero
   *
   * @return int|string
   */
  public function digitoVerificadorCampoLivre($numero)
  {
      $resto2 = Modulo::modulo11($numero, 9, 1);
      if ($resto2 <= 1) {
          $dv = 0;
      } else {
          $dv = 11 - $resto2;
      }

      return $dv;
  }

  /**
   * @param Boleto $boleto
   *
   * @return string
   */
  public function getLinha(Boleto $boleto)
  {
      $cv = ($this->getCarteira() == 'C' ? '3' : '1').
        '1'.
        Numero::formataNumero($boleto->getNossoNumeroSemDigitoVerificador().$boleto->getDigitoVerificadorNossoNumero(), 9, 0).
        Numero::formataNumero($boleto->getCedente()->getAgencia(), 4, 0).
        Numero::formataNumero($this->getPosto(), 2, 0).
        Numero::formataNumero($boleto->getCedente()->getConta(), 5, 0).
        '10';
      $campoLivre = $cv.$this->digitoVerificadorCampoLivre($cv);

      return
        $this->getCodigo().
        $boleto->getNumeroMoeda().
        $boleto->getDigitoVerificadorCodigoBarras().
        $boleto->getFatorVencimento().
        $boleto->getValorBoletoSemVirgula().
        $campoLivre
    ;
  }
}
