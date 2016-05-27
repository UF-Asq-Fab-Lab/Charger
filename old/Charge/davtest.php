#!/usr/bin/php
<?php
 //  include __DIR__."/SabreDAV/vendor/autoload.php";
 //  // $settings = array(
 //  //     'baseUri' => 'https://webdav.erp.ufl.edu/prod/Outbound/DCP/UFS/',
 //  //     'userName' => 'wdtest',
 //  //     'password' => 'pwd1101'
 //  // );
 //  $settings = array(
 //    'baseUri' => 'https://webdav.erp.ufl.edu/prod/Outbound/DCP/UFS/',
 //    'userName' => 'thomasrstorey',
 //    'password' => 'V!Dn%WNGM9PE'
 //  );
 //
 //  $client = new Sabre\DAV\Client($settings);
 //
 //  // Will do a GET request on the base uri
 //  // $response = $client->request('PUT', "testfile3.txt", 'Test content.');
 //  // foreach ($response as $key => $value) {
 //  //   print_r($value);
 //  // }
 //
 // $response = $client->request('GET');
 // foreach ($response as $key => $value) {
 //   print_r($value);
 //   echo "\n";
 // }

function curl_get($url) {
    // $header = array('Content-type: text/plain', 'Content-length: 100') ;
    $ch = curl_init();
    $options = array(
        CURLOPT_HEADER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERPWD => 'thomasrstorey:V!Dn%WNGM9PE',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPAUTH => CURLAUTH_NTLM,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13'
    );
    curl_setopt_array($ch, $options);
    $return = curl_exec($ch);
    curl_close($ch);

    return $return;
}


echo curl_get('https://webdav.erp.ufl.edu/');

  // echo date("n");

?>
