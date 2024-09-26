<?php return [
    'plugin' => [
        'name' => 'Users',
        'description' => ''
    ],
    'user' => [
        'not_found' => 'User not found. Please sign up!',
        'send_code_message' => [
            'verify' => 'Your verification code is :code. Don\'t share it with anyone!',
            'send_times' => 'You can send verification code each 1 minutes',
            'success' => 'Verification Code Have Been Sent to your email address!',
            'daily_limit' => 'You can only send code 3 times a day!!!',
        ],
        'verify_message' => [
            'success' => 'Verify Success!',
            'failed' => 'Wrong verification code! Please try again.',
            'expired' => 'Your verification code has expired!'
        ],
        'login' => [
            'success' => 'Login Successful!',
            'wrong' => 'Incorrect email address or password, please try again.',
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
            'success' => 'You have updated your profile'
        ],
        'change_password' => [
            'success' => 'Change Password Successful!',
            'failed' => 'User not found! Please try again.',
            'wrong' => 'Incorrect password'
        ],
        'check_exist' => [
            'email' => 'The email address already existed.',
            'phone' => 'The phone number already existed.',
            'member_no' => 'The member number already existed.',
        ]
    ],
    'exists_users' => [
        'step1' => [
            'next_step' => 'Success! Continue to next step!',
        ],
        'step2' => [
            'success' => 'Step 2 Verification Successful!',
            'failed' => 'Wrong Information! Please try again.',
        ]
    ],
];
