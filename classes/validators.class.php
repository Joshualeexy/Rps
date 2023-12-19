<?php 
Class Validator{
public $email;
public $text;
public $password;
public $email_err;
public $text_err;
public $password_err;
public $date_err;
public $num;
public $num_err;


    function validateEmail($email)
    {
        $email = htmlspecialchars($email);

        if (empty($email)) {
            $this->email_err = 'Please fill in the email field correctly';
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            } else {
                $this->email_err = 'Please enter a valid email address';
            }
        }
    } 
    
    function validateText($text)
    {
        $text = htmlspecialchars($text);
        $text = stripslashes($text);

        if (empty($text)) {
            $this->text_err = 'Please fill in this field correctly';
        } else {
          return $text;

        }
    }


    function Validateint($num){
        $num = htmlspecialchars($num);
        if(empty($num)){
            $this->num_err = 'Please fill in this fields correctly';
        }
        else{
            if(!filter_var($num,  FILTER_VALIDATE_INT)){
                $this->num_err = 'please input a valid number';
            }else{
                return $num;
            }
        }
return $num;
    }

}
