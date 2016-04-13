<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// if(ENVIRONMENT === 'development') $this->output->enable_profiler(TRUE);
		$this->load->library('validateCaptcha/CaptchaStrategy');
		$this->load->library('emails/EmailSender');
	}

	public function index()
	{
	#Titulo doctype
		$data['tituloSite'] = 'Contato';
	#controle metaTags redes sociais(twiter/facebook)
		$data['canonical'] = $this->uri->segment(1);
		$data['MetaMarkupTitle'] = $data['tituloSite'];
	#controle metaTags redes sociais(twiter/facebook)
		$data['breadcrumbs'] = createBread($this->uri->segment(1) , $data['tituloSite']);
		$data['admin2'] = $this->basic_model->admin();
		$data['telefones'] = $this->basic_model->getPhones();
		$data['skype'] = $this->basic_model->getAcesso(1);
		$this->template->load('template','page_contato', $data);
	}

	public function enviar()
	{
		$captchaInput = $this->input->post("captchaInput");
		$captchaHash = $this->input->post("captchaInputHash");
		$captchaTest = $this->captchastrategy;
		
		if ( $captchaTest->initialize->testMyCaptcha($captchaHash,$captchaInput) )
		{
			$dados = array(
				'inputs' => array(
						'nome' 		=> $this->input->post("c-nome")
						,'email' 	=> $this->input->post("c-email")
						,'telefone' => $this->input->post("c-telefone")
						,'assunto'	=> $this->input->post("c-assunto")
					)
				,'mensagem' 	=> $this->input->post("c-mensagem")
				,'tipo_contato' => 'contato'
				,'ip' => $_SERVER['REMOTE_ADDR']
			);
			// envia o email
			if($this->emailsender->sendEmail($dados,'emailCorpoAutoContato.phtml')){
				$this->session->set_flashdata('retorno', "msg-sucesso");
			} else {
				$this->session->set_flashdata("retorno", "msg-erro");
			}
		} else {
			$this->session->set_flashdata("retorno", "captcha-erro");
		}

		redirect("contato");

	}

}