<?php


class BlockChain
{
    private $serverUrl;
    private $idLength;
    private $blockLength;

    /**
     * BlockChain constructor.
     */
    public function __construct() {
        $this->serverUrl = 'http://192.168.10.1';

        $this->idLength = 10;
        $this->blockLength = 8192 - $this->idLength;
    }


    public function addFile($file_content, $user) {

        $file_content = bin2hex($file_content);
        $id = $this->generateID();

        while ($file_content) {
            $block_content = substr($file_content, 0, $this->blockLength);
            $file_content = substr($file_content, $this->blockLength);

            $block_content = $id . $block_content;

            $this->addBlock($block_content,$user);
        }
    }

    /**
     * @param $data
     */
    public function addBlock($data, $user) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->serverUrl . '/mineBlock');
        curl_setopt($curl, CURLOPT_PORT, 3001);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '{"data" : "' . $data . '", "user" : "'. $user . '"}');

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
     * @return false|string
     */
    public function getFile($id) {

        $file = '';
        $blocks = $this->getBlocks();

        if($blocks) {
            $id = $this->getID($blocks[$id]->data);

            foreach ($blocks as $block) {
                $block_id = $this->getID($block->data);

                if($id == $block_id) {
                    $file .= substr($block->data, $this->idLength);
                }
            }
        }

        $file = hex2bin($file);

        return $file;
    }

    /**
     * @return mixed
     */
    public function getBlocks() {

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
    public function checkID($id) {

        foreach ($this->getBlocks() as $block) {
            $block_id = $this->getID($block->data);

            if($id == $block_id) {
                return true;
            }
        }

        return false;
    }

    public function getID($data) {
        return substr($data, 0, $this->getIdLength());
    }

    public function generateID() {
        $id = '';

        do {
            $id = $this->getHEX($this->idLength);
        } while($this->checkID($id));

        return $id;
    }

    public function getHEX( $valLength ) {
        $result = '';
        $moduleLength = 40;   // we use sha1, so module is 40 chars
        $steps = round(($valLength/$moduleLength) + 0.5);

        for( $i=0; $i<$steps; $i++ ) {
            $result .= sha1( uniqid() . md5( rand() . uniqid() ) );
        }

        return substr( $result, 0, $valLength );
    }

    /**
     * @return mixed
     */
    public function getPeers() {
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


    /**
     * @return int
     */
    public function getIdLength()
    {
        return $this->idLength;
    }

    public function __destruct() {
    }
}