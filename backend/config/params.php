<?php

use common\models\LogStore;

return [
    'adminEmail' => 'admin@example.com',
    'allowLogData' => true,
    'logModel' => LogStore::className(),
];
