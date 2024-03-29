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
use asbamboo\openpay\channel\v1_0\trade\QueryInterface;
use asbamboo\openpayAlipay\Constant;
use asbamboo\openpay\channel\v1_0\trade\queryParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\queryParameter\Response;
use asbamboo\openpay\Constant AS OpenpayConstant;

/**
 * alipay.trade.query(统一收单线下交易查询)
 *
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年10月27日
 */
class QueryAlipay implements QueryInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\QueryInterface::execute()
     */
    public function execute(Request $Request) : Response
    {
        try{
            $request_data           = [
                'app_id'            => (string) EnvHelper::get(Env::ALIPAY_APP_ID),
                'out_trade_no'      => $Request->getInTradeNo(),
            ];
            $alipay_params          = json_decode((string) $Request->getThirdPart(), true);
            if(is_array($alipay_params)){
                foreach($alipay_params AS $alipay_key => $alipay_value){
                    $request_data[$alipay_key] = $alipay_value;
                }
            }
            $AlipayResponse = Client::request('TradeQuery', $request_data);

            /**
             * 当Alipay返回的响应值表示订单没有创建时，应该用订单未支付的状态作为响应值。
             */
            if(     $AlipayResponse->get('code') == TradeQueryResponse::CODE_BUSINESS_FAILED
                &&  $AlipayResponse->get('sub_code') == 'ACQ.TRADE_NOT_EXIST'
            ){
                $Response           = new Response();
                $Response->setInTradeNo($Request->getInTradeNo());
                $Response->setThirdTradeNo("");
                $Response->setTradeStatus(OpenpayConstant::TRADE_PAY_TRADE_STATUS_NOPAY);
                return $Response;
            }

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
            $Response           = new Response();
            $Response->setInTradeNo($AlipayResponse->get('out_trade_no'));
            $Response->setThirdTradeNo($AlipayResponse->get('trade_no'));
            $Response->setTradeStatus($this->convertTradeStatus($AlipayResponse->get('trade_status')));
            return $Response;
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
            Constant::WAIT_BUYER_PAY => OpenpayConstant::TRADE_PAY_TRADE_STATUS_NOPAY, //（交易创建，等待买家付款）
            Constant::TRADE_CLOSED   => OpenpayConstant::TRADE_PAY_TRADE_STATUS_CANCEL, //（未付款交易超时关闭，或支付完成后全额退款）
            Constant::TRADE_SUCCESS  => OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYOK, //（未付款交易超时关闭，或支付完成后全额退款）
            Constant::TRADE_FINISHED => OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYED, //（未付款交易超时关闭，或支付完成后全额退款）
        ][$alipay_trade_status];
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::supports()
     */
    public function supports() : array
    {
        return [
            Constant::CHANNEL_ALIPAY_PC     => Constant::CHANNEL_ALIPAY_PC_LABEL,
            Constant::CHANNEL_ALIPAY_APP    => Constant::CHANNEL_ALIPAY_APP_LABEL,
            Constant::CHANNEL_ALIPAY_QRCD   => Constant::CHANNEL_ALIPAY_QRCD_LABEL,
            Constant::CHANNEL_ALIPAY_ONECD  => Constant::CHANNEL_ALIPAY_ONECD_LABEL,
        ];
    }
}