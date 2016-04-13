<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('EmailController.php');
require_once('EmailBuilder.php');

class EmailSender {

    protected $CI;
    private $bodyMail;
    private $dbData;


    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->model('basic_model');
        $this->dbData = $this->CI->basic_model->admin();
        $this->bodyMail = new EmailBuilder();
    }   


    public function sendEmail( $inputData, $bodyPath )
    {

    /****------------------------
    Envia os dados para contrução do template de e-mail passando os seguintes parametros:
    (dados do cliente, dados dos input, caminho para o arquivo do corpo do e-mail)
    -------------------------***/
        $corpoEmail = $this->bodyMail->buildEmail( $this->dbData, $inputData, $bodyPath );
        
    /****------------------------
    Pega o email do cliente gravado no banco de dados, de acordo com o tipo de fomrulario que este e-mail vai receber. Ex:'Contato'
    -------------------------***/
        $dbMail = $this->CI->basic_model->getEmail($inputData['tipo_contato']);

    /****------------------------
        Pega o corpo do e-mail e chama a função de envio passando os seguintes parametros:
        (dados do cliente, e-mail do cliente, dados dos inputs, corpo da mensagem a ser enviada )
    -------------------------***/
        $mailControl = new EmailController();
        return $mailControl->initializeMail($this->dbData, $dbMail, $inputData, $corpoEmail);

    }


}


/**********************
$inputData[]
Função contato 
$inputData['tipo_contato','asusnto','nome','email','telefone','mensagem'];
Função orçamento 
$inputData['tipo_contato','asusnto','nome','email','telefone','mensagem','cidade','estado'];
**/