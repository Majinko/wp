<?php


class HomeController extends Controller
{
    public function process(array $parameters)
    {
        $curlUtils = new CurlUtils('GET', '/v1/user/self/zone/php-assignment-10.ws/record');

        $this->head['title'] = 'Home';

        $this->view = 'home';

        $this->data['dns'] = json_decode($curlUtils->curlRequest(), true);
    }
}