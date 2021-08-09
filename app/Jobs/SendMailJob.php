<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendMail();
    }

    public function sendMail(){
        Mail::send('Master::common.changepass', array('username' => 'Quy pro', 'password' => '11122114')
                , function ($message) {
                    $message->to('ndq809@gmail.com', 'Quy pro')->subject('Hệ Thống Eplus - Đổi Mật Khẩu');
                });
    }
}
