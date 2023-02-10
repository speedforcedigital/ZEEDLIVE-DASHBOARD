<?php
function makeCurlRequest($url, $method)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5zdGFnaW5nLnplZWRsaXZlLmNvbS9hcGkvdjEvbG9naW4iLCJpYXQiOjE2NzU4OTgyNzQsImV4cCI6MTY3NjUwMzA3NCwibmJmIjoxNjc1ODk4Mjc0LCJqdGkiOiJjSzdYdlhTUzhmV0FKSDdkIiwic3ViIjoiNTMiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.SFl-lqeuFtRlNxtW4r35b1MrFk6Lm_GPiBMrLR8-2r4"
  ),
    ]);
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response, true);
}

function makeCurlPostRequest($url, $method, $postData)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5zdGFnaW5nLnplZWRsaXZlLmNvbS9hcGkvdjEvbG9naW4iLCJpYXQiOjE2NzU4OTgyNzQsImV4cCI6MTY3NjUwMzA3NCwibmJmIjoxNjc1ODk4Mjc0LCJqdGkiOiJjSzdYdlhTUzhmV0FKSDdkIiwic3ViIjoiNTMiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.SFl-lqeuFtRlNxtW4r35b1MrFk6Lm_GPiBMrLR8-2r4"
        ],
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

function makeCurlFileRequest($url,$method,$postData)
{
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_POSTFIELDS =>$postData,
      CURLOPT_HTTPHEADER => [
        "Content-Type: multipart/form-data",
        "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5zdGFnaW5nLnplZWRsaXZlLmNvbS9hcGkvdjEvbG9naW4iLCJpYXQiOjE2NzU4OTgyNzQsImV4cCI6MTY3NjUwMzA3NCwibmJmIjoxNjc1ODk4Mjc0LCJqdGkiOiJjSzdYdlhTUzhmV0FKSDdkIiwic3ViIjoiNTMiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.SFl-lqeuFtRlNxtW4r35b1MrFk6Lm_GPiBMrLR8-2r4"
      ],
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

function baseUrl()
{
    return 'https://api.staging.zeedlive.com/api/v1/admin/';
}
?>