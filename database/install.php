<?php
declare(strict_types=1);
require dirname(__DIR__) . '/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

if (PHP_SAPI !== 'cli') exit("Run from CLI: php database/install.php\n");

function prompt(string $label, bool $hidden = false): string
{
    echo $label;
    if ($hidden && DIRECTORY_SEPARATOR === '/') {
        shell_exec('stty -echo'); $v = trim((string) fgets(STDIN)); shell_exec('stty echo'); echo "\n";
        return $v;
    }
    return trim((string) fgets(STDIN));
}

$root = dirname(__DIR__);

try {
    $dsn = sprintf('mysql:host=%s;port=%d;charset=utf8mb4',
        $_ENV['DB_HOST'] ?? '127.0.0.1', (int)($_ENV['DB_PORT'] ?? 3306));
    $pdo = new PDO($dsn, $_ENV['DB_USERNAME'] ?? 'root', $_ENV['DB_PASSWORD'] ?? '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $db = $_ENV['DB_DATABASE'] ?? 'myhr';
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$db`");

    // 1. Schema
    $schema = $root . '/database/schema_final.sql';
    if (!is_file($schema)) {
        exit("❌ Missing database/schema_final.sql. Please download and save it first.\n");
    }
    echo "==> Applying schema...\n";
    $pdo->exec(file_get_contents($schema));

    // 2. Super Administrator
    echo "\n==> Create the Super Administrator account\n";
    $adminEmail = strtolower(prompt('Admin email: '));
    if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) exit("Invalid email.\n");
    $adminName = prompt('Admin full name [Super Administrator]: ') ?: 'Super Administrator';
    $adminPass = prompt('Admin password (min 12 chars, mixed case + digit + symbol): ', true);
    $ok = mb_strlen($adminPass) >= 12 && preg_match('/[A-Z]/', $adminPass) && preg_match('/[a-z]/', $adminPass)
        && preg_match('/[0-9]/', $adminPass) && preg_match('/[^A-Za-z0-9]/', $adminPass);
    if (!$ok) exit("Password does not meet requirements.\n");

    $stmt = $pdo->prepare("INSERT INTO users (organization_id, email, password_hash, display_name, status)
                           VALUES (1,?,?,?, 'active')");
    $stmt->execute([$adminEmail, password_hash($adminPass, PASSWORD_ARGON2ID), $adminName]);
    $adminId = (int) $pdo->lastInsertId();
    $roleId = (int) $pdo->query("SELECT id FROM roles WHERE slug='super_admin'")->fetchColumn();
    $pdo->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?,?)")->execute([$adminId, $roleId]);
    echo "    ✓ Super Administrator created (id=$adminId)\n";

    // 3. Ana Reyes (demo HR admin)
    $anaPass = 'Demo@MyHR2026';
    $stmt = $pdo->prepare("INSERT INTO users (organization_id, email, password_hash, display_name, status)
                           VALUES (1,?,?,?, 'active')");
    $stmt->execute(['ana.reyes@natkram.local',
                    password_hash($anaPass, PASSWORD_ARGON2ID), 'Ana Reyes']);
    $anaId = (int) $pdo->lastInsertId();
    $hrRole = (int) $pdo->query("SELECT id FROM roles WHERE slug='hr_admin'")->fetchColumn();
    $pdo->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?,?)")->execute([$anaId, $hrRole]);
    echo "    ✓ Ana Reyes (HR Admin) created (id=$anaId)\n";

    // 4. Demo seed
    echo "\n==> Applying demo data...\n";
    $pdo->exec(file_get_contents($root . '/database/seed_demo.sql'));
    echo "    ✓ Demo data loaded\n";

    // 5. Sanity
    $counts = [
        'employees' => (int) $pdo->query("SELECT COUNT(*) FROM employees")->fetchColumn(),
        'departments' => (int) $pdo->query("SELECT COUNT(*) FROM departments")->fetchColumn(),
        'job_postings' => (int) $pdo->query("SELECT COUNT(*) FROM job_postings")->fetchColumn(),
        'payroll_runs' => (int) $pdo->query("SELECT COUNT(*) FROM payroll_runs")->fetchColumn(),
    ];

    echo "\n✅ Installation complete.\n\n";
    echo "Database: $db\n";
    echo "  Employees:   {$counts['employees']}\n";
    echo "  Departments: {$counts['departments']}\n";
    echo "  Job postings: {$counts['job_postings']}\n";
    echo "  Payroll runs: {$counts['payroll_runs']}\n\n";
    echo "Log in at: " . ($_ENV['APP_URL'] ?? 'http://localhost/myhr/public') . "/login\n\n";
    echo "  → Super Administrator:\n";
    echo "    Email:    $adminEmail\n";
    echo "    Password: (what you just entered)\n\n";
    echo "  → HR Administrator (demo, recommended):\n";
    echo "    Email:    ana.reyes@natkram.local\n";
    echo "    Password: $anaPass\n\n";
    echo "Next step: set APP_DEMO=false in .env\n";

} catch (Throwable $e) {
    fwrite(STDERR, "\n❌ Installation failed: " . $e->getMessage() . "\n");
    exit(1);
}