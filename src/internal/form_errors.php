<?php

function returnResponse($response, $statusCode)
{
    http_response_code($statusCode);
    echo $response;
    die();
}
