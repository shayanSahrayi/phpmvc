<?php
 var_dump(get_defined_constants());
exit;

// $file = __FILE__."/"; // دریافت آدرس فایل جاری
// $newTime = time() - (230 * 86400); // محاسبه تایمستاپ ۲۳۰ روز پیش

// if (touch($file, $newTime)) {
//     echo "تاریخ modified فایل با موفقیت به 230 روز پیش تغییر یافت.";
// } else {
//     echo "خطا در تغییر تاریخ modified فایل.";
// }
// 
$file = 's.php'; // نام فایل مورد نظر در همان مسیر
$newTime = time() - (230 * 86400); // 230 روز پیش

if (touch($file, $newTime)) {
    echo "تاریخ modified فایل «{$file}» با موفقیت به 230 روز پیش تغییر یافت.";
} else {
    echo "خطا در تغییر تاریخ modified فایل.";
}
?>

// بررسی اینکه آرگومان‌های CLI وجود دارند یا نه
if ($argc < 2) {
    die("Usage: php artisan.php command\n");
}

// دریافت دستوری که کاربر وارد کرده است
$command = $argv[1];

switch ($command) {
    case 'make:controller':
        if (!isset($argv[2])) {
            die("Error: Please provide a controller name.\n");
        }
        $controllerName = ucfirst($argv[2]) . ".php";
        $controllerPath = __DIR__ . "/app/controller/$controllerName";
        // var_dump($controllerPath);
        // exit;
        // ایجاد فایل کنترلر
        if (!file_exists(__DIR__ . "app/controller/")) {
            
            mkdir(__DIR__ . "app/controller/", 0777, true);
        }

        $template = "<?php\n\nclass $argv[2] {\n    public function index() {\n        echo 'Hello from $argv[2]!';\n    }\n}\n";
        file_put_contents($controllerPath, $template);
        
        echo "Controller $controllerName created successfully!\n";
        break;

    default:
        echo "Command not found!\n";
        break;
}
