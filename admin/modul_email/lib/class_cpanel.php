<?php

	class CPanelim
	{
	public $ip;
	public $account; 
	public $password; 
	public $port; 
	public $domail; 
	public $user_email;
	public $new_user_email; 
	public $new_user_pwd; 
	public $new_user_pwd2;
	public $old_user_pwd;
	public $email_forward;  
	
	public function __construct()
	{
	$this->ip = HOST_IP;
	$this->account = C_KULLANICI;
	$this->password = C_PAROLA;
	$this->port = C_PORT;
	$this->domain = DOMAIN;
	$this->userid = isset($user_email);
	$this->new_user_email = isset($new_user_email);
	$this->new_user_pwd = isset($new_user_pwd);
	$this->new_user_pwd2 = isset($new_user_pwd2);
	$this->old_user_pwd = isset($old_user_pwd);
	$this->email_forwarder = isset($email_forwarder);
	}
	//List email
	public function Emailler(){
	$xmlapi = new xmlapi($this->ip);
	$xmlapi->set_port($this->port);
	$xmlapi->password_auth($this->account, $this->password);
	$xmlapi->set_debug(0);
	$result = $xmlapi->api2_query($this->account, "Email", "listpopswithdisk");
	return $result; 
	}
	//create
	public function EmailEkle($email_user,$email_pass,$email_quota,$email_forward){
	$xmlapi = new xmlapi($this->ip);
	$xmlapi->set_port($this->port);
	$xmlapi->password_auth($this->account, $this->password);
	$call = array(domain=>$this->domain, email=>$email_user, password=>$email_pass, quota=>$email_quota);
	$call_f  = array(domain=>$this->domain, email=>$email_user, fwdopt=>"fwd", fwdemail=>$email_forward);
	$xmlapi->set_debug(0);
	$result = $xmlapi->api2_query($this->domain, "Email", "addpop", $call ); 
	$result_forward = $xmlapi->api2_query($this->account, "Email", "addforward", $call_f);
	//if ($result->data->result == 1){
	//header('location:ekle.php?msg='.$email_user.'@'.$this->domain.'');
	//} else {
	//header('location:ekle.php?msg='.$result->data->reason.'');
	  //break;
	//}
	
	}
	//update 
	public function EmailGuncelle($user_email,$newpass){
	$msg = '';
	if (!empty($user_email))
	while(true) {
	$xmlapi = new xmlapi($this->ip);
	$xmlapi->set_port($this->port);
	$xmlapi->password_auth($this->account, $this->password);
	$call = array(domain=>$this->domain, email=>$user_email, password=>$newpass);
	$xmlapi->set_debug(0);
	$result = $xmlapi->api2_query($this->account, "Email", "passwdpop", $call ); 
	if ($result->data->result == 1){
	$msg = $email_user.'@'.$this->domain.' account password changed';
	} else {
	$msg = $result->data->reason;
	  break;
	}
	break;
	}}
	//delete email
	public function EmailSil($user_email){
	if (!empty($user_email)){
	$xmlapi = new xmlapi($this->ip);
	$xmlapi->set_port($this->port);
	$xmlapi->password_auth($this->account, $this->password);
	$call = array(domain=>$this->domain, email=>$user_email);
	$xmlapi->set_debug(0);
	$result = $xmlapi->api2_query($this->account, "Email", "delpop", $call ); 
	}
}
	}//end class
?>