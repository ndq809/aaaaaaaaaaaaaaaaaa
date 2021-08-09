<?php

return [
    'rules' => [
        'family_nm'          => 'required|max:50',
        'first_name'         => 'required|max:20',
        'email'              => 'required|max:50|email',
        'cellphone'          => 'nullable|digits_between:0,15',
        'employee_div'       => 'required|not_in:0',
        'account_nm'         => 'required|string|max:30',
        'account_nm_create'  => 'required|string|max:30',
        'password'           => 'required|string|min:8',
        'old_password'       => 'required|string|min:8',
        'password_create'    => 'required|string|min:8',
        'password_confirm'   => 'required|same:password_create|string|min:8',
        'password_recreate'  => 'required|different:old_password|string|min:8',
        'password_reconfirm' => 'required|same:password_recreate|string|min:8',
        'user_id'            => 'required|max:15',
        'system_div'         => 'required|not_in:0',
        'account_div'        => 'required|not_in:0',
        // 'employee_id'      => 'required',
        'catalogue_nm'       => 'required|max:200',
        'catalogue_div'      => 'required|not_in:0',
        'name_div'           => 'required|not_in:0',
        'group_nm'           => 'required',
        'post_media'         => 'required',
        'vocabulary_nm'      => 'required',
        'vocabulary_div'     => 'required|not_in:0',
        'spelling'           => 'required',
        'mean'               => 'required',
        'word-mean'          => 'required',
        'target_div'         => 'required',
        'title'              => 'required',
        'content'            => 'required',
        'save_type'          => 'required|not_in:0',
    ],
];
