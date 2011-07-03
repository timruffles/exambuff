<?php 
class Support extends EB_Controller {
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'marker';

	
	private $_baseURL = '/marker/support';
	
	function index() {
		if($this->input->post('submit')) {
			if($this->_checkToken()) {
				$this->load->library('validation');
				
				$rules['subject'] = 'required|max_length[128]';
				$rules['message'] = 'required';
				
				$this->validation->set_rules($rules);
				
				if($this->validation->run()) {
					$this->load->model('ticket');
					$this->ticket->set('email',$this->_getUser());
					$this->ticket->set('subject',$this->input->post('subject'));
					$this->ticket->set('message',$this->input->post('subject'));
					$this->ticket->create();
					$this->ticket->setKey($this->ticket->getInsertID());
					$this->session->set_flashdata('ticketReference',$this->ticket->keyForEmail());
					$this->session->set_flashdata('subject',$this->ticket->get('subject'));
					$this->session->set_flashdata('message',$this->ticket->get('message'));
					redirect($this->_baseURL.'/sent');
				}
			} else {
				$viewData['errors'][] = 'Your form submission was invalid.';
			}
		}
		$viewData['formAction'] = site_url($this->_baseURL);
		$viewData['token'] = $this->_token();
		$this->_template('forms/support_ticket','Submit a support ticket','support',$viewData);
	}
	function sent() {
		if(!$this->session->flashdata('ticketReference')) redirect(site_url($this->_baseURL));
		$viewData['ticketReference'] = $this->session->flashdata('ticketReference');
		$viewData['subject'] = $this->session->flashdata('subject');
		$viewData['message'] = $this->session->flashdata('message');
		$this->_template('response/ticket_sent','You have successfully sent a ticket','support',$viewData);
	}
}