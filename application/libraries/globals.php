<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Globals
{
	function base_url()
	{
		 return base_url() . ((trim(index_page()) == "") ? index_page()  : index_page() . "/");	
	}
	
	 public function base_document()
    {
        return str_replace("//", "/", $this->document_root() . "/");
    }
	
	public function right_document()
	{
		return dirname(dirname(__FILE__));
	}
	
	public function root()
	{
		return dirname(dirname(dirname(__FILE__)))."/";
	}
	
	 public function document_root()
    {
        $document_root = $_SERVER["DOCUMENT_ROOT"];
        if ( substr($document_root, strlen($document_root) - 1, strlen($document_root)) != "/" ) {
            $document_root .= "/";
        }
        
		
        return $document_root;
    }
	
	
	function javascript()
	{
		$javascript  = '';
			
			$javascript .= '<script src="'.$this->base_url().'../js/jquery.1.9.js"></script>';
			$javascript .= '<script src="'.$this->base_url().'../js/flexigrid.js"></script>';
			$javascript .= '<script src="'.$this->base_url().'../js/fancybox/jquery.fancybox-1.3.4.js"></script>';
			$javascript .= '<script src="'.$this->base_url().'../js/ui/jquery.ui.core.js"></script>';
            $javascript .= '<script src="'.$this->base_url().'../js/ui/jquery.ui.widget.js"></script>';
            $javascript .= '<script src="'.$this->base_url().'../js/ui/jquery.ui.tabs.js"></script>';
			  $javascript .= '<script src="'.$this->base_url().'../js/ui/jquery.ui.tabs.js"></script>';
			$javascript .= '<script src="'.$this->base_url().'../js/block.js"></script>';
			$javascript .= '<script src="'.$this->base_url().'../js/ui/jquery.ui.datepicker.js"></script>';	
			//$javascript .= '<script src="'.$this->base_url().'../js/ui/jquery.ui.tooltip.js">';	
		return $javascript;
	}
	
	function login()
	{
		$css  = '';
			
			$css .= '<link rel="stylesheet"  href="'.$this->base_url().' ../../../css/login.css" type="text/css" media="screen" >';
			
		return $css;
	}
	
	function css()
	{
		$css  = '';
			
			$css .= '<link rel="stylesheet"  href="'.$this->base_url().' ../../../css/main.css" type="text/css" media="screen" >';
			$css .= '<link rel="stylesheet"  href="'.$this->base_url().' ../../../css/styles.css" type="text/css" media="screen" >';
			$css .= '<link rel="stylesheet"  href="'.$this->base_url().' ../../../css/flexigrid.css" type="text/css" media="screen" >';
			$css .= '<link rel="stylesheet"  href="'.$this->base_url().' ../../../js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" >';
			$css .= '<link rel="stylesheet"  href="'.$this->base_url().' ../../../css/base/jquery.ui.all.css" type="text/css" media="screen" >';
			
			
		return $css;
	}
	
	function menu($current,$role)
	{
		
		$role = explode(",",$role);
		if(count($role) > 1  || ($role[0] != 'ADMIN' && $role[0] != 'HEADADMIN') )
		{
			$list = array(
				'AGENT'=>array(
					'LEADS'=>'agent/index',	
					'STATUS'=>'agent/status',
					'DL Request'=>'agent/dlrequest'				
				),
				'OJT'=>array(
					'LEADS'=>'ojt/index'
				),
				'FIELD'=>array(
					'LEADS'=>'fields/index'
				),
				'TL'=>array(
					'Report'=>'tl/index'
				),
			);
		
			$menu = "";
			$menu .= '<div id="cssmenu"><ul>';
			
			foreach($role as $index => $value)
			{
				if(strtoupper($current) == $value){
					$menu .= "<li class='active'><span><a href='javascript:void()'>".$value."</a></span>";
					$menu .= "<ul>";
						foreach($list[$value] as $in => $val)
						{
						$menu .= "<li><span>".anchor($val,$in)."</span></li>";
						}
					$menu .= "</ul>";
					$menu .="</li>";
				}else
				{
					$menu .= "<li><span>".anchor("",$value)."</span>";
					$menu .= "<ul>";
						foreach($list[$value] as $in => $val)
						{
						$menu .= "<li><span>".anchor($val,$in)."</span></li>";
						}
					$menu .= "</ul>";
					$menu .="</li>";	
				}
			}


			/*	foreach($list as $index => $value)
				{

					if(array_key_exists(strtoupper($current),$list))
					{if(strtoupper($current) == $index)
						{
						if(strtoupper($current) == $index)
						{
							$menu .= "<li class='active'><span>".anchor($value,$index)."</span>";
									$menu .= "<ul>";
									foreach($value as $in => $val)
									{
											$menu .= "<li><span>".anchor($val,$in)."</span></li>";
									}
									$menu .= "</ul>";
							$menu .="</li>";
						}else
						{
							$menu .= "<li><span>".anchor($value,$index)."</span>";
									$menu .= "<ul>";
									foreach($value as $in => $val)
									{
											$menu .= "<li><span>".anchor($val,$in)."</span></li>";
									}
									$menu .= "</ul>";
							$menu .="</li>";
						}
					}
					}
				}*/
			$menu .= '</ul></div>';	
			return $menu;
		}else if($role[0] == 'HEADADMIN')
		{
			$list = array('Add Ons'=>'add/index');
			$menu = '';
			$menu .= '<div id="cssmenu"><ul>';
				foreach($list as $index => $value)
				{
					$check = explode("/",$value);
					if($check[0] == $current){
						$menu .= "<li class='active'><span>".anchor($value,$index)."</span></li>";
					}else{
						$menu .= "<li><span>".anchor($value,$index)."</span></li>";
					}
				}
			$menu .= '</ul></div>';
			return $menu;
		}
		else
		{
			$list = array('Accounts'=>'admin/index','Leads'=>'leads/index');
		$menu = '';
		$menu .= '<div id="cssmenu"><ul>';
			foreach($list as $index => $value)
			{
				$check = explode("/",$value);
				if($check[0] == $current){
					$menu .= "<li class='active'><span>".anchor($value,$index)."</span></li>";
				}else{
					$menu .= "<li><span>".anchor($value,$index)."</span></li>";
				}
			}
		$menu .= '</ul></div>';
		return $menu;
		}
	}
	
	function is_admin($logged,$user_id,$role)
	{
		if($logged)
		{
			if($role != 'ADMIN')
			{
				redirect('error/index');
			}
		}else
		{
			redirect('welcome/index');
		}
	}
	
	function is_head($logged,$user_id,$role)
	{
		if($logged)
		{
			if($role != 'HEADADMIN')
			{
				redirect('error/index');
			}
		}else
		{
			redirect('welcome/index');
		}
	}
	
	
	function is_other($logged,$user_id,$role,$current)
	{
		if($logged)
		{
			$exp = array();
			$role = explode(",",$role);
			foreach($role as $rol)
			{
				$exp[$rol] = $rol;
			}
		
			if(!array_key_exists(strtoupper($current),$exp))
			{
				redirect('error/index');
			}
		}else
		{
			redirect('welcome/index');
		}
	}
	
}