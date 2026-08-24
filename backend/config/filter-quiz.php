<?php


return [

    'levels' => [
        'basic', 
        'intermediate', 
        'advanced'
    ],

    'sub_levels_assessments' => [
        'basic' => [
            'label' => 'Primeros pasos',
            'choices' => [
                'none',
                'some_base',
                'understands_basics',
            ]
        ],
        'intermediate' => [
            'label' => 'Ya me defiendo',
            'choices' => [
                'starting_to_use',
                'handles_situations',
                'speaks_fluently',
            ]

        ],
        'advanced' => [
            'label' => 'Tengo nivel',
            'choices' => [
                'understands_fast',
                'speaks_precisely',
                'sounds_natural',
            ]
        ]
    ]

];
