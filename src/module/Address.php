<?php
namespace phpsdk\module;

class Address extends Common
{
    /**
     * 地址验证接口
     * @param array $data
     * @param string $data.coin
     * @param string $data.address
     *
     * @return array|false
     * @throws \Exception
     */
    public function verifyAddress($data){
        $url = $this->host. 'address/verifyAddress';
        return $this->curl($url, $data);
    }
}