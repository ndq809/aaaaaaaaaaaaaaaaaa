<?php

return [
    'rules' => [
        'family_nm'        => 'max:50',
        'first_name'       => 'max:20',
        'email'            => 'max:50|email',
        'cellphone'        => 'nullable|digits_between:0,15',
        'birth_date'       => 'nullable',
        'employee_div'     => 'required|not_in:0',
        'account_nm'       => 'required|string|max:30',
        'password'         => 'required|string|min:8',
        'password_confirm' => 'required|same:password|string|min:8',
        'user_id'          => 'required|max:15',
        'system_div'       => 'required|not_in:0',
        'account_div'      => 'required|not_in:0',
        // 'employee_id'      => 'required',
        'catalogue_nm'     => 'required|max:200',
        'catalogue_div'    => 'required|not_in:0',
        'name_div'         => 'required|not_in:0',
        'group_nm'         => 'required',
        'post_media'       => 'required',
        'vocabulary_nm'    => 'required',
        'vocabulary_div'   => 'required|not_in:0',
        'spelling'         => 'required',
        'mean'             => 'required',
        'target_div'       => 'required',
    ],
];
