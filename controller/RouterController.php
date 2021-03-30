<?php


class RouterController extends Controller
{
    // Instance controller
    protected Controller $controller;

    // The method converts string controller to a class name
    public function slugify(string $text): string
    {
        return ucwords(str_replace(array('-', ' '), array(' ', ''), $text));
    }

    // Parse url and return array parameters
    public function parseUrl(string $url): array
    {
        // Parse part of url to associate array
        $parseUrl = parse_url($url);
        // Remove first /
        $parseUrl["path"] = ltrim($parseUrl["path"], "/");
        // Remove whitespace
        $parseUrl["path"] = trim($parseUrl["path"]);

        return explode("/", $parseUrl["path"]);
    }

    // Parse url and create controller
    function process(array $parameters)
    {
        $parseUrl = $this->parseUrl($parameters[0]);

        if (empty($parseUrl[0]))
            $this->redirect('home');

        // Controller is first parameter URL
        $controller = $this->slugify(array_shift($parseUrl)) . 'Controller';

        if (file_exists('controller/' . $controller . '.php'))
            $this->controller = new $controller;
        else
            $this->redirect('error');

        // Call controller
        $this->controller->process($parseUrl);

        // Create variable
        $this->data['title'] = $this->controller->head['title'];
        $this->data['messages'] = $this->returnMessage();


        // Set main template
        $this->view = 'master';
    }
}