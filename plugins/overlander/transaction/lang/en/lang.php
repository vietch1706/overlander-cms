<?php return [
    'plugin' => [
        'name' => 'Transaction',
        'description' => ''
    ],
    'list' => [
        'btn_goto' => 'Go to Point History',
        'btn_return' => 'Return Transaction'
    ],
    'transaction' => [
        'delete' => 'Account deleted because of no purchase record!',
        'archived' => 'Account archived!'
    ],
    'point_history' => [
        'not_found' => 'You have no loss point history',
        'gain_reason' => [
            'invoice' => 'Point from invoice no: :invoice_no',
            'remain' => 'Point remain from invoice no::invoice_no',
        ],
        'loss_reason' => [
            'expired' => 'Expired Point',
            'upgrade' => 'Upgrade Membership to :membership.',
            'downgrade' => 'Downgrade Membership to :membership.',
            'remain' => 'Remain current Membership: :membership.',
        ],
    ]
];
