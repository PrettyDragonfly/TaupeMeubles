<?php
	if(isset($_POST["item"]) && isset($_POST["pos"])){ 
		$arr1 = array();
		$trouve = false;
		if(isset($_COOKIE["panier"])){ 
			$arr = json_decode($_COOKIE["panier"],true);
			foreach($arr as $item){			
				if(($_POST["item"] == $item) && $trouve == false){ 
					$trouve = true;
				}else{
					//$arr1[] = $item;
					array_push($arr1,$item);
				}				
			}
		}
		setcookie('panier',json_encode($arr1),time() + (60*30),"/");
	}
?>