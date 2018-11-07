<?php
namespace asbamboo\openpayAlipay\channel\v1_0\trade;

use asbamboo\openpay\channel\v1_0\trade\RefundInterface;
use asbamboo\openpayAlipay\Constant;
use asbamboo\openpay\channel\v1_0\trade\RefundParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\RefundParameter\Response;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayAlipay\Env;
use asbamboo\openpayAlipay\alipayApi\Client;
use asbamboo\openpayAlipay\alipayApi\response\TradeRefundResponse;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\openpayAlipay\exception\ResponseFormatException;
use asbamboo\api\exception\ApiException;

/**
 * 发起支付宝退款请求
 *
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月5日
 */
class RefundAlipay implements RefundInterface
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
            $Response->setIsSuccess(true);
            $Response->setPayYmdhis($AlipayResponse->get('gmt_refund_pay'));
            $Response->setRefundFee(bcmul($AlipayResponse->get('refund_fee'), 100));
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
            Constant::CHANNEL_ALIPAY_QRCD   => Constant::CHANNEL_ALIPAY_QRCD_LABEL,
        ];
    }
}
