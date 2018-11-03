<?php
namespace asbamboo\openpayAlipay\alipayApi\request;

use asbamboo\openpayAlipay\alipayApi\gateway\GatewayUriTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\BodyTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\UriTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\CreateRequestTrait;
use asbamboo\openpayAlipay\alipayApi\requestParams\bizContent\TradePagePayParams;
use asbamboo\openpayAlipay\alipayApi\requestParams\CommonHasReturnParams;

/**
 * alipay.trade.page.pay(统一收单下单并支付页面接口)
 * PC场景下单并支付
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月3日
 */
class TradePagePay implements RequestInterface
{
    use GatewayUriTrait;
    use BodyTrait;
    use UriTrait;
    use CreateRequestTrait;

    /**
     * 接口请求的method参数的固定值
     *
     * @var string
     */
    const METHOD    = 'alipay.trade.page.pay';

    /**
     * 指派参数的数据集合
     *
     * @var array
     */
    private $assign_data;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\request\RequestInterface::assignData()
     */
    public function assignData(array $assign_data): RequestInterface
    {
        $BizContent     = new TradePagePayParams();
        $CommonParams   = new CommonHasReturnParams();

        $BizContent->mappingData($assign_data);
        $CommonParams->mappingData($assign_data);
        $CommonParams->setBizContent($BizContent);

        $CommonParams->method   = self::METHOD;
        $CommonParams->sign     = $CommonParams->makeSign();
        $this->assign_data      = get_object_vars($CommonParams);

        return $this;
    }

    /**
     *
     * @return array|NULL
     */
    public function getAssignData() : ?array
    {
        return $this->assign_data;
    }
}