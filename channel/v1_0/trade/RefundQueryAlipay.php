<?php
namespace asbamboo\openpayAlipay\channel\v1_0\trade;

use asbamboo\openpay\channel\v1_0\trade\RefundQueryInterface;
use asbamboo\openpayAlipay\Constant;
use asbamboo\openpay\channel\v1_0\trade\RefundQueryParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\RefundQueryParameter\Response;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayAlipay\Env;
use asbamboo\openpayAlipay\alipayApi\Client;
use asbamboo\openpayAlipay\alipayApi\response\TradeRefundResponse;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\openpayAlipay\exception\ResponseFormatException;
use asbamboo\api\exception\ApiException;
use asbamboo\openpay\Constant AS OpenpayConstant;

/**
 * 发起支付宝退款请求
 *
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月5日
 */
class RefundQueryAlipay implements RefundQueryInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\RefundInterface::execute()
     */
    public function execute(Request $Request) : Response
    {
        try{
            $request_data           = [
                'app_id'            => (string) EnvHelper::get(Env::ALIPAY_APP_ID),
                'out_trade_no'      => $Request->getInTradeNo(),
                'refund_amount'     => bcdiv($Request->getRefundFee(), 100, 2), //聚合接口接收的单位是分，支付宝的单位是元,
                'out_request_no'    => $Request->getInRefundNo(),
            ];

            $alipay_params          = json_decode((string) $Request->getThirdPart(), true);
            if(is_array($alipay_params)){
                foreach($alipay_params AS $alipay_key => $alipay_value){
                    $request_data[$alipay_key] = $alipay_value;
                }
            }
            
            $AlipayResponse = Client::request('TradeRefund', $request_data);
            if(     $AlipayResponse->get('code') != TradeRefundResponse::CODE_SUCCESS
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
            $Response->setInRefundNo($Request->getInRefundNo());
            if($AlipayResponse->get('fund_change') == true){
                $Response->setRefundStatus(OpenpayConstant::TRADE_REFUND_STATUS_SUCCESS);
                $Response->setRefundPayYmdhis($AlipayResponse->get('gmt_refund_pay'));
            }else{
                $Response->setRefundStatus(OpenpayConstant::TRADE_REFUND_STATUS_FAILED);
            }
            
            return $Response;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
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
