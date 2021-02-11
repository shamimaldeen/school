<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    function get_settings($type)
    {
        return $this->db->get_where('settings', array('type' => $type))->row()->description;
    }

    ////////private message//////
    function send_new_private_message() {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));

        $receiver   = $this->input->post('receiver');
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'receiver' => $receiver))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $receiver, 'receiver' => $sender))->num_rows();

        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code                        = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender']              = $sender;
            $data_message_thread['receiver']            = $receiver;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'receiver' => $receiver))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $receiver, 'receiver' => $sender))->row()->message_thread_code;

        $phone = $this->getReceiverPhoneNumber($receiver);
        if (strlen($phone) == 13) {
            $message_value = array (
                'phone' => $phone,
                'text' => $message
            );
            $response = $this->sendServerMessage($message_value);
        }else{
            $response = 'Invalid mobile number';
        }
        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['response']               = $response;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
//        $this->email_model->notify_email('new_message_notification', $this->db->insert_id());
        return $message_thread_code;
    }

    public function send_unpaid_message()
    {

    }

    function send_reply_message($message_thread_code) {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        $receiver = $this->getReceiverByThreadCode($message_thread_code);
        if ($receiver){
            $phone = $this->getReceiverPhoneNumber($receiver);
            if (strlen($phone) == 13) {
                $message_value = array (
                    'phone' => $phone,
                    'text' => $message
                );
                $response = $this->sendServerMessage($message_value);
//            dd($response);
            }else{
                $response = 'Invalid mobile number!';
            }
        }else{
            $response = 'No receiver found!';
        }

        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['response']               = $response;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());
    }

    function send_reply_group_message($message_thread_code) {
        $sms_setting = get_settings('active_sms_service');
        if ($sms_setting == 'metro_net') {
            $thread = $this->db->where('group_message_thread_code', $message_thread_code)->get('group_message_thread')->first_row();
            if ($thread) {
                $timestamp  = strtotime(date("Y-m-d H:i:s"));
                $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                $response = null;
                $total_count = 0;
                $receivers = json_decode($thread->members);
                $text_message = $this->input->post('message');
                $phone_numbers = '';
                foreach ($receivers as $rcv) {
                    $phone = $this->getReceiverPhoneNumber($rcv, '_');
                    if (strlen($phone) == 13) {
                        $phone_numbers .= $phone . '+';
                        $total_count++;
                    }
                }
                if ($phone_numbers != '' && $text_message != ''){
                    $message_value = array (
                        'phone' => trim($phone_numbers, '+'),
                        'text' => $text_message
                    );
//                    dd($message_value);
                    $response = $this->message_model->sendServerMessage($message_value);
                    $data_message['group_message_thread_code']    = $message_thread_code;
                    $data_message['message']                = $text_message;
                    $data_message['sender']                 = $sender;
                    $data_message['response']               = $response;
                    $data_message['total']                  = $total_count;
                    $data_message['timestamp']              = $timestamp;
                    $this->db->insert('group_message', $data_message);
                }else{
                    $this->session->set_flashdata('error_message', 'Error! No valid phone number found');
                    redirect(site_url('admin/group_message_custom/'), 'refresh');
                }
            }else{
                $this->session->set_flashdata('error_message', 'Error! No record found');
                redirect(site_url('admin/group_message_custom/'), 'refresh');
            }
        }else{
            $this->session->set_flashdata('error_message', 'Error! SMS service is disabled.');
            redirect(site_url('admin/group_message_custom/'), 'refresh');
        }
        

    }

    function mark_thread_messages_read($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function getReceiverByThreadCode($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $this->db->where('message_thread_code', $message_thread_code);
        $row = $this->db->get('message_thread')->first_row();
        return ($row) ? $row->receiver : false;
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }


    // Group messaging portion
    function create_group(){
      $data = array();
      $data['group_message_thread_code'] = substr(md5(rand(100000000, 20000000000)), 0, 15);
      $data['created_timestamp'] = strtotime(date("Y-m-d H:i:s"));
      $data['group_name'] = $this->input->post('group_name');
      if(!empty($_POST['user'])) {
          //array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
          $data['members'] = json_encode($_POST['user']);
      }
      else{
        $_POST['user'] = array();
        //array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
        $data['members'] = json_encode($_POST['user']);
      }
      $this->db->insert('group_message_thread', $data);
      redirect(site_url('admin/group_message_custom'), 'refresh');
    }
    // Group messaging portion
    function update_group($thread_code = ""){
      $data = array();
      $data['group_name'] = $this->input->post('group_name');
      if(!empty($_POST['user'])) {
          //array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
          $data['members'] = json_encode($_POST['user']);
      }
      else{
        $_POST['user'] = array();
        //array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
        $data['members'] = json_encode($_POST['user']);
      }
      $this->db->where('group_message_thread_code', $thread_code);
      $this->db->update('group_message_thread', $data);
        redirect(site_url('admin/group_message_custom'), 'refresh');
    }

    function sendServerMessage($param)
    {
        $service_name = $this->get_settings('active_sms_service');
        if ($service_name == 'metro_net') {
            $url = $this->get_settings('sms_api_url');
            $api_key = $this->get_settings('sms_api_key');
            $sender_id = $this->get_settings('sms_sender_id');
            $data = [
                "api_key"   => $api_key,
                "type"      => "text",
                "contacts"  => $param['phone'],
                "senderid"  => $sender_id,
                "msg"       => $param['text'],
            ];
//            dd($data);
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
              $response = curl_exec($ch);
              curl_close($ch);
              return $response;
        }else{
            return 'Service not available';
        }
    }

    public function getReceiverPhoneNumber($receiver, $glue='-')
    {
        $expo = explode($glue, $receiver);
        if (isset($expo[0]) && isset($expo[1])) {
            if ($expo[0]=='student')
            {
                $std = $this->db->get_where('student', array('student_id' => $expo[1]))->first_row();
                return ($std) ? '88'.$std->phone : false;
            }
            elseif ($expo[0]=='parent')
            {
                $prnt = $this->db->get_where('parent', array('parent_id' => $expo[1]))->first_row();
                return ($prnt) ? '88'.$prnt->phone : false;
            }
            elseif ($expo[0]=='teacher')
            {
                $tchr = $this->db->get_where('teacher', array('teacher_id' => $expo[1]))->first_row();
                return ($tchr) ? '88'.$tchr->phone : false;
            }
            else
            {
                return false;
            }
        }else{
            return false;
        }
    }
}
