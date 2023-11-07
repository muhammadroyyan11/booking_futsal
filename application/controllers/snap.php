<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Snap extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
	{
		parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-QhvhnSp42zGkVwAFdQDVlulZ', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');
		$this->load->model('Base_model', 'base');
	}

	public function index()
	{
		$this->load->view('checkout_snap');
	}

	public function token()
	{
		$post = $this->input->post(null, true);

		// var_dump($post);

		// Required
		$transaction_details = array(
			'order_id' => rand(),
			'gross_amount' => $post['subTotal'] - $post['diskon'], // no decimal allowed for creditcard
		);

		$item1_details = array(
			'id' => 'a1',
			'price' => $post['subTotal'],
			'quantity' => 1,
			'name' => $post['item'] . " (" . $post['durasi'] . " Jam)"
		);

		$item2_details = array(
			'id' => 'a2',
			'price' => -$post['diskon'],
			'quantity' => 1,
			'name' => "Diskon"
		);

		// Optional
		$item_details = array($item1_details, $item2_details);

		// Optional
		$billing_address = array(
			'first_name'    => $this->session->userdata('username'),
			'address'       => $this->session->userdata('address'),
			'city'          => $this->session->userdata('kota'),
			'phone'         => $this->session->userdata('phone'),
			'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
			'first_name'    => $this->session->userdata('username'),
			'phone'         => $this->session->userdata('phone'),
			'billing_address'  => $billing_address,
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration'  => 10
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details'       => $item_details,
			'customer_details'   => $customer_details,
			'credit_card'        => $credit_card,
			'expiry'             => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function finish()
	{
		$result = json_decode($this->input->post('result_data'), true);
		$post = $this->input->post(null, true);

		var_dump($post['id_trans']);

		$params = [
			'order_id'			=> $result['order_id'],
			'gross_amount'		=> $result['gross_amount'],
			'payment_type'		=> $result['payment_type'],
			'transaction_time'	=> $result['transaction_time'],
			'bank'				=> $result['va_numbers'][0]['bank'],
			'va_number'			=> $result['va_numbers'][0]['va_number'],
			'pdf_url'			=> $result['pdf_url'],
			'status_code'		=> $result['status_code']
		];

		$this->base->add('checkout_midtrans', $params);

		$paramsUpdate = [
			'grand_total'		=> $result['gross_amount'],
			'status'			=> 1,
			'status_midtrans'	=> $result['status_code']
		];

		$this->base->edit('transaksi', $paramsUpdate, ['id_trans' => $post['id_trans']]);

		$count = count($this->input->post('lapangan'));
		for ($i = 0; $i < $count; $i++) {
			$data_detail[$i] = array(
				'id_transdet'   => $this->input->post('id_transdet[' . $i . ']'),
				'tanggal'       => $this->input->post('tanggal[' . $i . ']'),
				'jam_mulai'     => $this->input->post('jam_mulai[' . $i . ']'),
				'durasi'        => $this->input->post('durasi[' . $i . ']'),
				'harga_jual'    => $this->input->post('harga_jual[' . $i . ']'),
				'jam_selesai'   => $this->input->post('jam_mulai[' . $i . ']') + $this->input->post('durasi[' . $i . ']') . ":00:00",
				'total'   		=> $this->input->post('harga_jual[' . $i . ']') * $this->input->post('durasi[' . $i . ']'),
			);
		}

		$this->db->update_batch('transaksi_detail', $data_detail, 'id_transdet');

		redirect(base_url());
	}
}
