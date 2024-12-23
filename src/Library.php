<?php
namespace phpsdk;

class Library
{
    private $config = [
        'app_id' => '',                 // 商户号（后台获取）
        'host' => 'https://xxx.com/',   // api接口域名，/结尾
        'version' => '1.0',             // 版本号
        'time' => '',                   // 时间戳（秒）
        'key_version' => '',            // 默认为空，risk - 风控、query - 查询
        'lang' => 'cn',                 // 默认为cn，仅支持，cn - 中文、en - 英文

        // 自己的私钥，对应公钥需要绑定至商户后台
        'private_key' => '',

        // 商户的公钥，用于响应数据验签
        'platform_public_key' => '',
    ];
    
    public $host;
    public $private_key;
    public $platform_public_key;

    /**
     * constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);

        $this->host = $config['host'] ?? '';
        $this->private_key = $config['private_key'] ?? '';
        $this->platform_public_key = $config['platform_public_key'] ?? '';
        unset($this->config['host'], $this->config['private_key'], $this->config['platform_public_key']);
        
        // 默认时间戳
        if(!$this->config['time']){
            $this->config['time'] = time();
        }
    }

    /**
     * 获取签名sign
     * @param $data
     * @return false|string
     */
    public function encryption($data){
        $data = array_merge($this->config, $data);
        return encryption($data, $this->private_key);
    }

    /**
     * 验证sign是否有效
     * @param $data
     * @return bool
     */
    public function checkSignature($data){
        return checkSignature($data, $this->platform_public_key);
    }

    /**
     * 调用接口（此接口，需根据文档对应要求，将对应数据进行验签）
     * @param array $data 文档对应传参
     * @param string $url 接口相对路由，例如：rate/index
     *
     * @return json
     * @throws \Exception
     */
    public function curl($data, $url){
        try {
            $url = $this->host . $url;
            // 获取sign
            $data['sign'] = $this->encryption($data);
            $result = curl($url, $data);

            return $result;
        }catch (\Exception $e){
            throw new \Exception('Request exception');
        }
    }
}