<?php
include 'db.php';//connection file
//call this function to send_notification pass title, source and date as argument.
function send_notification($title,$source,$date)
{
            $token =  array();
            //get fcm_token list from stored in your database
                $query1="SELECT fcm_token FROM user_token where 1";
                $result= mysqli_query($con,$query1);
        
                while($row = mysqli_fetch_assoc($result)){

                    // add each row returned into an array
                    echo $row['fcm_token'];
                    array_push($token,$row['fcm_token']);
                    
                    }

	
//This key is Your API access key from firebase Server
 define('API_ACCESS_KEY','sefsefsef:APA91bES5A5Grn0JDxI9LsZtxm5zeNX5BfFhNvmDFWjEdjFFSncon1MsdfvrFlRn-5YxBBQ59Ejl_hdW-LDL6vVqaIvFxWJTisaef-qoDyGFmTDPnL_On0V-AsPv3_gkwmhtRx29jhpbS');
 
//prepare the bundle
foreach($token as $temp){
	//This is Creating Message to be send in bundle
     $msg = array
          (
		'body' 	=> $source,  
		'title'	=> $title,
		'click_action' => '/news',
             	
          );
     //tokan of the reciver in temp variable and message generated from the above method.
	$fields = array
			(
				'to'		=> $temp,
				'notification'	=> $msg,
			);
	//Provide headers with API key obtained for firebase Server
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
//Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		echo $result;
		curl_close( $ch );
}
}
?>