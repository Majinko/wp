<?php


class DnsController extends Controller
{
    private array $dnsTypes = [
        'A' => 'A record',
        'AAAA' => 'AAAA record',
        'MX' => 'MX record',
        'ANAME' => 'ANAME record',
        'CNAME' => 'CNAME record',
        'NS' => 'NS record',
        'TXT' => 'TXT record',
        'SRV' => 'SRV record',
    ];

    public function process(array $parameters)
    {
        if ($parameters[0] && $parameters[0] === 'create') {
            $this->createDns();
        }

        if ($parameters[0] && $parameters[0] === 'destroy') {
            $this->destroyDns($parameters[1]);
        }

        if ($parameters[0] && $parameters[0] === 'store') {
            $this->store();
        }
    }


    private function createDns()
    {
        $this->head['title'] = 'Pridať nový dns záznam';
        $this->data['types'] = $this->dnsTypes;
        $this->data['dns'] = [];
        $this->view = 'dns-create';
    }

    private function destroyDns(int $idRecord)
    {
        $curlUtils = new CurlUtils('DELETE', '/v1/user/self/zone/php-assignment-10.ws/record/' . $idRecord);
        $curlUtils->curlRequest();

        $this->addMessage('Dns record was destroy');
        $this->redirect('home');
    }

    private function store()
    {
        $dns = [];

        foreach ($_POST as $key => $value) {
            $dns[$key] = filter_var($value, FILTER_SANITIZE_STRING);
        }

        $curlUtils = new CurlUtils('POST', '/v1/user/self/zone/php-assignment-10.ws/record');

        $curlUtils->setData($dns);
        $response = json_decode($curlUtils->curlRequest());

        // errors
        if ($response->status === 'error') {
            $errors = $response->errors;

            if (isset($errors) && isset($errors->content)) {
                foreach ($errors->content as $error) {
                    $this->addMessage($error);
                }
            }

            if (isset($errors) && isset($errors->name)) {
                foreach ($errors->name as $error) {
                    $this->addMessage($error);
                }
            }

            $this->data['dns'] = $dns;
            $this->data['types'] = $this->dnsTypes;
            $this->view = 'dns-create';
        } else {
            $this->addMessage('Dns was store :)');
            $this->redirect('home');
        }
    }
}