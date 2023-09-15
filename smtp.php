<?php
/****************************************************
****   QCR Intranet Project                       ***
****   Designed by: Tom Moore                     ***
****   Written by: Tom Moore                      ***
****   (c) 2008 TEEMOR eBusiness Solutions        ***
****************************************************/
class smtp_class
{
	var $user="";
	var $realm="";
	var $password="";
	var $workstation="";
	var $token="";
	var $authentication_mechanism="";
	var $sasl_autoload=0;
	var $host_name="";
	var $host_port=25;
	var $socks_host_name = '';
	var $socks_host_port=1080;
	var $socks_version='5';
	var $http_proxy_host_name = '';
	var $http_proxy_host_port=80;
	var $user_agent='SMTP Class (http://www.phpclasses.org/smtpclass $Revision: 1.52 $)';
	var $ssl=0;
	var $start_tls = 0;
	var $localhost="";
	var $timeout=0;
	var $data_timeout=0;
	var $direct_delivery=0;
	var $error="";
	var $debug=0;
	var $html_debug=0;
	var $esmtp=1;
	var $esmtp_extensions=array();
	var $exclude_address="";
	var $getmxrr="GetMXRR";
	var $pop3_auth_host="";
	var $pop3_auth_port=110;

	/* private variables - DO NOT ACCESS */

	var $state="Disconnected";
	var $connection=0;
	var $pending_recipients=0;
	var $next_token="";
	var $direct_sender="";
	var $connected_domain="";
	var $result_code;
	var $disconnected_error=0;
	var $esmtp_host="";
	var $maximum_piped_recipients=100;

	/* Private methods - DO NOT CALL */

	Function Tokenize($string,$separator="")
	{
		if(!strcmp($separator,""))
		{
			$separator=$string;
			$string=$this->next_token;
		}
		for($character=0;$character<strlen($separator);$character++)
		{
			if(GetType($position=strpos($string,$separator[$character]))=="integer")
				$found=(IsSet($found) ? min($found,$position) : $position);
		}
		if(IsSet($found))
		{
			$this->next_token=substr($string,$found+1);
			return(substr($string,0,$found));
		}
		else
		{
			$this->next_token="";
			return($string);
		}
	}

	Function OutputDebug($message)
	{
		$message.="\n";
		if($this->html_debug)
			$message=str_replace("\n","<br />\n",HtmlEntities($message));
		echo $message;
		#flush();
	}

	Function SetDataAccessError($error)
	{
		$this->error=$error;
		if(function_exists("socket_get_status"))
		{
			$status=socket_get_status($this->connection);
			if($status["timed_out"])
				$this->error.=": data access time out";
			elseif($status["eof"])
			{
				$this->error.=": the server disconnected";
				$this->disconnected_error=1;
			}
		}
		return($this->error);
	}

	Function SetError($error)
	{
		return($this->error=$error);
	}

	Function GetLine()
	{
		for($line="";;)
		{
			if(feof($this->connection))
			{
				$this->error="reached the end of data while reading from the SMTP server conection";
				return("");
			}
			if(GetType($data=@fgets($this->connection,100))!="string"
			|| strlen($data)==0)
			{
				$this->SetDataAccessError("it was not possible to read line from the SMTP server");
				return("");
			}
			$line.=$data;
			$length=strlen($line);
			if($length>=2
			&& substr($line,$length-2,2)=="\r\n")
			{
				$line=substr($line,0,$length-2);
				if($this->debug)
					$this->OutputDebug("S $line");
				return($line);
			}
		}
	}

	Function PutLine($line)
	{
		if($this->debug)
			$this->OutputDebug("C $line");
		if(!@fputs($this->connection,"$line\r\n"))
		{
			$this->SetDataAccessError("it was not possible to send a line to the SMTP server");
			return(0);
		}
		return(1);
	}

	Function PutData(&$data)
	{
		if(strlen($data))
		{
			if($this->debug)
				$this->OutputDebug("C $data");
			if(!@fputs($this->connection,$data))
			{
				$this->SetDataAccessError("it was not possible to send data to the SMTP server");
				return(0);
			}
		}
		return(1);
	}

	Function VerifyResultLines($code,&$responses)
	{
		$responses=array();
		Unset($this->result_code);
		while(strlen($line=$this->GetLine($this->connection)))
		{
			if(IsSet($this->result_code))
			{
				if(strcmp($this->Tokenize($line," -"),$this->result_code))
				{
					$this->error=$line;
					return(0);
				}
			}
			else
			{
				$this->result_code=$this->Tokenize($line," -");
				if(GetType($code)=="array")
				{
					for($codes=0;$codes<count($code) && strcmp($this->result_code,$code[$codes]);$codes++);
					if($codes>=count($code))
					{
						$this->error=$line;
						return(0);
					}
				}
				else
				{
					if(strcmp($this->result_code,$code))
					{
						$this->error=$line;
						return(0);
					}
				}
			}
			$responses[]=$this->Tokenize("");
			if(!strcmp($this->result_code,$this->Tokenize($line," ")))
				return(1);
		}
		return(-1);
	}

	Function FlushRecipients()
	{
		if($this->pending_sender)
		{
			if($this->VerifyResultLines("250",$responses)<=0)
				return(0);
			$this->pending_sender=0;
		}
		for(;$this->pending_recipients;$this->pending_recipients--)
		{
			if($this->VerifyResultLines(array("250","251"),$responses)<=0)
				return(0);
		}
		return(1);
	}

	Function Resolve($domain, &$ip, $server_type)
	{
		if(preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$domain))
			$ip=$domain;
		else
		{
			if($this->debug)
				$this->OutputDebug('Resolving '.$server_type.' server domain "'.$domain.'"...');
			if(!strcmp($ip=@gethostbyname($domain),$domain))
				$ip="";
		}
		if(strlen($ip)==0
		|| (strlen($this->exclude_address)
		&& !strcmp(@gethostbyname($this->exclude_address),$ip)))
			return($this->SetError("could not resolve the host domain \"".$domain."\""));
		return('');
	}

	Function ConnectToHost($domain, $port, $resolve_message)
	{
		if($this->ssl)
		{
			$version=explode(".",function_exists("phpversion") ? phpversion() : "3.0.7");
			$php_version=intval($version[0])*1000000+intval($version[1])*1000+intval($version[2]);
			if($php_version<4003000)
				return("establishing SSL connections requires at least PHP version 4.3.0");
			if(!function_exists("extension_loaded")
			|| !extension_loaded("openssl"))
				return("establishing SSL connections requires the OpenSSL extension enabled");
		}
		if(strlen($this->Resolve($domain, $ip, 'SMTP')))
			return($this->error);
		if(strlen($this->socks_host_name))
		{
			switch($this->socks_version)
			{
				case '4':
					$version = 4;
					break;
				case '5':
					$version = 5;
					break;
				default:
					return('it was not specified a supported SOCKS protocol version');
					break;
			}
			$host_ip = $ip;
			$host_port = $port;
			if(strlen($this->error = $this->Resolve($this->socks_host_name, $ip, 'SOCKS')))
				return($this->error);
			if($this->ssl)
				$ip="ssl://".($socks_host = $this->socks_host_name);
			else
				$socks_host = $ip;
			if($this->debug)
				$this->OutputDebug("Connecting to SOCKS server \"".$socks_host."\" port ".$this->http_proxy_host_port."...");
			if(($this->connection=($this->timeout ? fsockopen($ip, $this->socks_host_port, $errno, $error, $this->timeout) : fsockopen($ip, $this->socks_host_port, $errno, $error))))
			{
				$timeout=($this->data_timeout ? $this->data_timeout : $this->timeout);
				if($timeout
				&& function_exists("socket_set_timeout"))
					socket_set_timeout($this->connection,$timeout,0);
				if(strlen($this->socks_host_name))
				{
					if($this->debug)
						$this->OutputDebug('Connected to the SOCKS server '.$this->socks_host_name);
					$send_error = 'it was not possible to send data to the SOCKS server';
					$receive_error = 'it was not possible to receive data from the SOCKS server';
					switch($version)
					{
						case 4:
							$command = 1;
							$user = '';
							if(!fputs($this->connection, chr($version).chr($command).pack('nN', $host_port, ip2long($host_ip)).$user.Chr(0)))
								$error = $this->SetDataAccessError($send_error);
							else
							{
								$response = fgets($this->connection, 9);
								if(strlen($response) != 8)
									$error = $this->SetDataAccessError($receive_error);
								else
								{
									$socks_errors = array(
										"\x5a"=>'',
										"\x5b"=>'request rejected',
										"\x5c"=>'request failed because client is not running identd (or not reachable from the server)',
										"\x5d"=>'request failed because client\'s identd could not confirm the user ID string in the request',
									);
									$error_code = $response[1];
									$error = (IsSet($socks_errors[$error_code]) ? $socks_errors[$error_code] : 'unknown');
									if(strlen($error))
										$error = 'SOCKS error: '.$error;
								}
							}
							break;
						case 5:
							if($this->debug)
								$this->OutputDebug('Negotiating the authentication method ...');
							$methods = 1;
							$method = 0;
							if(!fputs($this->connection, chr($version).chr($methods).chr($method)))
								$error = $this->SetDataAccessError($send_error);
							else
							{
								$response = fgets($this->connection, 3);
								if(strlen($response) != 2)
									$error = $this->SetDataAccessError($receive_error);
								elseif(Ord($response[1]) != $method)
									$error = 'the SOCKS server requires an authentication method that is not yet supported';
								else
								{
									if($this->debug)
										$this->OutputDebug('Connecting to SMTP server IP '.$host_ip.' port '.$host_port.'...');
									$command = 1;
									$address_type = 1;
									if(!fputs($this->connection, chr($version).chr($command)."\x00".chr($address_type).pack('Nn', ip2long($host_ip), $host_port)))
										$error = $this->SetDataAccessError($send_error);
									else
									{
										$response = fgets($this->connection, 11);
										if(strlen($response) != 10)
											$error = $this->SetDataAccessError($receive_error);
										else
										{
											$socks_errors = array(
												"\x00"=>'',
												"\x01"=>'general SOCKS server failure',
												"\x02"=>'connection not allowed by ruleset',
												"\x03"=>'Network unreachable',
												"\x04"=>'Host unreachable',
												"\x05"=>'Connection refused',
												"\x06"=>'TTL expired',
												"\x07"=>'Command not supported',
												"\x08"=>'Address type not supported'
											);
											$error_code = $response[1];
											$error = (IsSet($socks_errors[$error_code]) ? $socks_errors[$error_code] : 'unknown');
											if(strlen($error))
												$error = 'SOCKS error: '.$error;
										}
									}
								}
							}
							break;
						default:
							$error = 'support for SOCKS protocol version '.$this->socks_version.' is not yet implemented';
							break;
					}
					if(strlen($this->error = $error))
					{
						fclose($this->connection);
						return($error);
					}
				}
				return('');
			}
		}
		elseif(strlen($this->http_proxy_host_name))
		{
			if(strlen($error = $this->Resolve($this->http_proxy_host_name, $ip, 'SMTP')))
				return($error);
			if($this->ssl)
				$ip = 'ssl://'.($proxy_host = $this->http_proxy_host_name);
			else
				$proxy_host = $ip;
			if($this->debug)
				$this->OutputDebug("Connecting to HTTP proxy server \"".$ip."\" port ".$this->http_proxy_host_port."...");
			if(($this->connection=($this->timeout ? @fsockopen($ip, $this->http_proxy_host_port, $errno, $error, $this->timeout) : @fsockopen($ip, $this->http_proxy_host_port, $errno, $error))))
			{
				if($this->debug)
					$this->OutputDebug('Connected to HTTP proxy host "'.$this->http_proxy_host_name.'".');
				$timeout=($this->data_timeout ? $this->data_timeout : $this->timeout);
				if($timeout
				&& function_exists("socket_set_timeout"))
					socket_set_timeout($this->connection,$timeout,0);
				if($this->PutLine('CONNECT '.$domain.':'.$port.' HTTP/1.0')
				&& $this->PutLine('User-Agent: '.$this->user_agent)
				&& $this->PutLine(''))
				{
					if(GetType($response = $this->GetLine()) == 'string')
					{
						if(!preg_match('/^http\\/[0-9]+\\.[0-9]+[ \t]+([0-9]+)[ \t]*(.*)$/i', $response,$matches))
							return($this->SetError("3 it was received an unexpected HTTP response status"));
						$error = $matches[1];
						switch($error)
						{
							case '200':
								for(;;)
								{
									if(GetType($response = $this->GetLine()) != 'string')
										break;
									if(strlen($response) == 0)
										return('');
								}
								break;
							default:
								$this->error = 'the HTTP proxy returned error '.$error.' '.$matches[2];
								break;
						}
					}
				}
				if($this->debug)
					$this->OutputDebug("Disconnected.");
				fclose($this->connection);
				$this->connection = 0;
				return($this->error);
			}
		}
		else
		{
			if($this->ssl)
				$ip = 'ssl://'.($host = $domain);
			elseif($this->start_tls)
				$ip = $host = $domain;
			else
				$host = $ip;
			if($this->debug)
				$this->OutputDebug("Connecting to SMTP server \"".$host."\" port ".$port."...");
			if(($this->connection=($this->timeout ? @fsockopen($ip, $port, $errno, $error, $this->timeout) : @fsockopen($ip, $port, $errno, $error))))
				return("");
		}
		$error=($this->timeout ? strval($error) : "??");
		switch($error)
		{
			case "-3":
				return("-3 socket could not be created");
			case "-4":
				return("-4 dns lookup on hostname \"".$domain."\" failed");
			case "-5":
				return("-5 connection refused or timed out");
			case "-6":
				return("-6 fdopen() call failed");
			case "-7":
				return("-7 setvbuf() call failed");
		}
		return("could not connect to the host \"".$domain."\": ".$error);
	}

	Function SASLAuthenticate($mechanisms, $credentials, &$authenticated, &$mechanism)
	{
		$authenticated=0;
		if(!$this->sasl_autoload
		&& (!function_exists("class_exists")
		|| !class_exists("sasl_client_class")))
		{
			$this->error="it is not possible to authenticate using the specified mechanism because the SASL library class is not loaded";
			return(0);
		}
		$sasl=new sasl_client_class;
		$sasl->SetCredential("user",$credentials["user"]);
		$sasl->SetCredential("password",$credentials["password"]);
		if(IsSet($credentials["realm"]))
			$sasl->SetCredential("realm",$credentials["realm"]);
		if(IsSet($credentials["workstation"]))
			$sasl->SetCredential("workstation",$credentials["workstation"]);
		if(IsSet($credentials["mode"]))
			$sasl->SetCredential("mode",$credentials["mode"]);
		if(IsSet($credentials["token"]))
			$sasl->SetCredential("token",$credentials["token"]);
		do
		{
			$status=$sasl->Start($mechanisms,$message,$interactions);
		}
		while($status==SASL_INTERACT);
		switch($status)
		{
			case SASL_CONTINUE:
				break;
			case SASL_NOMECH:
				if(strlen($this->authentication_mechanism))
				{
					$this->error="authenticated mechanism ".$this->authentication_mechanism." may not be used: ".$sasl->error;
					return(0);
				}
				break;
			default:
				$this->error="Could not start the SASL authentication client: ".$sasl->error;
				return(0);
		}
		if(strlen($mechanism=$sasl->mechanism))
		{
			if($this->PutLine("AUTH ".$sasl->mechanism.(IsSet($message) ? " ".base64_encode($message) : ""))==0)
			{
				$this->error="Could not send the AUTH command";
				return(0);
			}
			if(!$this->VerifyResultLines(array("235","334"),$responses))
				return(0);
			switch($this->result_code)
			{
				case "235":
					$response="";
					$authenticated=1;
					break;
				case "334":
					$response=base64_decode($responses[0]);
					break;
				default:
					$this->error="Authentication error: ".$responses[0];
					return(0);
			}
			for(;!$authenticated;)
			{
				do
				{
					$status=$sasl->Step($response,$message,$interactions);
				}
				while($status==SASL_INTERACT);
				switch($status)
				{
					case SASL_CONTINUE:
						if($this->PutLine(base64_encode($message))==0)
						{
							$this->error="Could not send the authentication step message";
							return(0);
						}
						if(!$this->VerifyResultLines(array("235","334"),$responses))
							return(0);
						switch($this->result_code)
						{
							case "235":
								$response="";
								$authenticated=1;
								break;
							case "334":
								$response=base64_decode($responses[0]);
								break;
							default:
								$this->error="Authentication error: ".$responses[0];
								return(0);
						}
						break;
					default:
						$this->error="Could not process the SASL authentication step: ".$sasl->error;
						return(0);
				}
			}
		}
		return(1);
	}
	
	Function StartSMTP($localhost)
	{
		$success = 1;
		$this->esmtp_extensions = array();
		$fallback=1;
		if($this->esmtp
		|| strlen($this->user))
		{
			if($this->PutLine('EHLO '.$localhost))
			{
				if(($success_code=$this->VerifyResultLines('250',$responses))>0)
				{
					$this->esmtp_host=$this->Tokenize($responses[0]," ");
					for($response=1;$response<count($responses);$response++)
					{
						$extension=strtoupper($this->Tokenize($responses[$response]," "));
						$this->esmtp_extensions[$extension]=$this->Tokenize("");
					}
					$success=1;
					$fallback=0;
				}
				else
				{
					if($success_code==0)
					{
						$code=$this->Tokenize($this->error," -");
						switch($code)
						{
							case "421":
								$fallback=0;
								break;
						}
					}
				}
			}
			else
				$fallback=0;
		}
		if($fallback)
		{
			if($this->PutLine("HELO $localhost")
			&& $this->VerifyResultLines("250",$responses)>0)
				$success=1;
		}
		return($success);
	}

	/* Public methods */

	Function Connect($domain="")
	{
		if(strcmp($this->state,"Disconnected"))
		{
			$this->error="connection is already established";
			return(0);
		}
		$this->disconnected_error=0;
		$this->error=$error="";
		$this->esmtp_host="";
		$this->esmtp_extensions=array();
		$hosts=array();
		if($this->direct_delivery)
		{
			if(strlen($domain)==0)
				return(1);
			$hosts=$weights=$mxhosts=array();
			$getmxrr=$this->getmxrr;
			if(function_exists($getmxrr)
			&& $getmxrr($domain,$hosts,$weights))
			{
				for($host=0;$host<count($hosts);$host++)
					$mxhosts[$weights[$host]]=$hosts[$host];
				KSort($mxhosts);
				for(Reset($mxhosts),$host=0;$host<count($mxhosts);Next($mxhosts),$host++)
					$hosts[$host]=$mxhosts[Key($mxhosts)];
			}
			else
			{
				if(strcmp(@gethostbyname($domain),$domain)!=0)
					$hosts[]=$domain;
			}
		}
		else
		{
			if(strlen($this->host_name))
				$hosts[]=$this->host_name;
			if(strlen($this->pop3_auth_host))
			{
				$user=$this->user;
				if(strlen($user)==0)
				{
					$this->error="it was not specified the POP3 authentication user";
					return(0);
				}
				$password=$this->password;
				if(strlen($password)==0)
				{
					$this->error="it was not specified the POP3 authentication password";
					return(0);
				}
				$domain=$this->pop3_auth_host;
				$this->error=$this->ConnectToHost($domain, $this->pop3_auth_port, "Resolving POP3 authentication host \"".$domain."\"...");
				if(strlen($this->error))
					return(0);
				if(strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication server greeting was not found";
					return(0);
				}
				if(!$this->PutLine("USER ".$this->user)
				|| strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication user was not accepted: ".$this->Tokenize("\r\n");
					return(0);
				}
				if(!$this->PutLine("PASS ".$password)
				|| strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication password was not accepted: ".$this->Tokenize("\r\n");
					return(0);
				}
				fclose($this->connection);
				$this->connection=0;
			}
		}
		if(count($hosts)==0)
		{
			$this->error="could not determine the SMTP to connect";
			return(0);
		}
		for($host=0, $error="not connected";strlen($error) && $host<count($hosts);$host++)
		{
			$domain=$hosts[$host];
			$error=$this->ConnectToHost($domain, $this->host_port, "Resolving SMTP server domain \"$domain\"...");
		}
		if(strlen($error))
		{
			$this->error=$error;
			return(0);
		}
		$timeout=($this->data_timeout ? $this->data_timeout : $this->timeout);
		if($timeout
		&& function_exists("socket_set_timeout"))
			socket_set_timeout($this->connection,$timeout,0);
		if($this->debug)
			$this->OutputDebug("Connected to SMTP server \"".$domain."\".");
		if(!strcmp($localhost=$this->localhost,"")
		&& !strcmp($localhost=getenv("SERVER_NAME"),"")
		&& !strcmp($localhost=getenv("HOST"),""))
			$localhost="localhost";
		$success=0;
		if($this->VerifyResultLines("220",$responses)>0)
		{
			$success = $this->StartSMTP($localhost);
			if($this->start_tls)
			{
				if(!IsSet($this->esmtp_extensions["STARTTLS"]))
				{
					$this->error="server does not support starting TLS";
					$success=0;
				}
				elseif(!function_exists('stream_socket_enable_crypto'))
				{
					$this->error="this PHP installation or version does not support starting TLS";
					$success=0;
				}
				elseif($success = ($this->PutLine('STARTTLS')
				&& $this->VerifyResultLines('220',$responses)>0))
				{
					if($this->debug)
						$this->OutputDebug('Starting TLS cryptograpic protocol');

                    // Allow the best TLS version(s) we can
                    $crypto_method = STREAM_CRYPTO_METHOD_TLS_CLIENT;

                    // PHP 5.6.7 dropped inclusion of TLS 1.1 and 1.2 in STREAM_CRYPTO_METHOD_TLS_CLIENT
                    // so add them back in manually if we can
                    if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
                        $crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
                        $crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT;
                    }

					if(!($success = @stream_socket_enable_crypto($this->connection, 1, $crypto_method)))
						$this->error = 'could not start TLS connection encryption protocol';
					else
					{
						if($this->debug)
							$this->OutputDebug('TLS started');
						$success = $this->StartSMTP($localhost);
					}
				}
			}
			if($success
			&& strlen($this->user)
			&& strlen($this->pop3_auth_host)==0)
			{
				if(!IsSet($this->esmtp_extensions["AUTH"]))
				{
					$this->error="server does not require authentication";
					if(IsSet($this->esmtp_extensions["STARTTLS"]))
						$this->error .= ', it probably requires starting TLS';
					$success=0;
				}
				else
				{
					if(strlen($this->authentication_mechanism))
						$mechanisms=array($this->authentication_mechanism);
					else
					{
						$mechanisms=array();
						for($authentication=$this->Tokenize($this->esmtp_extensions["AUTH"]," ");strlen($authentication);$authentication=$this->Tokenize(" "))
							$mechanisms[]=$authentication;
					}
					$credentials=array(
						"user"=>$this->user,
						"password"=>$this->password,
					);
					if(strlen($this->realm))
						$credentials["realm"]=$this->realm;
					if(strlen($this->workstation))
						$credentials["workstation"]=$this->workstation;
					if(strlen($this->token))
						$credentials["token"]=$this->token;
					$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
					if(!$success
					&& !strcmp($mechanism,"PLAIN"))
					{
						/*
						 * Author:  Russell Robinson, 25 May 2003, http://www.tectite.com/
						 * Purpose: Try various AUTH PLAIN authentication methods.
						 */
						$mechanisms=array("PLAIN");
						$credentials=array(
							"user"=>$this->user,
							"password"=>$this->password
						);
						if(strlen($this->realm))
						{
							/*
							 * According to: http://www.sendmail.org/~ca/email/authrealms.html#authpwcheck_method
							 * some sendmails won't accept the realm, so try again without it
							 */
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
						if(!$success)
						{
							/*
							 * It was seen an EXIM configuration like this:
							 * user^password^unused
							 */
							$credentials["mode"]=SASL_PLAIN_EXIM_DOCUMENTATION_MODE;
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
						if(!$success)
						{
							/*
							 * ... though: http://exim.work.de/exim-html-3.20/doc/html/spec_36.html
							 * specifies: ^user^password
							 */
							$credentials["mode"]=SASL_PLAIN_EXIM_MODE;
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
					}
					if($success
					&& strlen($mechanism)==0)
					{
						$this->error="it is not supported any of the authentication mechanisms required by the server";
						$success=0;
					}
				}
			}
		}
		if($success)
		{
			$this->state="Connected";
			$this->connected_domain=$domain;
		}
		else
		{
			fclose($this->connection);
			$this->connection=0;
		}
		return($success);
	}

	Function MailFrom($sender)
	{
		if($this->direct_delivery)
		{
			switch($this->state)
			{
				case "Disconnected":
					$this->direct_sender=$sender;
					return(1);
				case "Connected":
					$sender=$this->direct_sender;
					break;
				default:
					$this->error="direct delivery connection is already established and sender is already set";
					return(0);
			}
		}
		else
		{
			if(strcmp($this->state,"Connected"))
			{
				$this->error="connection is not in the initial state";
				return(0);
			}
		}
		$this->error="";
		if(!$this->PutLine("MAIL FROM:<$sender>"))
			return(0);
		if(!IsSet($this->esmtp_extensions["PIPELINING"])
		&& $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="SenderSet";
		if(IsSet($this->esmtp_extensions["PIPELINING"]))
			$this->pending_sender=1;
		$this->pending_recipients=0;
		return(1);
	}
	
	Function SetRecipient($recipient)
	{
		if($this->direct_delivery)
		{
			if(GetType($at=strrpos($recipient,"@"))!="integer")
				return("it was not specified a valid direct recipient");
			$domain=substr($recipient,$at+1);
			switch($this->state)
			{
				case "Disconnected":
					if(!$this->Connect($domain))
						return(0);
					if(!$this->MailFrom(""))
					{
						$error=$this->error;
						$this->Disconnect();
						$this->error=$error;
						return(0);
					}
					break;
				case "SenderSet":
				case "RecipientSet":
					if(strcmp($this->connected_domain,$domain))
					{
						$this->error="it is not possible to deliver directly to recipients of different domains";
						return(0);
					}
					break;
				default:
					$this->error="connection is already established and the recipient is already set";
					return(0);
			}
		}
		else
		{
			switch($this->state)
			{
				case "SenderSet":
				case "RecipientSet":
					break;
				default:
					$this->error="connection is not in the recipient setting state";
					return(0);
			}
		}
		$this->error="";
		if(!$this->PutLine("RCPT TO:<$recipient>"))
			return(0);
		if(IsSet($this->esmtp_extensions["PIPELINING"]))
		{
			$this->pending_recipients++;
			if($this->pending_recipients>=$this->maximum_piped_recipients)
			{
				if(!$this->FlushRecipients())
					return(0);
			}
		}
		else
		{
			if($this->VerifyResultLines(array("250","251"),$responses)<=0)
				return(0);
		}
		$this->state="RecipientSet";
		return(1);
	}
	
	Function StartData()
	{
		if(strcmp($this->state,"RecipientSet"))
		{
			$this->error="connection is not in the start sending data state";
			return(0);
		}
		$this->error="";
		if(!$this->PutLine("DATA"))
			return(0);
		if($this->pending_recipients)
		{
			if(!$this->FlushRecipients())
				return(0);
		}
		if($this->VerifyResultLines("354",$responses)<=0)
			return(0);
		$this->state="SendingData";
		return(1);
	}
	
	Function PrepareData($data)
	{
		return(preg_replace(array("/\n\n|\r\r/","/(^|[^\r])\n/","/\r([^\n]|\$)/D","/(^|\n)\\./"),array("\r\n\r\n","\\1\r\n","\r\n\\1","\\1.."),$data));
	}
	
	Function SendData($data)
	{
		if(strcmp($this->state,"SendingData"))
		{
			$this->error="connection is not in the sending data state";
			return(0);
		}
		$this->error="";
		return($this->PutData($data));
	}
	
	Function EndSendingData()
	{
		if(strcmp($this->state,"SendingData"))
		{
			$this->error="connection is not in the sending data state";
			return(0);
		}
		$this->error="";
		if(!$this->PutLine("\r\n.")
		|| $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="Connected";
		return(1);
	}
	
	Function ResetConnection()
	{
		switch($this->state)
		{
			case "Connected":
				return(1);
			case "SendingData":
				$this->error="can not reset the connection while sending data";
				return(0);
			case "Disconnected":
				$this->error="can not reset the connection before it is established";
				return(0);
		}
		$this->error="";
		if(!$this->PutLine("RSET")
		|| $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="Connected";
		return(1);
	}
	
	Function Disconnect($quit=1)
	{
		if(!strcmp($this->state,"Disconnected"))
		{
			$this->error="it was not previously established a SMTP connection";
			return(0);
		}
		$this->error="";
		if(!strcmp($this->state,"Connected")
		&& $quit
		&& (!$this->PutLine("QUIT")
		|| ($this->VerifyResultLines("221",$responses)<=0
		&& !$this->disconnected_error)))
			return(0);
		if($this->disconnected_error)
			$this->disconnected_error=0;
		else
			fclose($this->connection);
		$this->connection=0;
		$this->state="Disconnected";
		if($this->debug)
			$this->OutputDebug("Disconnected.");
		return(1);
	}
	
	Function SendMessage($sender,$recipients,$headers,$body)
	{
		if(($success=$this->Connect()))
		{
			if(($success=$this->MailFrom($sender)))
			{
				for($recipient=0;$recipient<count($recipients);$recipient++)
				{
					if(!($success=$this->SetRecipient($recipients[$recipient])))
						break;
				}
				if($success
				&& ($success=$this->StartData()))
				{
					for($header_data="",$header=0;$header<count($headers);$header++)
						$header_data.=$headers[$header]."\r\n";
					$success=($this->SendData($header_data."\r\n")
						&& $this->SendData($this->PrepareData($body))
						&& $this->EndSendingData());
				}
			}
			$error=$this->error;
			$disconnect_success=$this->Disconnect($success);
			if($success)
				$success=$disconnect_success;
			else
				$this->error=$error;
		}
		return($success);
	}
};