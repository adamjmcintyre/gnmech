<?php
	function net_match($network, $ip) {
        	// determines if a network in the form of 192.168.17.1/16 or
		// 127.0.0.1/255.255.255.255 or 10.0.0.1 matches a given ip
		$ip_arr = explode('/', $network);
		$network_long = ip2long($ip_arr[0]);

		$x = ip2long($ip_arr[1]);
		$mask =  long2ip($x) == $ip_arr[1] ? $x : 0xffffffff << (32 - $ip_arr[1]);
		$ip_long = ip2long($ip);

		// echo ">".$ip_arr[1]."> ".decbin($mask)."\n";
		return ($ip_long & $mask) == ($network_long & $mask);
	}
        if(net_match("10.107.0.0/255.255.0.0",$_SERVER['REMOTE_ADDR']) ||
        	net_match("10.109.53.0/255.255.255.0",$_SERVER['REMOTE_ADDR']) ||
		net_match("10.109.58.0/255.255.255.0",$_SERVER['REMOTE_ADDR']) ||
		net_match("10.109.61.0/255.255.255.0",$_SERVER['REMOTE_ADDR']) ||
		net_match("10.109.63.0/255.255.255.0",$_SERVER['REMOTE_ADDR']) ||
		net_match("10.108.8.0/255.255.255.0",$_SERVER['REMOTE_ADDR'])
	): ?>1<?php else:?>0<? endif; ?>

