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
<a href="/contact"></a>
<a href="http://www.google.com"></a>
HTML;
    }

}