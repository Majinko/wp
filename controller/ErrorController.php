<?php

class ErrorController extends Controller{
    function process(array $parameters)
    {
        $this->head['title'] = 'Error 404';

        $this->view = 'error';
    }
}
