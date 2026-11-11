<?php
return [
    'name'         => getenv('APP_NAME') ?: 'AgroConecta Huila',
    'url'          => getenv('APP_URL') ?: 'http://localhost/AgroConectaHuila',
    'upload_path'  => 'storage/uploads/products',
    'upload_max_mb'=> (int)(getenv('UPLOAD_MAX_MB') ?: 5),
    'upload_types' => ['image/jpeg','image/png','image/webp'],
    'tipos_producto' => [
        'Café especial','Café molido','Café tostado','Aguacate','Mora',
        'Granadilla','Cítricos','Frutas frescas','Panela','Mermeladas',
        'Productos procesados','Productos artesanales','Otros',
    ],
    'unidades' => ['Kilogramo','Libra','Arroba','Gramo','Bolsa','Unidad','Litro','Frasco','Caja'],
];