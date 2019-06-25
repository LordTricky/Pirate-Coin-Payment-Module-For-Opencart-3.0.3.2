<?php

class ControllerExtensionPaymentPirate extends Controller {

    private $_pirate;

    public function __construct($registry) {

        parent::__construct($registry);

        $this->load->language('extension/payment/pirate');
        $this->load->model('checkout/order');

        $this->_pirate = new Pirate(
            $this->config->get('payment_pirate_host'),
            $this->config->get('payment_pirate_port'),
            $this->config->get('payment_pirate_user'),
            $this->config->get('payment_pirate_password')
        );

    }

    public function index() {

        $data['text_instruction'] = $this->language->get('text_instruction');
        $data['text_loading']     = $this->language->get('text_loading');
        $data['text_description'] = sprintf($this->language->get('text_description'),
                                            $this->currency->format($this->cart->getTotal(),
                                            $this->config->get('payment_pirate_currency')));

        $data['button_confirm']   = $this->language->get('button_confirm');
        $data['continue']         = $this->url->link('checkout/success');

        $result = $this->_pirate->z_getnewaddress();


        if (isset($result['result'])) {
            $data['address'] = $this->session->data['payment_pirate'] = $result['result'];

        } else {

            $data['address'] = $this->session->data['payment_pirate'] = false;

            if (isset($result['error']['message']) && isset($result['error']['code'])) {
                $this->log->write($result['error']['message'] . '/' . $result['error']['code']);
            } else {
                $this->log->write('Could not receive Pirate address');
            }
        }

        if ($data['address']) {
            switch ($this->config->get('payment_pirate_qr')) {

                case 'google':
                    $data['qr'] = 'https://chart.googleapis.com/chart?chs=240x240&cht=qr&chl=' . $data['address'];
                    break;

                default:
                    $data['qr'] = false;
            }
        }

        return $this->load->view('extension/payment/pirate', $data);
    }

    public function confirm() {
		$json = array();

$tot = $this->currency->format($this->cart->getTotal(), $this->config->get('payment_pirate_currency'));

        if ($this->session->data['payment_method']['code'] == 'pirate' && isset($this->session->data['payment_pirate'])) {

            $this->model_checkout_order->addOrderHistory(
                $this->session->data['order_id'],
                $this->config->get('payment_pirate_order_status_id'),
                sprintf(
                    'Payment Address:  '.$this->session->data['payment_pirate'].'  <br>Price Paid:       '.$tot.'));

                )
            );
$json['redirect'] = $this->url->link('checkout/success');

        }
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		

    }
}
