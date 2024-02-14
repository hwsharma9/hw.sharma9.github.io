<?php

return [
    'controller_methods' => [
        'get',
        'post',
        // 'put',
        // 'patch',
        'delete'
    ],

    'resides_at' => [
        'backend' => 'manage',
        'frontend' => 'user',
        'root' => 'root',
    ],

    'status' => [
        0 => 'Pending',
        1 => 'Active',
        2 => 'Inactive'
    ],

    'course_status' => [
        0 => 'Draft',
        1 => 'Submitted',
        2 => 'Approved',
        3 => 'Published',
        4 => 'Unpublished'
    ]
];
