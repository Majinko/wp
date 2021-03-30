<?php


class CurlUtils
{
    private string $path;
    private array $data;
    private string $method;

    public function __construct(string $method, string $path)
    {
        $this->path = $path;
        $this->method = $method;
    }

    public function curlRequest()
    {
        $time = time();
        $canonicalRequest = sprintf('%s %s %s', $this->method, $this->path, $time);
        $signature = hash_hmac('sha1', $canonicalRequest, Constants::getSecret());

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('%s%s%s', Constants::getApi(), $this->path, ''));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, Constants::getApiKey() . ':' . $signature);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Date: ' . gmdate('Ymd\THis\Z', $time),
        ]);

        if ($this->method === 'POST'){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->data));
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}