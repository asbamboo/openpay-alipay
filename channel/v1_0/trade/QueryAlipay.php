<?php
namespace asbamboo\openpayAlipay\channel\v1_0\trade;

use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\api\exception\ApiException;
use asbamboo\helper\env\Env as EnvHelper;
use asbamboo\openpayAlipay\Env;
use asbamboo\openpayAlipay\alipayApi\Client;
use asbamboo\openpayAlipay\alipayApi\response\TradeQueryResponse;
use asbamboo\openpayAlipay\exception\ResponseFormatException;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\openpay\apiStore\parameter\v1_0\trade\Constant;
use asbamboo\openpay\apiStore\parameter\v1_0\trade\query\QueryRequest;
use asbamboo\openpay\apiStore\parameter\v1_0\trade\query\QueryResponse;
use asbamboo\openpay\channel\v1_0\trade\QueryInterface;

/**
 * alipay.trade.query(统一收单线下交易查询)
 *
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年10月27日
 */
class QueryAlipay implements QueryInterface
{
    /**
     * 支付宝查询渠道
     *
     * @var string
     */
    const NAME  = 'ALIPAY';
    const LABEL = '支付宝';

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\QueryInterface::execute()
     */
    public function execute(QueryRequest $QueryRequest) : QueryResponse
    {
        try{
            $request_data           = [
                'app_id'            => (string) EnvHelper::get(Env::ALIPAY_APP_ID),
                'out_trade_no'      => $QueryRequest->getOutTradeNo(),
                'trade_no'          => $QueryRequest->getTradeNo()
            ];
            $alipay_params          = json_decode((string) $QueryRequest->getThirdPart(), true);
            if(is_array($alipay_params)){
                foreach($alipay_params AS $alipay_key => $alipay_value){
                    $request_data[$alipay_key] = $alipay_value;
                }
            }

            $AlipayResponse = Client::request('TradeQuery', $request_data);
            if(     $AlipayResponse->get('code') != TradeQueryResponse::CODE_SUCCESS
                ||  $AlipayResponse->get('sub_code') != null
                ){
                    $Exception                      = new Api3NotSuccessResponseException('支付宝返回的响应值表示这次业务没有处理成功。');
                    $ApiResponseParams              = new ApiResponseParams();
                    $ApiResponseParams->code        = $AlipayResponse->get('code');
                    $ApiResponseParams->msg         = $AlipayResponse->get('msg');
                    $ApiResponseParams->sub_code    = $AlipayResponse->get('sub_code');
                    $ApiResponseParams->sub_msg     = $AlipayResponse->get('sub_msg');
                    $Exception->setApiResponseParams($ApiResponseParams);
                    throw $Exception;
            }
            $QueryResponse  = new QueryResponse([
                'out_trade_no'  => $AlipayResponse->get('out_trade_no'),
                'in_trade_no'   => $AlipayResponse->get('trade_no'),
                'total_fee'     => bcmul($AlipayResponse->get('total_amount'), 100),
                'trade_status'  => $this->convertTradeStatus($AlipayResponse->get('trade_status')),
                'third_part'    => get_object_vars($AlipayResponse),
            ]);
            return $QueryResponse;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 转换交易状态
     *
     * @param string $alipay_trade_status
     */
    private function convertTradeStatus(string $alipay_trade_status)
    {
        return [
            'WAIT_BUYER_PAY'    => Constant::TRADE_STATUS_NOPAY, //（交易创建，等待买家付款）
            'TRADE_CLOSED'      => Constant::TRADE_STATUS_PAYFAILED, //（未付款交易超时关闭，或支付完成后全额退款）
            'TRADE_SUCCESS'     => Constant::TRADE_STATUS_PAYOK, //（未付款交易超时关闭，或支付完成后全额退款）
            'TRADE_FINISHED'    => Constant::TRADE_STATUS_PAYOK, //（未付款交易超时关闭，或支付完成后全额退款）
        ][$alipay_trade_status];
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::getName()
     */
    public function getName() : string
    {
        return self::NAME;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::getLabel()
     */
    public function getLabel() : string
    {
        return self::LABEL;
    }
}