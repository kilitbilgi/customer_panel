<?php
use Payum\Core\Registry\RegistryInterface;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Security\HttpRequestVerifierInterface;
use Symfony\Component\HttpFoundation\Request;

class PaypalController extends BaseController
{
    public function prepareExpressCheckout()
    {
        $price = Crypt::decrypt(Input::get('price'));
        $id = Crypt::decrypt(Input::get('id'));
        $title = Crypt::decrypt(Input::get('title'));

        Session::put('order_id', $id);

        $storage = \App::make('payum')->getStorage('Payum\Core\Model\ArrayObject');
        $details = $storage->createModel();
        $details['PAYMENTREQUEST_0_CURRENCYCODE'] = 'TRY';
        $details['PAYMENTREQUEST_0_AMT'] = $price;
        $details['L_PAYMENTREQUEST_0_NAME0'] = $title;
        $details['L_PAYMENTREQUEST_0_NUMBER0'] = $id;
        $details['L_PAYMENTREQUEST_0_QTY0'] = 1;
        $details['L_PAYMENTREQUEST_0_AMT0'] = $price;
        $storage->updateModel($details);

        $captureToken = \App::make('payum.security.token_factory')->createCaptureToken('paypal_es', $details, 'payment_done');

        return \Redirect::to($captureToken->getTargetUrl());
    }

    public function done($payum_token = '')
    {
        $request = \App::make('request');
        $request->attributes->set('payum_token', $payum_token);

        $token = $this->getHttpRequestVerifier()->verify($request);
        $payment = $this->getPayum()->getPayment($token->getPaymentName());

        $payment->execute($status = new GetHumanStatus($token));

        /*
        return \Response::json(array(
            'status' => $status->getValue(),
            'details' => iterator_to_array($status->getModel())
        ));*/

        $payment_status  = $status->getValue();
        $order_id = Session::get('order_id');
        $user_id = Auth::user()->id;

        if($payment_status == "canceled"){
            $payment_obj = new Payment();
            $payment_obj->txn_id = 000000;
            $payment_obj->user_id = $user_id;
            $payment_obj->order_id = $order_id;
            $payment_obj->status = "canceled";
            $payment_obj->save();

            Session::forget('order_id');
            return Redirect::to('orders')->with('payment_error',true);
        }else{
            $order = Order::where('id','=',$order_id)->first();
            $order->status='onprogress';
            $order->created_at = Date('Y-m-d H:m:s');
            $order->save();

            $payment_details = iterator_to_array($status->getModel());
            $success_status = $payment_details["PAYMENTINFO_0_PAYMENTSTATUS"];
            $txn_id = $payment_details["PAYMENTREQUEST_0_TRANSACTIONID"];
            $user_id = Auth::user()->id;

            $payment_obj = new Payment();
            $payment_obj->txn_id = $txn_id;
            $payment_obj->user_id = $user_id;
            $payment_obj->order_id = $order_id;
            $payment_obj->status = "success";
            $payment_obj->save();

            Session::forget('order_id');
            return Redirect::to('orders')->with('payment_success',true);
        }
    }

    /**
     * @return RegistryInterface
     */
    protected function getPayum()
    {
        return \App::make('payum');
    }

    /**
     * @return HttpRequestVerifierInterface
     */
    protected function getHttpRequestVerifier()
    {
        return \App::make('payum.security.http_request_verifier');
    }
}