<?php

class ControllerExtensionPaymentPirate extends Controller {
    private $error = array();

    public function index() {
                $this->load->language('extension/payment/pirate');
		$this->document->setTitle($this->language->get('heading_title'));
                $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_pirate', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
	    $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
	    'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
	    'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/pirate', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/pirate', 'user_token=' . $this->session->data['user_token'], true);

	$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        if (isset($this->request->post['payment_pirate_user'])) {
            $data['payment_pirate_user'] = $this->request->post['payment_pirate_user'];
        } else if ($this->config->get('payment_pirate_user')) {
            $data['payment_pirate_user'] = $this->config->get('payment_pirate_user');
        } else {
            $data['payment_pirate_user'] = 'user';
        }

        if (isset($this->request->post['payment_pirate_password'])) {
            $data['payment_pirate_password'] = $this->request->post['payment_pirate_password'];
        } else if ($this->config->get('payment_pirate_password')) {
            $data['payment_pirate_password'] = $this->config->get('payment_pirate_password');
        } else {
            $data['payment_pirate_password'] = 'changeme';
        }

        if (isset($this->request->post['payment_pirate_host'])) {
            $data['payment_pirate_host'] = $this->request->post['payment_pirate_host'];
        } else if ($this->config->get('payment_pirate_host')) {
            $data['payment_pirate_host'] = $this->config->get('payment_pirate_host');
        } else {
            $data['payment_pirate_host'] = 'localhost';
        }

        if (isset($this->request->post['payment_pirate_port'])) {
            $data['payment_pirate_port'] = $this->request->post['payment_pirate_port'];
        } else if ($this->config->get('payment_pirate_port')) {
            $data['payment_pirate_port'] = $this->config->get('payment_pirate_port');
        } else {
            $data['payment_pirate_port'] = 45453;
        }

        if (isset($this->request->post['payment_pirate_total'])) {
            $data['payment_pirate_total'] = $this->request->post['payment_pirate_total'];
        } else {
            $data['payment_pirate_total'] = $this->config->get('payment_pirate_total');
        }

        if (isset($this->request->post['payment_pirate_qr'])) {
            $data['payment_pirate_qr'] = $this->request->post['payment_pirate_qr'];
        } else {
            $data['payment_pirate_qr'] = $this->config->get('payment_pirate_qr');
        }

        if (isset($this->request->post['payment_pirate_currency'])) {
            $data['payment_pirate_currency'] = $this->request->post['payment_pirate_currency'];
        } else {
            $data['payment_pirate_currency'] = $this->config->get('payment_pirate_currency');
        }

       $this->load->model('localisation/currency');

       $data['currencies'] = $this->model_localisation_currency->getCurrencies();


        if (isset($this->request->post['payment_pirate_order_status_id'])) {
            $data['payment_pirate_order_status_id'] = $this->request->post['payment_pirate_order_status_id'];
        } else {
            $data['payment_pirate_order_status_id'] = $this->config->get('payment_pirate_order_status_id');
        }

	$this->load->model('localisation/order_status');

	$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['payment_pirate_geo_zone_id'])) {
            $data['payment_pirate_geo_zone_id'] = $this->request->post['payment_pirate_geo_zone_id'];
        } else {
            $data['payment_pirate_geo_zone_id'] = $this->config->get('payment_pirate_geo_zone_id');
        }

	$this->load->model('localisation/geo_zone');

	$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['payment_pirate_status'])) {
            $data['payment_pirate_status'] = $this->request->post['payment_pirate_status'];
        } else {
            $data['payment_pirate_status'] = $this->config->get('payment_pirate_status');
        }

        if (isset($this->request->post['payment_pirate_sort_order'])) {
            $data['payment_pirate_sort_order'] = $this->request->post['payment_pirate_sort_order'];
        } else {
            $data['payment_pirate_sort_order'] = $this->config->get('payment_pirate_sort_order');
        }

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/pirate', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/pirate')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
