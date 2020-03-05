<?php
class AUTH
{
    function checkAuthorization($auth)
    {
        $curl = curl_init();
        $curl = curl_init("http://localhost:8090/api/user/status");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $auth
            )
        );

        // EXECUTE:
        $status = "";
        $result = curl_exec($curl);
        if (!$result) {
            $status = "connection_error";
        } else {
            if ($result != "ok") {
                $status = "auth_error";
            } else {
                $status = "auth_ok";
            }
        }


        curl_close($curl);
        return $status;
    }
}