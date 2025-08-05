<?php

declare(strict_types=1);

return [
    'github' => [
        'username' => env('GITHUB_USERNAME'),
        'accessToken' => env('GITHUB_ACCESS_TOKEN'),
        'repository' => env('GITHUB_CLIENT_REPOSITORY')
    ],
    'excludeFilesFromRepo' => [ // Files that will be deleted from the files target directory
        '.git',
        '.gitignore',
        'README'
    ],
    'excludeExtensionsFromRepo' => [ // Extensions that will be deleted from the files target directory
        'php',
        'txt'
    ]
];
