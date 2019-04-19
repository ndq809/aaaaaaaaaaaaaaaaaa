<?php

namespace App\Events;

use commonUser;
use DAO;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvents implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message = [];

    public function __construct($param, $view, $target_div)
    {
        $data = Dao::call_stored_procedure('SPC_COM_ADD_NOTIFY', $param);
        if ($data[0][0]['Data'] == 'Exception' || $data[0][0]['Data'] == 'EXCEPTION') {
            $result = array(
                'status' => 208,
                'data'   => $data[0],
            );
        } else if ($data[0][0]['Data'] != '') {
            $result = array(
                'status' => 207,
                'data'   => $data[0],
            );
        } else {
            $this->message[0]                   = $data[1];
            $this->message[1][0]['respone']     = $view;
            $this->message[1][0]['parent_id']   = $target_div == '' ? $param[2] : ((int) $target_div == 1 ? 'chemgio' : 'gopy');
            $this->message[1][0]['user_code']   = $param['user_id'];
            $this->message[1][0]['notify_type'] = $param['notify_type'];
            $this->message[1][0]['screen_code'] = $data[2][0]['screen_code'];
            $this->message[1][0]['target_id']   = $data[2][0]['target_id'];
            $this->message                      = commonUser::encodeID($this->message);
        }

    }

    public function broadcastOn()
    {
        return ['notification'];
    }
}
