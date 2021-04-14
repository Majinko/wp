<?php


class HomeController extends Controller
{

    private CurlUtils $curlUtils;

    /**
     * HomeController constructor.
     * @param CurlUtils $curlUtils
     */
    public function __construct()
    {
        $this->curlUtils = new CurlUtils('GET', '/v1/user/self/zone/php-assignment-10.ws/record');;
    }

    public function process(array $parameters)
    {
        $this->head['title'] = 'Home';

        $this->view = 'home';

        $this->data['dns'] = json_decode($this->curlUtils->curlRequest(), true);
    }
}