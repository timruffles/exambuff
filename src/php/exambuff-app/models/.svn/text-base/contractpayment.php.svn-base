<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
class ContractPayment extends Crud {
	public function ContractPayment($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('ID'=>'',
						    'marker'=>'',
							'amount'=>'',
							'marks'=>'',
							'dateSent'=>'',
							'dateReceived'=>'');
		$this->table = 'contractPayments';
		$this->key = 'ID';
	}
	public function pay(Marker $marker,$marks,$amount) {
		if(!is_numeric($amount)) throw new Exception ('ContractPayment requires amount as a number');
		if(!is_array($marks)) {
			if(!$marks instanceof Mark) {
				throw new Exception('ContractPayment requires either an array of Marks, or a Mark as second argument');
			}
			// put the single script in an array
			$marks = array($marks);
		}
		// get each mark's key, and set status to paid
		foreach($marks as $mark) {
			if(!$marks instanceof Mark)	throw new Exception('ContractPayment requires either an array of Marks as second argument');
			$markIDs[] = $mark->getKey();
		}
		$markIDs = serialize($markIDs);
		$this->set('marker',$marker->getKey());
		$this->set('marks',$markIDs);
		$this->set('amount',$amount);
		$this->set('dateSent',null);
		if(!$result = $this->create()) throw new Exception('Could not create new contract payment'); 
		foreach($marks as $mark) {
			$mark->paid();
			$mark->update();
		}
		return $result;
	}
	public function get($field) {
		if($field === 'marks') {
			return unserialize($this->data['marks']);
		}
		return Crud::get($field);
	}
}