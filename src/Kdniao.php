<?php


namespace Wwhu\Kdniao;


class Kdniao
{
    private $EBusinessID;

    private $appKey;

    // 物流公司对应代号
    protected $codes;

    private $orderTracesURL = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';

    public function __construct()
    {
        $this->EBusinessID = config('kdniao.business_id', env('KDNIAO_EBUSINESS_ID'));
        $this->appKey = config('kdniao.app_key', env('KDNIAO_APP_KEY'));
    }

    /**
     * Json方式 查询订单物流轨迹
     * @param $logisticCode
     * @param $shipperCode
     * @param string $orderCode
     * @return string
     */
    public function getOrderTraces($logisticCode, $shipperCode, $orderCode = '')
    {
        $requestData = $this->jsonData(['LogisticCode' => $logisticCode, 'ShipperCode' => $shipperCode, 'OrderCode' => $orderCode]);

        $datas = [
            'EBusinessID' => $this->EBusinessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType'    => '2',
        ];
        $datas['DataSign'] = $this->encrypt($requestData);

        return $this->sendPost($this->orderTracesURL, $datas);
    }

    /**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return string url响应返回的html
     */
    protected function sendPost($url, $datas)
    {
        $temps = [];
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if (empty($url_info['port'])) {
            $url_info['port'] = 80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader .= "Host:" . $url_info['host'] . "\r\n";
        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader .= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader .= "Connection:close\r\n\r\n";
        $httpheader .= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
//        $headerFlag = true;
        while ( !feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while ( !feof($fd)) {
            $gets .= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    /**
     * 电商Sign签名生成
     * @param string $data 内容
     * @return string DataSign签名
     */
    protected function encrypt($data)
    {
        return urlencode(base64_encode(md5($data . $this->appKey)));
    }

    /**
     * json 数据
     * @param $data
     * @return string
     */
    public function jsonData($data)
    {
        return is_array($data) ? json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $data;
    }

    public function setCodes(array $codes)
    {
        return $this->codes = array_merge(config('kdniao.codes'), $codes);
    }

    /**
     * 通过物流名称获取物流代号
     * @param string $name
     * @return mixed
     */
    public function getCode(string $name)
    {
        return array_search($name, $this->codes);
    }
}