<?php return [
    'plugin' => [
        'name' => 'Users',
        'description' => ''
    ],
    'user' => [
        'send_code_message' => [
            'verify' => 'Your verification code is :code. Don\'t share it with anyone!',
            'send_times' => 'You can send verification code each 1 minutes',
            'success' => 'Verification Code Have Been Sent to your email address!',
            'daily_limit' => 'You can only send code 3 times a day!!!',
            'not_found' => 'User not found!',
        ],
        'verify_message' => [
            'success' => 'Verify Success!',
            'failed' => 'Wrong verification code! Please try again.',
            'expired' => 'Your verification code has expired!'
        ],
        'login' => [
            'success' => 'Login Successful!',
            'wrong' => 'Wrong Password! Please try again.',
            'failed' => 'User Not Exist. Please sign up first!'
        ],
        'reset' => [
            'success' => 'Reset Password Successful!',
            'failed' => 'Unable to reset password! Please try again.',
        ],
        'register' => [
            'success' => 'Save Successfully!',
            'failed' => 'Registration Failed! Try again.',
        ],
        'update' => [
            'success' => 'Update Successfully!'
        ],
        'change_password' => [
            'success' => 'Change Password Successful!',
            'failed' => 'User not found! Please try again.',
            'wrong' => 'Password does not match! Please try again.'
        ],
        'check_exist' => [
            'email' => 'The email address already existed.',
            'phone' => 'The phone number already existed.',
            'member_no' => 'The member number already existed.',
        ]
    ],
    'exists_users' => [
        'step1' => [
            'not_found' => 'User not found. Please sign up!',
            'not_exists' => 'You are not a Existing Account. Please login!!!',
            'next_step' => 'Continue to step 2!',
        ]
    ]
];
