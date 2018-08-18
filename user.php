<?php  
require_once('database.php');
require_once("session.php");
class user {
	protected static $table_name = "applicants";
	public $id;
	public $message;
	public $firstnames;
	public $surname;
	public $phonenumber;
	public $email;
	public $coverletter;
	public $passport;
	public $resume;
    public $tem_file;
    public $file_name;
    public $upload_error = array(
        UPLOAD_ERR_OK => "Photo uploaded successfully",
        UPLOAD_ERR_INI_SIZE => "larger than upload_max_filesize",
        UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE",
        UPLOAD_ERR_PARTIAL => "Partial Upload",
        UPLOAD_ERR_NO_FILE => "No File selected, please select a file and re-upload",
        UPLOAD_ERR_NO_TMP_DIR => "No Temporary Directory",
        UPLOAD_ERR_CANT_WRITE => "Can't write to disk",
        UPLOAD_ERR_EXTENSION => "File upload stopped by externsion"
        
    );
    public $error = array();
    public function attributes(){
        return get_object_vars($this);
    }
    public function sanitized_attributes(){
        global $Database;
        $cleaned_attributes = array();
        foreach($this->attributes() as $key => $value){
            $cleaned_attributes[$key] = $Database->escape_value($value);
        }
        return $cleaned_attributes;
    }
      public function attach_file($file){
        global $Database;
        if(!$file || empty($file)|| !is_array($file)){
            $this->error[] = "No file was uploaded";
            return false;
        }
        elseif($file['error']!=0){
            $this->error[] = $this->upload_error[$file['error']];
            return false;
        }else{
        $this->tem_file = $file['tmp_name'];
        $this->file_name = basename($Database->escape_value($file['name']));
        return true;
        }
	  }
	  
	  //the following is the code for registration through user form input
	public function reg(){
        global $Database;
        global $session;
         $this->surname = $Database->escape_value(ucfirst($_POST['surname']));   
         $this->firstnames =$Database->escape_value(ucfirst( $_POST['firstnames']));
         $this->email = $Database->escape_value(strtolower($_POST['email']));
         $this->phonenumber = $Database->escape_value(ucfirst($_POST['phonenumber'])); 
          $this->coverletter = $Database->escape_value(ucfirst($_POST['coverletter']));   
         $this->passport =$Database->escape_value(ucfirst( $_POST['passport']));
         $this->resume = $Database->escape_value(strtolower($_POST['resume']));
         
         if(empty($this->email)){
            $this->message = "<strong style='color:red'> Email field can not be empty</strong>";
            return false;
         }       
         if(empty($this->surname)){
            $this->message = "<strong style='color:red'> Your surname is important</strong>";
            return false;
         }
         if(empty($this->firstnames)){
           $this->message =  "<strong style='color:red'> You must fill in the firstname field</strong>";
            return false;
         }
        
         
         if(!empty($this->email)){
         	 $sqli ="select * from ".self::$table_name;
         	 $resi = $Database->add_query($sqli);
         	 if($Database->num_rows($resi) > 4){
         	 	$this->message =  "Application Closed";
         	 }else{        
         $sql ="select * from ".self::$table_name;
        $sql .=" where email = ";
        $sql .= "'".$this->email."'";
        $res = $Database->add_query($sql);
        if($Database->num_rows($res) > 0){
            $this->message = "The email address is already in use";
        }else{ // start of else 1 block
        $sql = "INSERT into ".self::$table_name."(first_name, surname,phone_number, email, cover_letter,passport, resume)";
        $sql .= "VALUES ('$this->firstnames','$this->surname', '$this->phonenumber','$this->email','$this->coverletter','$this->passport','$this->resume')";
        if($Database->add_query($sql)){       
		if (!file_exists("uploads/$this->email")) {
			mkdir("uploads/$this->email", 0755);
		}
                }
            return true;
        
        }// END OF ISERTION BLOCK
        
        }// end of else 1 block
		}
	}// End of registration function
	  
	public function authenticate($email,$pass,$location){
        global $Database;
        global $session;
        $email = strtolower($email);
        $pass = strtolower($pass);
        $sql ="select * from user";
        $sql .=" where email = ";
        $sql .= "'".$email."'";
        $res = $Database->add_query($sql);
        while($result = $Database->fetch_array($res)){
          $surname = $result['surname'];
            $mail = $result['email'];
            $pas = $result['password']; 
            $id = $result['user_id'];
         if(($email == $mail)) {  
       if(($result['activation'] == 0) && ($result['email_sent'] == 1)){
       $this->message = "Please Confirm your Email first, an activation link had been sent to your mail"; 
       return false;
       } 
     if(($result['activation'] == 0) && ($result['email_sent'] == 0)){  
          $this->send_confirmation_email($mail,$pas,$id,$surname);

      }  
  
    }       
        $pass = md5($pass);
        if(($email == $mail)&&($pass == $pas)) {
          $_SESSION['user_id'] =  $result['user_id'];
          $session->user_id = $_SESSION['user_id'];
          if($location != ''){
               $Database->redirect_to($location);              
               return true;
          }else {
            $Database->redirect_to($Database->address);
          }
        }else{
            $this->message = "Incorrect email or password";
            return false;
        }
        }
    }
	

	public function select_all(){
		global $Database;
	
	}
	
	
    public function fullname(){
        return $this->surname." ". $this->othernames;
    }
}

?>