<?php

namespace Finder\Fixtures;

use Guzzle\Http\Message\Response;

class ResponseTest extends Response
{
    public function getMessage()
    {
        return <<<HTML
<a href="/">homepage</a>
<a href=""></a>
<a href="javascript:void(0)"></a>
<a href="css/style.css"></a>
<a href="/services"></a>
<a href="#services"></a>
<a href="mailto:test@example.com"></a>
<a href="/error-404"></a>
<a href="http://localhost:8000/test"></a>
<a href="http://www.google.com"></a>
HTML;
    }
}