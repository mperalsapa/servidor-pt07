<?php

function returnResponse($response, $statusCode): void
{
    http_response_code($statusCode);
    echo $response;
    die();
}
