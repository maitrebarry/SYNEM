<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
try {
    \App\Models\HistoriqueMain::unguard();
    $m = \App\Models\HistoriqueMain::first();
    if ($m) {
        echo "IMAGE_IN_DB:" . ($m->image ?? 'NULL') . "\n";
        echo "TEXT_IN_DB:" . mb_substr(($m->text ?? ''), 0, 400) . "\n";
    } else {
        echo "NO_MAIN_RECORD\n";
    }
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
