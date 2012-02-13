<?php
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.IOException;
import java.io.OutputStreamWriter;

function make_request($url_str, $param_arr) {
        $data;
		$params = http_build_query($param_arr);
				
        try {
            $url = new URL($url_str);
            $connection = $url->openConnection();
            $connection->setDoOutput(true);
            $connection->setRequestMethod("POST");
			
            $writer = new OutputStreamWriter($connection->getOutputStream());
            $writer->write($params);
            $writer->flush();
            $line;
            $reader = new BufferedReader(new InputStreamReader($connection->getInputStream()));
            while (($line = $reader->readLine()) != null) {
                $data .= $line . "\n";
            }
            $reader->close();
			$writer->close();
			
        } catch (Exception $e) {
            // ...
        }
		return $data;
}

?>