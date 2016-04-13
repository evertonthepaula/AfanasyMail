<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EmailBuilder {

    public function buildEmail($dbData,$inputData,$bodyPath)
    {
        ob_start();
        extract(
            array(  'emp_tel' => $dbData->CONFIG_TELEFONE_01
                    ,'logradouro' => $dbData->CONFIG_LOGRADOURO
                    ,'numero' => $dbData->CONFIG_NUMERO
                    ,'cidade' => $dbData->CONFIG_CIDADE
                    ,'bairro' => $dbData->CONFIG_BAIRRO
                    ,'cep' => $dbData->CONFIG_CEP
                    ,'corpo' => $this->buildTemplate($inputData,$bodyPath)
                )
            );
        include 'emailtemplate.phtml';
        return ob_get_clean();
    }

    public function buildTemplate($inputData, $bodyPath)
    {
        ob_start();
        extract($inputData);
        include $bodyPath;
        return ob_get_clean();
    }


}


/**********************
$inputData[]
Função contato 
$inputData['destinatario','tipo_contato','asusnto','nome','email','telefone','mensagem'];
Função orçamento 
$inputData['destinatario','tipo_contato','asusnto','nome','email','telefone','mensagem','cidade','estado'];
**/