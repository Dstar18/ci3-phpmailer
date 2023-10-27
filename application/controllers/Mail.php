<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail extends CI_Controller {

	public function index(){
        $result['date']     = "Today is " . date("Y-m-d h:i:sa");
        $result['data1']    = "ini adalah laporan perkembangan penjualan hari ini";
		$this->load->view('mail',$result);
	}

	public function send(){
		$mail = new PHPMailer(true);

		try{
			// server setting
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = $this->config->item('mailHost');
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->config->item('mailUsername');
            $mail->Password   = $this->config->item('mailPassword');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

			// recipients
			$mail->setFrom('emailpengirim@mail.com', 'nickname');
            $mail->addAddress('emailtujuan@mail.com', 'nickname');
            // $mail->addCC('');

			// attachments (optional)
			$mail->addAttachment('dataset/laporanPHPMailer.xlsx', 'laporanPHPMailer.xlsx');

			// content
			$result['date']     = "Today is " . date("Y-m-d h:i:sa");
        	$result['data1']    = "ini adalah laporan perkembangan penjualan hari ini";
			$viewMsg = $this->load->view('mail',$result,TRUE);

			// send mail
			$mail->isHTML(true);
			$mail->Subject = 'Laporan Penjualan [' . date("Y-m-d h:i:sa") . ']';
			$mail->msgHTML($viewMsg);
			$mail->send();
            echo 'Message has been sent';
		}catch(Exception $e){
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
