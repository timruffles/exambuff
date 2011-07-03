<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
class Mark extends Crud {
	public function Offer($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('id'=>'',
                                    'question'=>'',
                                    'value' =>'',
                                    'count'=>''
                                    );
		$this->table = 'offers';
		$this->key = 'script';
	}
        public function getOffersAsArray() {
            $this->load->library('session');
            $this->load->model('offer');
            $offerId = $this->session->userdata('offer');
            $this->offer->retrieve($offerId);
            
            if($offerId) {
                return array('question'=>$this->offer->get('label'),'value'=>$this->offer->get('value'));
            } else {
                return array();
            }
        }
}