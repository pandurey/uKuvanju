<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if(!function_exists('checkFlashdata'))
	{
  		function checkFlashdata($value)
  		{	
  			$ci =& get_instance();
   			if(!empty($ci->session->flashdata($value)))
   			{
   				return $ci->session->flashdata($value);
   			}
   			else
   			{
   				return "";
   			}
  		}
  }

  if(!function_exists('logged'))
  {
      function logged()
      { 
        $ci =& get_instance();
        
        if($ci->session->has_userdata('logged-in'))
        {
          return $ci->session->userdata('logged-in');
          //return TRUE;
        }
        else
        {
          return FALSE;
        }
      }
  }

