<?php

return [
    '~^articles/(\d+)/delete$~' => [\Src\Controllers\Api\ArticlesApiController::class, 'delete'],
    '~^articles/(\d+)$~' => [\Src\Controllers\Api\ArticlesApiController::class, 'GET' => 'view', 'POST' => 'view', 'PUT' => 'edit'],
    '~^articles$~' => [\Src\Controllers\Api\ArticlesApiController::class, 'GET' =>'all', 'POST' => 'add'],
    '~^emailUnique/(\d+)$~' => [\Src\Controllers\Api\UsersApiController::class,'getEmailIsUnique'],
    '~^loginUnique/(\d+)$~' => [\Src\Controllers\Api\UsersApiController::class,'getLoginIsUnique']
];