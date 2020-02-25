<?php
class API
{
   function callAPI($method, $url, $data, $auth)
   {
      $curl = curl_init();
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLINFO_HEADER_OUT, true);
      curl_setopt(
         $curl,
         CURLOPT_HTTPHEADER,
         array(
            'Content-Type: application/json',
            $auth,
            'Content-Length: ' . strlen($data)
         )
      );
      switch ($method) {
         case "POST":
            curl_setopt($curl, CURLOPT_POST, true);
            if ($data)
               curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
         case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
               curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
         case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
         default:
            if ($data)
               $url = sprintf("%s?%s", $url, http_build_query($data));
      }
      // EXECUTE:
      $result = curl_exec($curl);
      // if (!$result) {
      //    die("Connection Failure");
      // }
      curl_close($curl);
      return $result;
   }
}