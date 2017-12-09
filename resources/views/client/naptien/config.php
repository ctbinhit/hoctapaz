<?php	
	
	header("Content-Type: text/html; charset=utf-8");	
	define('NGANLUONG_URL_CARD_POST', 'https://www.nganluong.vn/mobile_card.api.post.v2.php');
	define('NGANLUONG_URL_CARD_SOAP', 'https://nganluong.vn/mobile_card_api.php?wsdl');		
	class Config
	{
		  public static $_FUNCTION = "CardCharge";
		  public static $_VERSION = "2.0";
		  //Thay đổi 3 thông tin ở phía dưới
		  public static $_MERCHANT_ID = "52212";
		  public static $_MERCHANT_PASSWORD = "87401582b44581b8db7adfe294a5a530";
		  public static $_EMAIL_RECEIVE_MONEY = "phamtam.toannang@gmail.com";
	}
	
?>


	