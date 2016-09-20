<?php

namespace Finder\Fixtures;

use GuzzleHttp\Psr7\Response;

class TestResponse extends Response
{
    public function getBody()
    {
        return <<<HTML
<a href="/">homepage</a>
<a href=""></a>
<a href=" ">dummy</a>
<a href="javascript:void(0)"></a>
<a href="css/style.css"></a>
<a href="/services"></a>
<a href="/services"></a>
<a href="#services"></a>
<a href="mailto:test@example.com"></a>
<a href="/error-404"></a>
<a href="/error-500"></a>
<a href="http://localhost:8000/test"></a>
<a href="http://www.google.com"></a>
HTML;
    }
}
