<?php

abstract class Controller
{
    // An array whose indexes are then visible in the template as regular variables
    protected array $data = [];
    // Head html template
    protected array $head = ['title' => ""];
    // Name view
    protected string $view = "";

    // Render view
    public function renderTemplate()
    {
        if ($this->view) {
            extract($this->validate($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("view/" . $this->view . ".phtml");
        }
    }

    // validate it
    protected function validate($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->validate($v);
            }
            return $x;
        }
        else
            return $x;
    }

    // Message for user
    public function addMessage(string $message)
    {
        if (isset($_SESSION['message']))
            $_SESSION['message'][] = $message;
        else
            $_SESSION['message'] = array($message);
    }

    // Return message
    public function returnMessage(): array
    {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            return $message;
        } else
            return array();
    }

    // Redirect to url
    public function redirect(string $url)
    {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    // Main method controller
    abstract function process(array $parameters);
}