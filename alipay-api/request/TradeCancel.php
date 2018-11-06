<?php
namespace asbamboo\openpayAlipay\alipayApi\request;


use asbamboo\openpayAlipay\alipayApi\gateway\GatewayUriTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\BodyTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\UriTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\CreateRequestTrait;
use asbamboo\openpayAlipay\alipayApi\requestParams\bizContent\TradeCancelParams;
use asbamboo\openpayAlipay\alipayApi\requestParams\CommonParams;

/**
 * alipay.trade.cancel(统一收单交易撤销接口)
 *
 *  - 支付交易返回失败或支付系统超时，调用该接口撤销交易。如果此订单用户支付失败，支付宝系统会将此订单关闭；
 *  - 如果用户支付成功，支付宝系统会将此订单资金退还给用户。
 *  - 注意：只有发生支付系统超时或者支付结果未知时可调用撤销，其他正常支付的单如需实现相同功能请调用申请退款API。
 *  - 提交支付交易后调用【查询订单API】，没有明确的支付结果再调用【撤销订单API】。
 *
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月6日
 */
class TradeCancel implements RequestInterface
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
    const METHOD    = 'alipay.trade.cancel';

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
        $BizContent     = new TradeCancelParams();
        $CommonParams   = new CommonParams();

        $BizContent->mappingData($assign_data);
        $CommonParams->mappingData($assign_data);
        $CommonParams->setBizContent($BizContent);

        $CommonParams->method   = self::METHOD;
        $CommonParams->sign     = $CommonParams->makeSign();
        $this->assign_data      = get_object_vars($CommonParams);

        return $this;
    }
}