<?php

function getFirstUrlFromGoogle($title)
{
    $url = "http://www.google.com/search?q=" . rawurlencode($title);
    echo $url;
    $html = $this->geturl($url);
    $urls = $this->match_all('/<a href="(http[s]*:\/\/[^"]*)".*?>.*?<\/a>/ms', $html, 1);

    if (!isset($urls[0])) {
        return false;
    } else {
        return $urls[0]; //return first result
    }
}

function geturl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1");
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

function match_all($regex, $str, $i = 0)
{
    if (preg_match_all($regex, $str, $matches) === false) {
        return false;
    } else {
        return $matches[$i];
    }
}
