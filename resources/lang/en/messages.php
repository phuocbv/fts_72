<?php

return [

    'errors' => [
        'create' => 'Failed to create a record in database due to a system error.',
        'update' => 'Failed to update a record in database due to a system error.'
    ],
    'success' => [
        'create' => 'Created successfully!',
        'update' => 'Updated successfully!',
    ],
    'empty' => [
        'update' => 'You tried to update an in-use question',
    ],
    'validator' => [
        'answer' => [
            'max' => 'The answer  :key must be less than :max characters.',
            'required' => 'The answer  :key must be required',
        ],
    ],
];
