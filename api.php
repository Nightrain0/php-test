<?php
// 设置头部，允许跨域访问和JSON格式
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type");

// 数据存储的文件名
$dataFile = 'products_data.json';

// 获取请求类型 (GET 是获取数据, POST 是保存数据)
$method = $_SERVER['REQUEST_METHOD'];

// 1. 如果是读取数据 (打开页面时)
if ($method === 'GET') {
    if (file_exists($dataFile)) {
        echo file_get_contents($dataFile);
    } else {
        // 如果文件不存在，返回空数组
        echo '[]';
    }
}

// 2. 如果是保存数据 (添加/修改/删除时)
elseif ($method === 'POST') {
    // 获取前端发来的JSON数据
    $inputData = file_get_contents('php://input');
    
    // 简单的验证：确保是合法的JSON
    if (json_decode($inputData) !== null) {
        // 写入文件
        file_put_contents($dataFile, $inputData);
        echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    }
}
?>