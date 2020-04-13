<?php
	// Set up the cURL request object.
	$domain = 'example.com';
	$subdomain = 'test';
	$CpanelUserName = 'cpanelUserName';
	$CpanelPassword = 'CpanelPassword';
	$CpanelURL = 'HostingProviderURL.com'; //The ip address of the server can also be used here
	
	
	//Nothing below should need changing - asside from the ttl value if you want to reduce these
	$fullSubURL = $subdomain.'.'.$domain;
	$urlBuilder = 'https://'.$CpanelURL.':2083/json-api/cpanel?cpanel_jsonapi_user=user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=ZoneEdit&cpanel_jsonapi_func=fetchzone_records&domain='.$domain.'&customonly=0&ttl=14400&type=A&name='.$fullSubURL.'.';
	//Cpanel Stores the full subdomain with a trailing period 
	//(eg user accessing "test.domain.com" is stored as "test.domain.com." )


	$ch = curl_init($urlBuilder);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $CpanelUserName.':'.$CpanelPassword);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	if (null !== $payload) {
		// Set up a POST request with the payload.
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	}

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Make the call, and then terminate the cURL caller object.
	$curl_response = curl_exec($ch);
	$parsedResponse = json_decode($curl_response);
	curl_close($ch);

	//If you want to see the full response from the server for this subdomain uncomment the following three lines
	//echo 'Original Response:<br>'.$curl_response.'<p><p><p>'; //DEBUG
	//var_dump($parsedResponse->cpanelresult->data[0]);//DEBUG
	//echo '<p>';
	
	//Check that we have been given a correct subdomain
	if($parsedResponse->cpanelresult->data[0]->name == $fullSubURL.'.')
	{
		$usersIP = $_SERVER['REMOTE_ADDR'];
		$Line = $parsedResponse->cpanelresult->data[0]->line;
		if($parsedResponse->cpanelresult->data[0]->address == $usersIP)
		{
			echo "Addresses match - do nothing";
		}
		else
		{
			$urlBuilder = 'https://'.$CpanelURL.':2083/json-api/cpanel?cpanel_jsonapi_user=user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=ZoneEdit&cpanel_jsonapi_func=edit_zone_record&Line='.$Line.'&domain='.$domain.'&name='.$subdomain.'&type=A&address='.$usersIP.'&ttl=14400';
			$ch = curl_init($urlBuilder);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $CpanelUserName.':'.$CpanelPassword);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			if (null !== $payload) {
				// Set up a POST request with the payload.
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			}

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// Make the call, and then terminate the cURL caller object.
			$curl_response = curl_exec($ch);
			echo $curl_response;
		}
	}
	else
	{
		echo "The Subdomain does not exist";
	}
?>
