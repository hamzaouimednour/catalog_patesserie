<?php

return [
    'status' => [
        '<span class="badge badge-secondary">Inactive</span>',
        '<span class="wd-50 badge badge-success">Active</span>'
    ],    
    'order-status' => [
        'P' => '<span class="badge badge-warning">En attente</span>',
        'M' => '<span class="badge badge-primary">En préparation</span>',
        'R' => '<span class="badge badge-info">Prête a livraison</span>',
        'D' => '<span class="badge badge-secondary">En livraison</span>',
        'L' => '<span class="badge badge-success">Livrée</span>',
        'C' => '<span class="badge badge-danger">Annulée</span>',
    ],
    'tooltip' => [ 
        0 => [
            'title' => 'Activer',
            'icon' => 'fa fa-eye',
        ],                
        1 => [
            'title' => 'Désactiver',
            'icon' => 'fa fa-eye-slash',
        ]
    ]
];