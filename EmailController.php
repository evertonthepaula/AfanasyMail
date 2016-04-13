<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EmailController extends CI_Email{

    public function __construct(){
        parent::__construct();
    }

    public function initializeMail($dbData, $dbMail, $inputData, $corpoEmail )
    {
        $this->smtpconfig($dbData);
        return $this->emailSend($corpoEmail,$inputData,$dbData);
    }


	private function smtpconfig($dbData)
    {
		$config['protocol'] = 'smtp';
        $config['smtp_host'] = $dbData->CONFIG_SMTP;
        $config['smtp_user'] = $dbData->CONFIG_USUARIO;
        $config['smtp_pass'] = $dbData->CONFIG_SENHA;
        $config['smtp_port'] = '587';
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
       	$this->initialize($config);
	}


    private function emailSend($corpoEmail,$inputData,$dbData)
    {
        if (ENVIRONMENT === 'development') {
            $this->bcc('criacao2@webgopher.com.br');
        }else{
            $this->bcc($dbMail->EMAIL_EMAIL);  
        }

        $this->from($dbData->CONFIG_USUARIO,TITULO_SITE);
        $this->to($inputData['inputs']['email']);
        $this->cc($dbData->CONFIG_USUARIO);
        $this->subject($inputData['inputs']['assunto']);
        $this->message($corpoEmail);

        if ($this->send())
            return true;
        
        return false;
    }


}