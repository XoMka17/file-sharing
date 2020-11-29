<?php

class BlockChain
{
    private $serverUrl;

    /**
     * BlockChain constructor.
     *
     */
    public function __construct()
    {
        $this->serverUrl = 'http://192.168.10.1';
    }

    public function addFile($file_name, $file_content, $signature, $user_id)
    {
        $this->addBlock($file_name, $file_content, $signature, $user_id);
    }

    /**
     * @param $data
     */
    public function addBlock($file_name, $data, $signature, $user_id)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->serverUrl . '/mineBlock');
        curl_setopt($curl, CURLOPT_PORT, 3001);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '{"data" : "' . $data . '", "fileName" : "' . $file_name . '", "signature" : "' . $signature . '", "user" : "' . $user_id . '"}');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }
        curl_close($curl);
    }

    /**
     * @param $id
     * @return array
     */
    public function getFile($id)
    {
        $file_content = '';
        $file_name = '';
        $blocks = $this->getBlocks();

        if ($blocks) {
            $file_name = $blocks[$id]->fileName;
            $file_content = $blocks[$id]->data;
        }

        return ['fileName' => $file_name, 'fileData' => $file_content];
    }

    /**
     * @return mixed
     */
    public function getBlocks()
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->serverUrl . '/blocks');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_PORT, 3001);
        curl_setopt($curl, CURLOPT_POST, false);

        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }

        curl_close($curl);

        return json_decode($result);
    }

    /**
     * Checking files with id
     * true - file created with current id
     * false - file didn't creat with current id
     *
     * @param $id
     * @return bool
     */
    public function checkID($id)
    {
        foreach ($this->getBlocks() as $block) {
            $block_id = $this->getID($block->data);

            if ($id == $block_id) {
                return true;
            }
        }

        return false;
    }

    public function getHEX($valLength)
    {
        $result = '';
        $moduleLength = 40;   // we use sha1, so module is 40 chars
        $steps = round(($valLength / $moduleLength) + 0.5);

        for ($i = 0; $i < $steps; $i++) {
            $result .= sha1(uniqid() . md5(rand() . uniqid()));
        }

        return substr($result, 0, $valLength);
    }

    /**
     * @return mixed
     */
    public function getPeers()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->serverUrl . '/peers');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_PORT, 3001);
        curl_setopt($curl, CURLOPT_POST, false);

        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }

        curl_close($curl);

        return json_decode($result);
    }

    public function __destruct()
    {
    }
}