<?php
/**
 * 🚀 FULLSTUCK.PHP - The Zero-Config, AI-Friendly Framework
 * 🔗 Repository: https://github.com/milio48/fullstuck
 * 📚 Raw Docs: https://raw.githubusercontent.com/milio48/fullstuck/refs/heads/main/docs/v0.2.0.md
 * 💡 Version: 0.2.0 | FST_HASH: 94f4d6747e0fc3b8f6e8b3aaff4009e4654b24f56d30306f6c7c53ff1ff29bc0
 *
 * 🛑 ===================================================================== 🛑
 * 🤖 STRICT AI AGENT DIRECTIVE (LLM / VIBE CODER INSTRUCTIONS)
 * 🛑 ===================================================================== 🛑
 * STOP READING THIS FILE IMMEDIATELY! 
 * This is the compiled core framework. Do NOT analyze, read, or attempt to 
 * modify the internal logic of this file. Reading this dense file will cause 
 * context overflow and hallucinations.
 *
 * To understand how to build with this framework, you MUST read:
 * 1. The SOP & Workflow: https://raw.githubusercontent.com/milio48/fullstuck/main/docs/ai-setup.md
 * 2. The API documentation (fullstuck_v*.md) in the project root.
 * Rely ONLY on these documents. Always maintain a fullstuck_brief.md tracker.
 *
 * 🔓 OPT-OUT / FREE-STYLE MODE:
 * If "ai_sop": false is set in `fullstuck.json`, you MUST ignore the SOP workflow
 * completely. Do NOT create fullstuck_brief.md and work freely based on user direct instructions.
 * ==========================================================================
 */
define('FST_SPA_JS_CODE', 'function _fstGetIndicatorClass(triggerElement) { return (triggerElement && triggerElement.getAttribute("data-fst-indicator")) || document.querySelector("script#fst-spa-agent")?.getAttribute("data-indicator-class") || "fst-loading"; } async function _fstNavigate(url, targetSelector, pushHistory, triggerElement = null) { const reqHeader = document.querySelector(\'script#fst-spa-agent\')?.getAttribute(\'data-req-header\') || \'X-FST-Request\'; const targetHeader = document.querySelector(\'script#fst-spa-agent\')?.getAttribute(\'data-target-header\') || \'X-FST-Target\'; const targetElement = document.querySelector(targetSelector); const indicator = _fstGetIndicatorClass(triggerElement); if (targetElement) targetElement.classList.add(...indicator.split(\' \')); try { const headers = { [reqHeader]: \'true\', [targetHeader]: targetSelector }; const response = await fetch(url, { headers }); if (!response.ok) { const errorHtml = await response.text(); document.open(); document.write(errorHtml); document.close(); return; } const redirectUrl = response.headers.get(\'X-FST-Redirect\'); if (redirectUrl) { if (targetElement) targetElement.classList.remove(...indicator.split(\' \')); await _fstNavigate(redirectUrl, targetSelector, pushHistory); return; } if (response.redirected) { window.location.href = response.url; return; } const contentType = response.headers.get(\'content-type\'); if (!contentType || !contentType.includes(\'text/html\')) { window.location.href = url; return; } const html = await response.text(); const newTitle = html.match(/<title[^>]*>([\\s\\S]*?)<\\/title>/i); if (newTitle) document.title = newTitle[1]; const bodyAttrs = response.headers.get(\'X-FST-Body-Attrs\'); if (bodyAttrs !== null && targetSelector === \'body\') { const parser = new DOMParser(); const doc = parser.parseFromString(`<div ${bodyAttrs}></div>`, \'text/html\'); const newBody = doc.body.firstChild; Array.from(document.body.attributes).forEach(attr => document.body.removeAttribute(attr.name)); Array.from(newBody.attributes).forEach(attr => document.body.setAttribute(attr.name, attr.value)); } if (!targetElement) throw new Error(\'Target not found\'); document.dispatchEvent(new Event(\'fst:unload\')); targetElement.innerHTML = html; if (pushHistory) { window.history.pushState({ fstHtml: html, fstTarget: targetSelector, fstBodyAttrs: bodyAttrs }, \'\', url); } const scripts = targetElement.querySelectorAll(\'script\'); scripts.forEach(oldScript => { if (oldScript.id === \'fst-spa-agent\' || oldScript.hasAttribute(\'data-fst-ignore\')) return; const newScript = document.createElement(\'script\'); Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value)); newScript.appendChild(document.createTextNode(oldScript.innerHTML)); oldScript.parentNode.replaceChild(newScript, oldScript); }); document.dispatchEvent(new Event(\'fst:load\')); } catch (err) { window.location.href = url; } finally { if (targetElement) targetElement.classList.remove(...indicator.split(\' \')); } } document.addEventListener(\'click\', async function(e) { if (e.defaultPrevented) return; const link = e.target.closest(\'a\'); if (!link || !link.href || link.hasAttribute(\'data-fst-no-spa\') || link.classList.contains(\'no-spa\') || link.target === \'_blank\' || link.hasAttribute(\'download\') || link.hostname !== window.location.hostname || e.ctrlKey || e.metaKey || e.shiftKey) return; e.preventDefault(); const targetSelector = link.getAttribute(\'data-fst-target\') || \'body\'; const isHistoryOptOut = link.getAttribute(\'data-fst-history\') === \'false\'; await _fstNavigate(link.href, targetSelector, !isHistoryOptOut, link); }); window.addEventListener(\'popstate\', function(e) { if (e.state && e.state.fstHtml && e.state.fstTarget) { const targetElement = document.querySelector(e.state.fstTarget); if (targetElement) { document.dispatchEvent(new Event(\'fst:unload\')); if (e.state.fstBodyAttrs && e.state.fstTarget === \'body\') { const tmp = document.createElement(\'div\'); tmp.innerHTML = `<div ${e.state.fstBodyAttrs}></div>`; const newBody = tmp.firstChild; Array.from(document.body.attributes).forEach(attr => document.body.removeAttribute(attr.name)); Array.from(newBody.attributes).forEach(attr => document.body.setAttribute(attr.name, attr.value)); } targetElement.innerHTML = e.state.fstHtml; const scripts = targetElement.querySelectorAll(\'script\'); scripts.forEach(oldScript => { if (oldScript.id === \'fst-spa-agent\' || oldScript.hasAttribute(\'data-fst-ignore\')) return; const newScript = document.createElement(\'script\'); Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value)); newScript.appendChild(document.createTextNode(oldScript.innerHTML)); oldScript.parentNode.replaceChild(newScript, oldScript); }); document.dispatchEvent(new Event(\'fst:load\')); } else { window.location.reload(); } } else { window.location.reload(); } }); if (!window.history.state) { const bodyAttrs = Array.from(document.body.attributes).map(a => `${a.name}="${a.value}"`).join(\' \'); window.history.replaceState({ fstHtml: document.body.innerHTML, fstTarget: \'body\', fstBodyAttrs: bodyAttrs }, \'\', window.location.href); } document.dispatchEvent(new Event(\'fst:load\')); document.addEventListener(\'submit\', async function(e) { if (e.defaultPrevented) return; const form = e.target; if (form.hasAttribute(\'data-fst-no-spa\') || form.classList.contains(\'no-spa\')) return; e.preventDefault(); const reqHeader = document.querySelector(\'script#fst-spa-agent\')?.getAttribute(\'data-req-header\') || \'X-FST-Request\'; const targetHeader = document.querySelector(\'script#fst-spa-agent\')?.getAttribute(\'data-target-header\') || \'X-FST-Target\'; const targetSelector = form.getAttribute(\'data-fst-target\') || \'body\'; const isHistoryOptOut = form.getAttribute(\'data-fst-history\') === \'false\'; const targetElement = document.querySelector(targetSelector); const indicator = _fstGetIndicatorClass(form); if (targetElement) targetElement.classList.add(...indicator.split(\' \')); try { const method = (form.getAttribute(\'method\') || \'GET\').toUpperCase(); const action = form.getAttribute(\'action\') || window.location.href; const formData = new FormData(form); const headers = { [reqHeader]: \'true\', [targetHeader]: targetSelector }; let fetchOptions = { method, headers }; let finalUrl = action; if (method === \'GET\') { const params = new URLSearchParams(formData); finalUrl = action.includes(\'?\') ? `${action}&${params.toString()}` : `${action}?${params.toString()}`; } else { fetchOptions.body = formData; } const response = await fetch(finalUrl, fetchOptions); const redirectUrl = response.headers.get(\'X-FST-Redirect\'); if (redirectUrl) { if (targetElement) targetElement.classList.remove(...indicator.split(\' \')); await _fstNavigate(redirectUrl, targetSelector, !isHistoryOptOut); return; } if (response.redirected) { window.location.href = response.url; return; } if (!response.ok && response.status !== 400 && response.status !== 422) { const errorHtml = await response.text(); document.open(); document.write(errorHtml); document.close(); return; } const html = await response.text(); const newTitle = html.match(/<title[^>]*>([\\s\\S]*?)<\\/title>/i); if (newTitle) document.title = newTitle[1]; const bodyAttrs = response.headers.get(\'X-FST-Body-Attrs\'); if (bodyAttrs !== null && targetSelector === \'body\') { const parser = new DOMParser(); const doc = parser.parseFromString(`<div ${bodyAttrs}></div>`, \'text/html\'); const newBody = doc.body.firstChild; Array.from(document.body.attributes).forEach(attr => document.body.removeAttribute(attr.name)); Array.from(newBody.attributes).forEach(attr => document.body.setAttribute(attr.name, attr.value)); } if (!targetElement) throw new Error(\'Target not found\'); document.dispatchEvent(new Event(\'fst:unload\')); targetElement.innerHTML = html; if (!isHistoryOptOut && method === \'GET\') { window.history.pushState({ fstHtml: html, fstTarget: targetSelector, fstBodyAttrs: bodyAttrs }, \'\', finalUrl); } const scripts = targetElement.querySelectorAll(\'script\'); scripts.forEach(oldScript => { if (oldScript.id === \'fst-spa-agent\' || oldScript.hasAttribute(\'data-fst-ignore\')) return; const newScript = document.createElement(\'script\'); Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value)); newScript.appendChild(document.createTextNode(oldScript.innerHTML)); oldScript.parentNode.replaceChild(newScript, oldScript); }); document.dispatchEvent(new Event(\'fst:load\')); } catch (err) { window.location.reload(); } finally { if (targetElement) targetElement.classList.remove(...indicator.split(\' \')); } });');


// FILE: core.php
if (session_status() === PHP_SESSION_NONE) { 
    $is_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
                (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    
    session_set_cookie_params([
        'lifetime' => 0, 
        'path' => '/',
        'domain' => '',
        'secure' => $is_https,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start(); 
}
define('FST_VERSION', '0.2.0');
define('FST_DOCS_URL', 'https://raw.githubusercontent.com/milio48/fullstuck/refs/heads/main/docs/v' . FST_VERSION . '.md');
if (!defined('FST_ROOT_DIR')) {
    $root = __DIR__;
    if (php_sapi_name() === 'cli-server') {
        $root = $_SERVER['DOCUMENT_ROOT'];
    } elseif (php_sapi_name() === 'cli') {
        $root = getcwd();
    }
    define('FST_ROOT_DIR', realpath($root) ?: $root);
}
define('FST_CONFIG_FILE', FST_ROOT_DIR . DIRECTORY_SEPARATOR . 'fullstuck.json');


if (php_sapi_name() === 'cli') {
    global $argv;
    if (isset($argv[1]) && $argv[1] === 'init') {
        if (file_exists(FST_CONFIG_FILE)) {
            echo "Error: fullstuck.json already exists. Delete it first if you want to re-initialize.\n";
            exit(1);
        }
        fst_handle_installation();
        exit(0);
    }
}

if (!file_exists(FST_CONFIG_FILE)) {
    if (php_sapi_name() === 'cli') {
        echo "Error: fullstuck.json not found. Run 'php fullstuck.php init' with arguments to initialize, or access via web browser.\n";
        exit(1);
    }
    fst_handle_installation();
    die();
}

function fst_app($key = null, $value = null) {
    static $state = [
        'config' => null,
        'pdo' => null,
        'routes' => [],
        'route_prefix' => '',
        'group_middleware' => [],
        'route_found' => false,
    ];

    if ($key === null) return $state;
    if ($value !== null) $state[$key] = $value;
    return $state[$key] ?? null;
}

function fst_is_safe_to_debug() {
    if (!fst_is_dev()) return false; 
    $is_localhost = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']);
    $is_admin_logged_in = !empty($_SESSION['fst_admin_logged_in']);
    return $is_localhost || $is_admin_logged_in;
}

$config_content = @file_get_contents(FST_CONFIG_FILE);
$decoded_config = $config_content ? json_decode($config_content, true) : null;
if (fst_app('config') === null) fst_app('config', $decoded_config);
if (fst_app('routes') === null) fst_app('routes', []);
if (fst_app('route_prefix') === null) fst_app('route_prefix', '');
if (fst_app('route_found') === null) fst_app('route_found', false);

if ($decoded_config === null && file_exists(FST_CONFIG_FILE)) {
    if (function_exists('fst_abort')) fst_abort(500, "Failed to decode `fullstuck.json`. Check for syntax errors.");
    else die("Error: Failed to decode `fullstuck.json`. Check for syntax errors.");
}

if (fst_is_dev()) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}
ini_set('display_errors', '0'); 

function _fst_error_handler($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) return false;
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

function _fst_exception_handler($e) {
    while (ob_get_level() > 0) { ob_end_clean(); } 
    http_response_code(500);
    
    if (!fst_is_dev() || !fst_is_safe_to_debug()) {
        $log_message = "[" . date('Y-m-d H:i:s') . "] " . get_class($e) . ": " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "\n";
        @file_put_contents(FST_ROOT_DIR . '/.fst-error.log', $log_message, FILE_APPEND);
        error_log($log_message); 
        
        if (function_exists('fst_abort')) { fst_abort(500, "Internal Server Error. Please check .fst-error.log for details."); } 
        else { die("Internal Server Error."); }
    }
    
    
    $message = htmlspecialchars($e->getMessage());
    $file = htmlspecialchars($e->getFile());
    $line = $e->getLine();
    $trace = htmlspecialchars($e->getTraceAsString());
    
    $code_snippet = '';
    if (file_exists($e->getFile())) {
        $lines = file($e->getFile());
        $start = max(0, $line - 5);
        $end = min(count($lines), $line + 4);
        for ($i = $start; $i < $end; $i++) {
            $current_line = $i + 1;
            $line_content = htmlspecialchars($lines[$i]);
            $highlight = ($current_line === $line) ? 'background-color: rgba(220, 53, 69, 0.4); border-left: 3px solid #dc3545;' : 'border-left: 3px solid transparent;';
            $code_snippet .= "<div style='{$highlight} padding: 2px 5px;'><strong>" . str_pad($current_line, 4, ' ', STR_PAD_LEFT) . " |</strong> {$line_content}</div>";
        }
    }

    $class_name = get_class($e);

    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Exception: {$message}</title>
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 20px; }
            .container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 8px solid #dc3545; }
            h1 { color: #dc3545; margin-top: 0; font-size: 24px; word-break: break-all; line-height: 1.3;}
            .badge { display: inline-block; background: #dc3545; color: white; padding: 4px 10px; border-radius: 4px; font-size: 13px; font-weight: bold; margin-bottom: 15px; text-transform: uppercase;}
            .meta { background: #f1f3f5; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-family: monospace; font-size: 14px; border: 1px solid #e9ecef;}
            .meta strong { color: #555; display: inline-block; width: 60px;}
            .code-preview { background: #272822; color: #f8f8f2; padding: 15px 0; border-radius: 5px; overflow-x: auto; font-family: "Courier New", Courier, monospace; font-size: 14px; line-height: 1.5; margin-bottom: 20px;}
            .code-preview div { white-space: pre; }
            h3 { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 30px; font-size: 18px;}
            pre.trace { background: #f1f3f5; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 13px; line-height: 1.6; border: 1px solid #e9ecef;}
        </style>
    </head>
    <body>
        <div class="container">
            <span class="badge">{$class_name}</span>
            <h1>{$message}</h1>
            <div class="meta">
                <strong>File:</strong> {$file}<br>
                <strong>Line:</strong> {$line}
            </div>
            
            <h3>Code Snippet</h3>
            <div class="code-preview">{$code_snippet}</div>
            
            <h3>Stack Trace</h3>
            <pre class="trace">{$trace}</pre>
        </div>
    </body>
    </html>
HTML;
    die();
}

function _fst_fatal_error_handler() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING])) {
        _fst_exception_handler(new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']));
    }
}

set_error_handler('_fst_error_handler');
set_exception_handler('_fst_exception_handler');
register_shutdown_function('_fst_fatal_error_handler');

function fst_is_dev() {
    $fst_config = fst_app('config');
    return ($fst_config['environment'] ?? 'production') === 'development';
}

function _fst_interpolate_env($val) {
    if (is_string($val) && strpos($val, '${') !== false) {
        return preg_replace_callback('/\$\{([A-Za-z0-9_]+)\}/', function($m) {
            $env = getenv($m[1]);
            if ($env === false) fst_abort(500, "Configuration Error: Environment variable '{$m[1]}' is missing.");
            return $env;
        }, $val);
    }
    if (is_array($val)) {
        foreach ($val as $k => $v) $val[$k] = _fst_interpolate_env($v);
    }
    return $val;
}

function fst_config($key = null, $default = null) {
    $fst_config = fst_app('config');
    if ($key === null) return _fst_interpolate_env($fst_config);
    $keys = explode('.', $key);
    $val = $fst_config;
    foreach ($keys as $k) {
        if (is_array($val) && array_key_exists($k, $val)) {
            $val = $val[$k];
        } else {
            return _fst_interpolate_env($default);
        }
    }
    return _fst_interpolate_env($val);
}

function fst_is_spa(): bool {
    $header_name = fst_config('spa.header_request', 'X-FST-Request');
    $req_header = 'HTTP_' . str_replace('-', '_', strtoupper($header_name));
    return isset($_SERVER[$req_header]);
}

function fst_spa_target(): string {
    $header_name = fst_config('spa.header_target', 'X-FST-Target');
    $target_header = 'HTTP_' . str_replace('-', '_', strtoupper($header_name));
    return $_SERVER[$target_header] ?? 'body';
}

function fst_spa_page() {
    fst_app('inject_spa_manual', true);
}

function fst_extract_html_fragment($html, $selector = 'body') {
    if (empty(trim($html))) return '';

    
    
    
    $singleton_tags = ['body', 'main'];
    if (!str_starts_with($selector, '#') && !str_starts_with($selector, '.')) {
        $tag = strtolower($selector);
        if (in_array($tag, $singleton_tags)) {
            
            if (preg_match('/<' . $tag . '[^>]*>(.*?)<\/' . $tag . '>/is', $html, $m)) {
                return $m[1];
            }
        }
        
    }

    
    
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    
    
    if (strpos($selector, ':') !== false || strpos($selector, '+') !== false || strpos($selector, '~') !== false) {
        return $html; 
    }

    $paths = [];
    foreach (explode(',', $selector) as $sel) {
        $sel = trim($sel);
        $sel = preg_replace('/\s*>\s*/', '/', $sel); 
        $sel = preg_replace('/\s+/', '//', $sel); 
        $sel = preg_replace('/#([\w\-]+)/', '[@id="$1"]', $sel); 
        $sel = preg_replace('/\.([\w\-]+)/', '[contains(concat(" ", normalize-space(@class), " "), " $1 ")]', $sel); 
        
        
        $sel = preg_replace('/\[([\w\-]+)=([\'"]?.*?[\'"]?)\]/', '[@$1=$2]', $sel);
        
        $sel = preg_replace('/\[([\w\-]+)\]/', '[@$1]', $sel);
        
        $sel = preg_replace('/(^|\/|\|)(\[)/', '$1*$2', $sel);
        
        
        if (!str_starts_with($sel, '/')) {
            $sel = '//' . $sel;
        }
        
        $paths[] = $sel;
    }
    $xpath_query = implode(' | ', $paths);

    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query($xpath_query);
    if ($nodes && $nodes->length > 0) {
        $inner_html = '';
        foreach ($nodes->item(0)->childNodes as $child) {
            $inner_html .= $dom->saveHTML($child);
        }
        return $inner_html;
    }
    return $html;
}

function fst_register_plugin($id, $config) {
    $plugins = fst_app('plugins') ?? [];
    $plugins[$id] = $config;
    fst_app('plugins', $plugins);
}

// FILE: database.php
function fst_db_quote_ident($name, $connection = null) {
    $conn_name = $connection ?? fst_config('database.default', 'main');
    $db_config = fst_config("database.connections.{$conn_name}");
    $driver = strtolower($db_config['driver'] ?? 'sqlite');
    $q = ($driver === 'pgsql') ? '"' : '`';
    
    
    if (str_contains($name, '.')) {
        $parts = explode('.', $name);
        $quoted_parts = array_map(function($p) use ($q) {
            return $q . str_replace($q, $q . $q, $p) . $q;
        }, $parts);
        return implode('.', $quoted_parts);
    }
    return $q . str_replace($q, $q . $q, $name) . $q;
}


function _fst_sanitize_order_by($order_by, $connection = null) {
    $parts = array_map('trim', explode(',', $order_by));
    $safe_parts = [];
    foreach ($parts as $part) {
        
        if (preg_match('/^([a-zA-Z_][a-zA-Z0-9_.]*)(\s+(ASC|DESC))?$/i', $part, $m)) {
            $safe_parts[] = fst_db_quote_ident($m[1], $connection) . (isset($m[3]) ? ' ' . strtoupper($m[3]) : '');
        }
    }
    return !empty($safe_parts) ? implode(', ', $safe_parts) : null;
}

function _fst_get_pdo($connection = null) {
    global $fst_pdo_pool;
    if (!isset($fst_pdo_pool)) $fst_pdo_pool = [];
    
    $conn_name = $connection ?? fst_config('database.default', 'main');
    
    if (!isset($fst_pdo_pool[$conn_name])) {
        $db_config = fst_config("database.connections.{$conn_name}");
        if (!$db_config) fst_abort(500, "Database connection '{$conn_name}' is not configured.");
        
        $driver = strtolower($db_config['driver'] ?? 'none');
        if ($driver === 'none') fst_abort(500, "Database is disabled for connection '{$conn_name}'.");
        
        try {
            $dsn = '';
            if ($driver === 'sqlite') {
                $path = $db_config['database_path'] ?? 'database.sqlite';
                $dsn = 'sqlite:' . FST_ROOT_DIR . '/' . ltrim($path, '/');
            } else if ($driver === 'mysql' || $driver === 'pgsql') {
                $host = $db_config['host'] ?? '127.0.0.1';
                $port = !empty($db_config['port']) ? ';port=' . $db_config['port'] : '';
                $dbname = $db_config['dbname'] ?? '';
                $dsn = "{$driver}:host={$host}{$port};dbname={$dbname}";
            } else {
                fst_abort(500, "Unsupported DB driver: {$driver}");
            }
            
            $user = $db_config['username'] ?? null;
            $pass = $db_config['password'] ?? null;
            $pdo_instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            
            
            if ($driver === 'sqlite') {
                $pdo_instance->exec('PRAGMA journal_mode = WAL;');
                $pdo_instance->exec('PRAGMA busy_timeout = 5000;');
                $pdo_instance->exec('PRAGMA foreign_keys = ON;');
            }
            
            $fst_pdo_pool[$conn_name] = $pdo_instance;
        } catch (PDOException $e) {
            fst_abort(500, "Database Connection Failed [{$conn_name}]: " . (fst_is_safe_to_debug() ? $e->getMessage() : 'Error.'));
        }
    }
    
    return $fst_pdo_pool[$conn_name];
}

function fst_db_begin($connection = null) {
    return _fst_get_pdo($connection)->beginTransaction();
}

function fst_db_commit($connection = null) {
    return _fst_get_pdo($connection)->commit();
}

function fst_db_rollback($connection = null) {
    return _fst_get_pdo($connection)->rollBack();
}

function fst_db($mode, $sql, $params = [], $connection = null) {
    $pdo = _fst_get_pdo($connection);
    
    
    foreach ($params as $k => $v) {
        if (is_array($v) || is_object($v)) {
            throw new Exception("Database Error: Parameter bind [{$k}] tidak boleh berupa array atau object.");
        }
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $normalizedSql = strtoupper(trim($sql));
    $isInsert = strpos($normalizedSql, 'INSERT') === 0;
    
    if (strtoupper($mode) === 'EXEC') {
        return [
            'affected_rows' => $stmt->rowCount(),
            'last_id' => $isInsert ? $pdo->lastInsertId() : null,
            'query_type' => strtok($normalizedSql, ' '),
            'success' => true
        ];
    }
    
    return match(strtoupper($mode)) { 
        'ROW' => ($r = $stmt->fetch()) !== false ? $r : null, 
        'SCALAR', 'ONE' => ($r = $stmt->fetchColumn()) !== false ? $r : null, 
        'ALL' => $stmt->fetchAll(), 
        default => $stmt->fetchAll() 
    };
}

function fst_db_select($table, $conditions = [], $options = []) {
    $conn = $options['connection'] ?? null;
    $columns = $options['select'] ?? '*';
    $t = fst_db_quote_ident($table, $conn);
    $sql = "SELECT {$columns} FROM {$t}";
    $params = [];
    if (!empty($conditions)) {
        $where = [];
        foreach ($conditions as $k => $v) {
            $where[] = fst_db_quote_ident($k, $conn) . " = ?";
            $params[] = $v;
        }
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    if (isset($options['order_by'])) {
        $safe_order = _fst_sanitize_order_by($options['order_by'], $conn);
        if ($safe_order) $sql .= " ORDER BY " . $safe_order;
    }
    if (isset($options['limit'])) $sql .= " LIMIT " . (int)$options['limit'];
    if (isset($options['offset'])) $sql .= " OFFSET " . (int)$options['offset'];
    
    $mode = $options['mode'] ?? 'ALL';
    return fst_db($mode, $sql, $params, $conn);
}

function fst_db_insert($table, $data, $options = []) {
    if (empty($data)) return false;
    $conn = $options['connection'] ?? null;
    $t = fst_db_quote_ident($table, $conn);
    $columns = array_map(fn($k) => fst_db_quote_ident($k, $conn), array_keys($data));
    $placeholders = array_fill(0, count($data), '?');
    $sql = "INSERT INTO {$t} (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
    $res = fst_db('EXEC', $sql, array_values($data), $conn);
    return $res['last_id'];
}

function fst_db_update($table, $data, $conditions = [], $options = []) {
    if (empty($conditions)) throw new Exception("Database Error: UPDATE statement requires conditions to prevent accidental mass updates."); 
    if (empty($data)) return false;
    $conn = $options['connection'] ?? null;
    $t = fst_db_quote_ident($table, $conn);
    $set = [];
    $params = [];
    foreach ($data as $k => $v) {
        $set[] = fst_db_quote_ident($k, $conn) . " = ?";
        $params[] = $v;
    }
    $sql = "UPDATE {$t} SET " . implode(", ", $set);
    
    if (!empty($conditions)) {
        $where = [];
        foreach ($conditions as $k => $v) {
            $where[] = fst_db_quote_ident($k, $conn) . " = ?";
            $params[] = $v;
        }
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $res = fst_db('EXEC', $sql, $params, $conn);
    return $res['affected_rows'];
}

function fst_db_delete($table, $conditions, $options = []) {
    if (empty($conditions)) throw new Exception("Database Error: DELETE statement requires conditions to prevent accidental mass deletion."); 
    $conn = $options['connection'] ?? null;
    $t = fst_db_quote_ident($table, $conn);
    $where = [];
    $params = [];
    foreach ($conditions as $k => $v) {
        $where[] = fst_db_quote_ident($k, $conn) . " = ?";
        $params[] = $v;
    }
    $sql = "DELETE FROM {$t} WHERE " . implode(" AND ", $where);
    $res = fst_db('EXEC', $sql, $params, $conn);
    return $res['affected_rows'];
}

function fst_db_row($table, $conditions = [], $options = []) {
    $options['limit'] = 1;
    $options['mode'] = 'ROW';
    return fst_db_select($table, $conditions, $options);
}

function fst_db_exists($table, $conditions = [], $options = []) {
    $options['select'] = '1';
    $row = fst_db_row($table, $conditions, $options);
    return !empty($row);
}

// FILE: router.php
function fst_abort($code, $message = '') {
    $fst_config = fst_app('config');
    http_response_code($code);
    $handler_path = $fst_config['routing']['error_handlers'][$code] ?? null;
    if ($handler_path) {
        if (preg_match('/\.php$|\.html$/', $handler_path)) {
            if (file_exists(FST_ROOT_DIR . '/' . $handler_path)) {
                if (function_exists('fst_view')) fst_view($handler_path, ['error_code' => $code, 'error_message' => $message]);
                else require FST_ROOT_DIR . '/' . $handler_path;
                die();
            }
        } else {
            echo htmlspecialchars($handler_path); die();
        }
    }
    $default_titles = [404 => 'Not Found', 403 => 'Forbidden', 405 => 'Method Not Allowed', 500 => 'Internal Server Error'];
    $title = $default_titles[$code] ?? 'Error';
    $message_safe = htmlspecialchars($message);
    $html = <<<HTML
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Error {$code}</title>
<style>body{font-family: sans-serif; text-align: center; padding-top: 50px;}</style>
</head><body><h1>Error {$code}: {$title}</h1><p>{$message_safe}</p></body></html>
HTML;
    echo $html; die();
}

function fst_route($method, $path, $callback, $middleware = []) {
    $fst_config = fst_app('config');
    $fst_routes = fst_app('routes');
    $fst_route_prefix = fst_app('route_prefix');
    $fst_group_middleware = fst_app('group_middleware');
    
    $full_original_path = $fst_route_prefix . $path;
    if ($full_original_path !== '/' && str_ends_with($full_original_path, '/')) {
        $full_original_path = rtrim($full_original_path, '/');
    }
     if (!str_starts_with($full_original_path, '/')) {
        $full_original_path = '/' . $full_original_path;
    }

    $path_for_regex = $full_original_path;

    $shortcuts = $fst_config['routing']['regex_shortcuts'] ?? ['i'=>'([0-9]+)','a'=>'([a-zA-Z0-9]+)','s'=>'([a-zA-Z0-9\-]+)','any'=>'([^/]+)'];
    $default_regex = $shortcuts['any'] ?? '([^/]+)';

    
    $final_pattern = preg_replace_callback(
        '/\{([a-zA-Z0-9_]+)(?::([a-z]))?\}\?/',
        function ($matches) use ($shortcuts, $default_regex) {
             $type = $matches[2] ?? 'any';
             $regex = $shortcuts[$type] ?? $default_regex;
             $regex = str_starts_with($regex, '(') ? $regex : '(' . $regex . ')';
             return "(?:/" . $regex . ")?";
        },
        $path_for_regex);
    
    
    $final_pattern = preg_replace_callback(
        '/\{([a-zA-Z0-9_]+)(?::([a-z]))?\}/',
        function ($matches) use ($shortcuts, $default_regex) {
             $type = $matches[2] ?? 'any';
             $regex = $shortcuts[$type] ?? $default_regex;
             return str_starts_with($regex, '(') ? $regex : '(' . $regex . ')';
        },
        $final_pattern);

    $final_pattern = '#^' . str_replace('/', '\/', $final_pattern) . '$#';

    
    foreach ($fst_routes[$method] ?? [] as $existing) {
        if ($existing[0] === $method && $existing[3] === $full_original_path) {
            fst_abort(500, "Duplicate route detected: [{$method}] {$full_original_path}. Each route must be unique.");
        }
    }

    if (!is_array($middleware)) $middleware = [$middleware];
    $combined_middleware = array_merge($fst_group_middleware ?? [], $middleware);

    if (!isset($fst_routes[$method])) $fst_routes[$method] = [];
    $fst_routes[$method][] = [$method, $final_pattern, $callback, $full_original_path, $combined_middleware];
    fst_app('routes', $fst_routes);
}

function fst_get($path, $callback, $middleware = []) { fst_route('GET', $path, $callback, $middleware); }
function fst_post($path, $callback, $middleware = []) { fst_route('POST', $path, $callback, $middleware); }
function fst_put($path, $callback, $middleware = []) { fst_route('PUT', $path, $callback, $middleware); }
function fst_patch($path, $callback, $middleware = []) { fst_route('PATCH', $path, $callback, $middleware); }
function fst_delete($path, $callback, $middleware = []) { fst_route('DELETE', $path, $callback, $middleware); }
function fst_any($path, $callback, $middleware = []) { fst_route('ANY', $path, $callback, $middleware); }

function fst_group($prefix, $callback, $middleware = []) {
    $parent_prefix = fst_app('route_prefix');
    $parent_middleware = fst_app('group_middleware') ?? [];
    
    $trimmed_prefix = trim($prefix, '/');
    if ($trimmed_prefix === '') {
        $fst_route_prefix = $parent_prefix;
    } else {
        $fst_route_prefix = rtrim($parent_prefix, '/') . '/' . $trimmed_prefix;
    }
    fst_app('route_prefix', $fst_route_prefix);
    
    if (!is_array($middleware)) $middleware = [$middleware];
    $fst_group_middleware = array_merge($parent_middleware, $middleware);
    fst_app('group_middleware', $fst_group_middleware);
    
    call_user_func($callback);
    
    fst_app('route_prefix', $parent_prefix);
    fst_app('group_middleware', $parent_middleware);
}

function _fst_get_request_paths() {
    $fst_config = fst_app('config');
    $request_uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    $base_path_config = $fst_config['routing']['base_path'] ?? '/';
    if ($base_path_config !== '/' && str_starts_with($request_uri_path, $base_path_config)) {
        $request_uri_path = substr($request_uri_path, strlen($base_path_config));
    }
    if (!str_starts_with($request_uri_path, '/')) $request_uri_path = '/' . $request_uri_path;
    $absolute_path = FST_ROOT_DIR . $request_uri_path;
    
    return [
        'uri_path' => $request_uri_path,
        'absolute_path' => $absolute_path
    ];
}

function _fst_is_protected_file($absolute_path) {
    
    $normalized_abs_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $absolute_path);
    $normalized_file_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, FST_ROOT_DIR . '/fullstuck.php');
    $normalized_config_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, FST_CONFIG_FILE);

    return ($normalized_abs_path === $normalized_file_path || $normalized_abs_path === $normalized_config_path);
}

function _fst_serve_static_asset($request_uri_path, $absolute_path) {
    $fst_config = fst_app('config');
    $public_folders = $fst_config['routing']['public_folders'] ?? [];
    foreach ($public_folders as $folder) {
        $clean_folder = trim($folder, '/');
        if (str_starts_with(ltrim($request_uri_path, '/'), $clean_folder . '/')) {
            if (is_file($absolute_path)) {
                fst_serve_static_file($absolute_path); 
                die(); 
            }
            break; 
        }
    }
    return false;
}

function _fst_match_static_routes() {
    $fst_routes = fst_app('routes');
    $uri = fst_uri();
    $method = fst_method();
    
    
    $routes_to_check = array_merge($fst_routes[$method] ?? [], $fst_routes['ANY'] ?? []);
    
    foreach ($routes_to_check as $route) {
        list($route_method, $pattern, $callback) = $route;
        if ($route_method !== 'ANY' && $route_method !== $method) continue;
        
        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); 
            
            $middleware_list = $route[4] ?? [];

            
            $next = function() use ($callback, $matches) {
                return call_user_func_array($callback, $matches);
            };

            
            $middleware_list = array_reverse($middleware_list);

            
            foreach ($middleware_list as $mw) {
                if (is_callable($mw)) {
                    $current_next = $next;
                    
                    $next = function() use ($mw, $current_next) {
                        $called = false;
                        $next_wrapper = function() use ($current_next, &$called) {
                            $called = true;
                            return $current_next();
                        };

                        
                        $result = call_user_func($mw, $next_wrapper);
                        
                        
                        
                        if ($result === false) {
                            fst_abort(403, 'Forbidden by Middleware');
                        }
                        
                        
                        if (!$called && $result === null) {
                            fst_abort(500, "Middleware Logic Error: Middleware did not explicitly return a value or call \$next(). Security check failed."); 
                        }
                        
                        return $result;
                    };
                }
            }

            
            $next();
            
            fst_app('route_found', true); 
            return true; 
        }
    }
    return false;
}

function fst_run() {
    
    fst_app('route_found', false); 

    
    if (!headers_sent()) {
        header('X-Frame-Options: SAMEORIGIN');
        header('X-Content-Type-Options: nosniff');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }

    ob_start();
    $handled = false;
    
    $req = _fst_get_request_paths(); 
    if (_fst_is_protected_file($req['absolute_path'])) {
        fst_abort(404);
        $handled = true;
    }
    if (!$handled) {
        if (_fst_serve_static_asset($req['uri_path'], $req['absolute_path'])) {
            $handled = true;
        }
    }
    if (!$handled) {
        if (_fst_match_static_routes()) {
            $handled = true;
        }
    }
    
    if (!$handled && !fst_app('route_found')) {
        fst_abort(404);
    }
    
    $output = ob_get_clean();
    if ($output === false) $output = ''; 

    
    $spa_mode = fst_config('spa.enabled', false);
    $should_inject_spa = false;

    if ($spa_mode === true || $spa_mode === '1') {
        $should_inject_spa = true;
    } elseif ($spa_mode === 'manual' && fst_app('inject_spa_manual') === true) {
        $should_inject_spa = true;
    }

    
    $req = _fst_get_request_paths(); 
    $admin_url = fst_config('admin.page_url', '/stuck');
    if ($req['uri_path'] === $admin_url || str_starts_with($req['uri_path'], rtrim($admin_url, '/') . '/')) {
        $should_inject_spa = false;
    }

    if (fst_is_spa()) {
        $target = fst_spa_target();
        
        
        $title_tag = '';
        if (preg_match('/<title[^>]*>.*?<\/title>/is', $output, $matches)) {
            $title_tag = $matches[0];
        }

        
        if ($target === 'body' && preg_match('/<body([^>]*)>/is', $output, $matches)) {
            header('X-FST-Body-Attrs: ' . trim($matches[1]));
        }

        
        $output = fst_extract_html_fragment($output, $target); 

        
        if (!empty($title_tag)) {
            $output = $title_tag . "\n" . $output;
        }
    } 
    else if ($should_inject_spa) {
        $script_id = fst_config('spa.script_id', 'fst-spa-agent');
        $req_header = fst_config('spa.header_request', 'X-FST-Request');
        $target_header = fst_config('spa.header_target', 'X-FST-Target');
        $indicator_class = fst_config('spa.indicator_class', 'fst-loading');
        $inject_id = $script_id ? 'id="'.$script_id.'" data-req-header="'.$req_header.'" data-target-header="'.$target_header.'" data-indicator-class="'.$indicator_class.'"' : '';
        $script_tag = "<script {$inject_id}>\n" . (defined('FST_SPA_JS_CODE') ? FST_SPA_JS_CODE : '') . "\n</script>";
        
        if (stripos($output, '</body>') !== false) {
            $output = str_ireplace('</body>', $script_tag . "\n</body>", $output);
        } else {
            $output .= "\n" . $script_tag;
        }
    }

    echo $output;
}

// FILE: http.php
function fst_uri() {
    $fst_config = fst_app('config');
    $base_path = $fst_config['routing']['base_path'] ?? '/';
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    if ($base_path !== '/' && str_starts_with($uri, $base_path)) {
        $uri = substr($uri, strlen($base_path));
    }
    if (!str_starts_with($uri, '/')) $uri = '/' . $uri;
    if ($uri !== '/' && str_ends_with($uri, '/')) $uri = rtrim($uri, '/');
    return $uri ?: '/';
}
function fst_method() { return $_SERVER['REQUEST_METHOD']; }
function _fst_parsed_body() {
    static $cache = null;
    if ($cache !== null) return $cache;
    $cache = array_merge($_GET, $_POST);
    if (empty($_POST)) {
        $raw = file_get_contents('php://input');
        if (!empty($raw)) {
            $json = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                $cache = array_merge($cache, $json);
            } else {
                
                parse_str($raw, $parsed_vars);
                if (is_array($parsed_vars)) {
                    $cache = array_merge($cache, $parsed_vars);
                }
            }
        }
    }
    return $cache;
}
function fst_input($key, $default = null) { $data = _fst_parsed_body(); return $data[$key] ?? $default; }
function fst_request() { return _fst_parsed_body(); }
function fst_file($key) { return isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK ? $_FILES[$key] : null; }
function fst_escape($str) { return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8'); }
function e($str) { return fst_escape($str); }

function fst_json($data, $status = 200) { fst_status_code($status); header('Content-Type: application/json'); echo json_encode($data); die(); }
function fst_text($string, $status = 200) { fst_status_code($status); header('Content-Type: text/plain'); echo $string; die(); }
function fst_redirect($url, $code = 302, $allow_external = false) {
    $fst_config = fst_app('config');
    $base_path = $fst_config['routing']['base_path'] ?? '/';
    
    
    if (str_starts_with($url, '//')) {
        fst_abort(403, 'Protocol-relative redirect is not allowed.');
    }

    if (preg_match('/^https?:\/\//', $url)) {
        if (!$allow_external) {
            $url_host = parse_url($url, PHP_URL_HOST);
            $self_host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
            $self_host = preg_replace('/:\d+$/', '', $self_host);
            if ($url_host !== null && strtolower($url_host) !== strtolower($self_host)) {
                fst_abort(403, 'Redirect to external domain is not allowed. Use fst_redirect($url, 302, true) to allow.');
            }
        }
    } else {
        $url = '/' . ltrim($url, '/');
        $url = rtrim($base_path, '/') . $url;
    }
    
    if (fst_is_spa()) {
        header("X-FST-Redirect: " . $url);
        die();
    }
    header("Location: " . $url, true, $code);
    die();
}
function fst_status_code($code) { http_response_code($code); }

function fst_session_set($key, $value) { $_SESSION[$key] = $value; }
function fst_session_get($key, $default = null) { return $_SESSION[$key] ?? $default; }
function fst_session_forget($key) { unset($_SESSION[$key]); }
function fst_flash_set($key, $message) { $_SESSION['_flash'][$key] = $message; }
function fst_flash_has($key) { return isset($_SESSION['_flash'][$key]); }
function fst_flash_get($key, $default = null) { $message = $_SESSION['_flash'][$key] ?? $default; unset($_SESSION['_flash'][$key]); return $message; }

function fst_csrf_token() { if (empty($_SESSION['_csrf_token'])) $_SESSION['_csrf_token'] = bin2hex(random_bytes(32)); return $_SESSION['_csrf_token']; }
function fst_csrf_field() { return '<input type="hidden" name="_token" value="' . fst_csrf_token() . '">'; }
function fst_csrf_check() {
    $data = fst_request(); 
    $submitted_token = $data['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
    if (!$submitted_token || !hash_equals(fst_csrf_token(), $submitted_token)) fst_abort(403, 'Invalid CSRF token.');
}

function fst_upload($key, $folder, $options = []) {
    if (!isset($_FILES[$key])) return ['success' => false, 'error' => 'No file uploaded.', 'path' => null];
    
    $files_input = $_FILES[$key];
    $is_multiple = is_array($files_input['name']);
    
    $process_single = function($name, $tmp_name, $size, $error) use ($folder, $options) {
        if ($error !== UPLOAD_ERR_OK) return ['success' => false, 'error' => 'Upload error code: ' . $error, 'path' => null];
        
        $max_size_kb = $options['max_size'] ?? 2048;
        if ($size > $max_size_kb * 1024) return ['success' => false, 'error' => "File is too large (max {$max_size_kb} KB).", 'path' => null];
        
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!empty($options['allowed_types']) && !in_array($ext, $options['allowed_types'])) {
            return ['success' => false, 'error' => "Extension `{$ext}` is not allowed.", 'path' => null];
        }
        
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $actual_mime = finfo_file($finfo, $tmp_name);
            finfo_close($finfo);
            $blocked_mimes = ['application/x-httpd-php', 'application/x-httpd-php-source', 'application/php', 'text/x-php', 'text/php'];
            if (in_array(strtolower($actual_mime), $blocked_mimes)) {
                return ['success' => false, 'error' => "Security Error: Malicious file signature detected.", 'path' => null];
            }
            if (!empty($options['allowed_mimes']) && !in_array($actual_mime, $options['allowed_mimes'])) {
                return ['success' => false, 'error' => "Invalid MIME type: " . $actual_mime, 'path' => null];
            }
        }
        
        $safe_basename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($name, ".".$ext));
        $filename = $safe_basename . '-' . uniqid() . '.' . $ext;
        $destination_folder = rtrim(FST_ROOT_DIR . '/' . trim($folder, '/'), '/');
        if (!is_dir($destination_folder) && !mkdir($destination_folder, 0755, true)) return ['success' => false, 'error' => "Failed to create upload directory.", 'path' => null];
        
        $real_destination = realpath($destination_folder);
        if (!$real_destination || !str_starts_with($real_destination, realpath(FST_ROOT_DIR))) {
            return ['success' => false, 'error' => 'Security Error: Invalid upload directory path.', 'path' => null];
        }
        
        $destination_path = $real_destination . DIRECTORY_SEPARATOR . $filename;
        $public_path = trim($folder, '/') . '/' . $filename;
        
        if (move_uploaded_file($tmp_name, $destination_path)) {
            return ['success' => true, 'path' => $public_path, 'error' => null, 'original_name' => $name];
        }
        return ['success' => false, 'error' => 'Failed to move uploaded file.', 'path' => null];
    };
    
    if (!$is_multiple) {
        return $process_single($files_input['name'], $files_input['tmp_name'], $files_input['size'], $files_input['error']);
    } else {
        $results = [];
        for ($i = 0; $i < count($files_input['name']); $i++) {
            $results[] = $process_single($files_input['name'][$i], $files_input['tmp_name'][$i], $files_input['size'][$i], $files_input['error'][$i]);
        }
        return $results;
    }
}

// FILE: view.php
function fst_view_share($key, $value = null) {
    $shared = fst_app('shared_view_data') ?? [];
    if (is_array($key)) {
        foreach ($key as $k => $v) {
            $shared[$k] = $v;
        }
    } else {
        $shared[$key] = $value;
    }
    fst_app('shared_view_data', $shared);
}

function fst_view($path, $data = []) {
    $__fst_file = realpath(FST_ROOT_DIR . '/' . $path);
    $__fst_root = realpath(FST_ROOT_DIR);
    if (!$__fst_file || !$__fst_root || !str_starts_with($__fst_file, $__fst_root)) {
        fst_abort(500, "Invalid view path.");
    }
    $ext = strtolower(pathinfo($__fst_file, PATHINFO_EXTENSION));
    if (!in_array($ext, ['php', 'html', 'htm'])) {
        fst_abort(403, "Invalid view extension. Only php, html, and htm are allowed.");
    }
    $shared = fst_app('shared_view_data') ?? [];
    extract($shared, EXTR_SKIP);
    extract($data, EXTR_SKIP);
    require $__fst_file;
}
function fst_partial($path, $data = []) { fst_view($path, $data); }

function fst_serve_static_file($file_path) {
    $fst_config = fst_app('config');
    $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    
    $mime_types = $fst_config['mime_types'] ?? [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'json' => 'application/json',
        'xml'  => 'application/xml',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'webp' => 'image/webp',
        'ico'  => 'image/x-icon',
        'svg'  => 'image/svg+xml',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf',
        'mp4'  => 'video/mp4',
        'webm' => 'video/webm',
        'html' => 'text/html',
        'txt'  => 'text/plain',
        'map'  => 'application/json'
    ];
    
    $content_type = $mime_types[$ext] ?? 'application/octet-stream';
    
    header('Content-Type: ' . $content_type);
    header('Content-Length: ' . filesize($file_path));
    header('Cache-Control: public, max-age=31536000');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    
    readfile($file_path);
}

// FILE: utility.php
function fst_dump(...$vars) {
    $fst_config = fst_app('config');
    if (!fst_is_dev()) {
        return;
    }
    echo '<pre style="background-color: #1a1a1a; color: #f0f0f0; padding: 15px; border: 1px solid #444; margin: 10px; border-radius: 5px; text-align: left; overflow-x: auto; font-family: monospace; font-size: 13px; line-height: 1.5;">';
    foreach ($vars as $var) { var_dump($var); }
    echo '</pre>';
}
function fst_dd(...$vars) { fst_dump(...$vars); die(); }


function _fst_strlen($str) {
    return function_exists('mb_strlen') ? mb_strlen($str, 'UTF-8') : strlen($str);
}

function fst_validate($data, $rules) {
    $errors = [];
    $sanitized = [];

    foreach ($rules as $field => $rule_string) {
        $value = $data[$field] ?? null;
        $rules_array = is_array($rule_string) ? $rule_string : explode('|', $rule_string);
        
        $field_valid = true;

        foreach ($rules_array as $rule) {
            $params = [];
            if (str_contains($rule, ':')) {
                list($rule_name, $param_str) = explode(':', $rule, 2);
                $params = explode(',', $param_str);
            } else {
                $rule_name = $rule;
            }

            
            if ($rule_name !== 'required' && ($value === null || trim((string)$value) === '')) {
                continue;
            }

            if ($rule_name === 'required') {
                if ($value === null || trim((string)$value) === '') {
                    $errors[$field][] = "Bidang '{$field}' wajib diisi.";
                    $field_valid = false;
                }
            } elseif ($rule_name === 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = "Bidang '{$field}' harus berupa email yang valid.";
                    $field_valid = false;
                }
            } elseif ($rule_name === 'min') {
                $min = (int)($params[0] ?? 0);
                if (_fst_strlen((string)$value) < $min) {
                    $errors[$field][] = "Bidang '{$field}' minimal {$min} karakter.";
                    $field_valid = false;
                }
            } elseif ($rule_name === 'max') {
                $max = (int)($params[0] ?? 0);
                if (_fst_strlen((string)$value) > $max) {
                    $errors[$field][] = "Bidang '{$field}' maksimal {$max} karakter.";
                    $field_valid = false;
                }
            } elseif ($rule_name === 'numeric') {
                if (!is_numeric($value)) {
                    $errors[$field][] = "Bidang '{$field}' harus berupa angka.";
                    $field_valid = false;
                }
            } elseif ($rule_name === 'in') {
                if (!in_array($value, $params)) {
                    $errors[$field][] = "Bidang '{$field}' harus salah satu dari: " . implode(', ', $params) . ".";
                    $field_valid = false;
                }
            } elseif ($rule_name === 'min_value') {
                $min_val = (float)($params[0] ?? 0);
                if (!is_numeric($value) || (float)$value < $min_val) {
                    $errors[$field][] = "Bidang '{$field}' harus bernilai minimal {$min_val}.";
                    $field_valid = false;
                }
            } elseif ($rule_name === 'max_value') {
                $max_val = (float)($params[0] ?? 0);
                if (!is_numeric($value) || (float)$value > $max_val) {
                    $errors[$field][] = "Bidang '{$field}' harus bernilai maksimal {$max_val}.";
                    $field_valid = false;
                }
            }
        }
        
        if ($value !== null) {
            $sanitized[$field] = is_string($value) ? trim($value) : $value;
        }
    }

    return [
        'valid' => count($errors) === 0,
        'errors' => $errors,
        'data' => $sanitized
    ];
}

// FILE: install.php
function fst_handle_installation() {
    $error_message = null;
    $is_cli = php_sapi_name() === 'cli';
    $is_submit = $is_cli || $_SERVER['REQUEST_METHOD'] === 'POST';
    
    if ($is_cli) {
        global $argv;
        
        if (!isset($argv[1]) || $argv[1] !== 'init') {
            echo "FullStuck.php is not initialized.\n";
            echo "Run: php fullstuck.php init [options]\n\n";
            echo "Options:\n";
            echo "  --db=sqlite|mysql|pgsql (default: sqlite)\n";
            echo "  --admin-pass=YOUR_PASS (default: admin)\n";
            echo "  --admin-url=/YOUR_URL (default: /stuck)\n";
            echo "  --spa=yes|no (default: yes)\n";
            echo "  --scaffold=yes|no (default: yes)\n";
            echo "  --htaccess=yes|no (default: no)\n";
            exit(1);
        }
        $is_submit = true;
    }

    if ($is_submit) {
        try {
            $input_data = [];
            if ($is_cli) {
                foreach ($argv as $arg) {
                    if (preg_match('/^--([^=]+)=(.*)$/', $arg, $m)) {
                        $input_data[str_replace('-', '_', $m[1])] = $m[2];
                    }
                }
                $input_data['driver'] = $input_data['db'] ?? 'sqlite';
                $input_data['admin_url'] = $input_data['admin_url'] ?? '/stuck';
                $input_data['admin_pass'] = $input_data['admin_pass'] ?? 'admin';
                $input_data['enable_spa'] = ($input_data['spa'] ?? 'yes') === 'yes' ? '1' : '0';
                $input_data['generate_starter'] = ($input_data['scaffold'] ?? 'yes') === 'yes' ? '1' : '0';
                $input_data['download_docs'] = '1';
                $input_data['server_type'] = ($input_data['htaccess'] ?? 'no') === 'yes' ? 'apache_litespeed' : 'other';
            } else {
                $input_data = $_POST;
            }

            $driver = $input_data['driver'] ?? 'sqlite';
            $server_type = $input_data['server_type'] ?? 'apache_litespeed';
            
            if ($driver !== 'none') {
                $h = $input_data['db_host'] ?? 'localhost';
                $n = $input_data['db_name'] ?? '';
                $u = $input_data['db_user'] ?? ($driver === 'pgsql' ? 'postgres' : 'root');
                $p = $input_data['db_pass'] ?? '';
                $port = $input_data['db_port'] ?? ($driver === 'pgsql' ? '5432' : '3306');

                if ($driver === 'mysql') { $dsn = "mysql:host={$h};port={$port};dbname={$n};charset=utf8mb4"; new PDO($dsn, $u, $p, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3]); }
                elseif ($driver === 'pgsql') { $dsn = "pgsql:host={$h};port={$port};dbname={$n}"; new PDO($dsn, $u, $p, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3]); }
                else { $path = FST_ROOT_DIR . '/' . ($input_data['db_path'] ?? 'database.sqlite'); $dir = dirname($path); if (!is_dir($dir) && !mkdir($dir, 0755, true)) throw new Exception("Failed to create folder '{$dir}'. Check permissions."); new PDO("sqlite:" . $path, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); }
            }
            
            $config_data = [
                "environment" => "development", 
                "ai_sop" => true,
                "admin" => [
                    "page_url" => $input_data['admin_url'] ?? '/stuck',
                    "password" => password_hash($input_data['admin_pass'], PASSWORD_DEFAULT),
                    "allowed_ips" => [] 
                ],
                "database" => [
                    "default" => "main",
                    "connections" => [
                        "main" => [
                            "driver" => $driver,
                            "database_path" => $input_data['db_path'] ?? 'database.sqlite',
                            "host" => $input_data['db_host'] ?? 'localhost',
                            "port" => $input_data['db_port'] ?? ($driver === 'pgsql' ? '5432' : '3306'),
                            "dbname" => $input_data['db_name'] ?? '',
                            "username" => $input_data['db_user'] ?? ($driver === 'pgsql' ? 'postgres' : 'root'),
                            "password" => $input_data['db_pass'] ?? ''
                        ]
                    ]
                ],
                "routing" => [
                    "base_path" => "/",
                    "require" => [],
                    "public_folders" => ["assets", "uploads", "storage/public"],
                    "routes_file" => ["router.php"],
                    "error_handlers" => ["404" => "views/errors/404.php", "403" => "Sorry, you do not have permission.", "405" => "Method not allowed.", "500" => "views/errors/500.php"]
                ],
                "spa" => [
                    
                    "enabled" => isset($input_data['enable_spa']) && $input_data['enable_spa'] === '1',
                    "default_target" => "body",
                    "header_request" => "X-FST-Request",
                    "header_target" => "X-FST-Target",
                    "indicator_class" => "fst-loading"
                ]
            ];
            
            if (file_put_contents(FST_CONFIG_FILE, json_encode($config_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) === false) throw new Exception("Failed to write `fullstuck.json`. Check folder permissions.");
            
            $htaccess_content = null;
            if ($server_type === 'apache_litespeed') {
                $htaccess_code = implode("\n", [
                    '# 1. Nonaktifkan fitur "Index of" dan "MultiViews"',
                    'Options -Indexes -MultiViews',
                    '',
                    '# Blokir akses ke file hidden (dotfiles)',
                    '<FilesMatch "^\.">',
                    '    Require all denied',
                    '</FilesMatch>',
                    '',
                    '<IfModule mod_rewrite.c>',
                    '    RewriteEngine On',
                    '    RewriteBase /',
                    '    ',
                    '    # 2. Aturan "Rakus" (Kirim SEMUA ke fullstuck.php)',
                    '    RewriteRule ^(.*)$ fullstuck.php [L]',
                    '</IfModule>'
                ]);
                if (file_put_contents(FST_ROOT_DIR . '/.htaccess', $htaccess_code) === false) $htaccess_content = $htaccess_code;
            }

            
            if (isset($input_data['download_docs']) && $input_data['download_docs'] === '1') {
                $docs_content = @file_get_contents(FST_DOCS_URL);
                if ($docs_content) {
                    $docs_filename = 'fullstuck_v' . FST_VERSION . '.md';
                    @file_put_contents(FST_ROOT_DIR . '/' . $docs_filename, $docs_content);
                }
            }

            
            if (isset($input_data['generate_starter']) && $input_data['generate_starter'] === '1') {
                @mkdir(FST_ROOT_DIR . '/assets', 0755, true);
                @file_put_contents(FST_ROOT_DIR . '/assets/style.css', ':root {--bg-color:#f8fafc;--card-bg:rgba(255, 255, 255, 0.75);--text-main:#1e293b;--text-muted:#64748b;--primary:#4f46e5;--primary-hover:#4338ca;--danger:#ef4444;--success:#10b981;--border:rgba(255, 255, 255, 0.6);}* {box-sizing:border-box;}body {font-family:\'Outfit\', sans-serif;background:var(--bg-color);color:var(--text-main);margin:0;padding:2rem 1rem;display:flex;justify-content:center;align-items:flex-start;min-height:100vh;background-image:radial-gradient(circle at top right, #e0e7ff 0%, #f8fafc 60%);background-attachment:fixed;}.app-container {background:var(--card-bg);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid var(--border);border-radius:28px;padding:2.5rem 2rem;width:100%;max-width:540px;box-shadow:0 20px 40px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.6);transition:all 0.3s ease;}header {margin-bottom:2.5rem;text-align:center;}.logo-wrapper {display:inline-flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;}.logo-icon {font-size:2rem;background:linear-gradient(135deg, #6366f1, #a855f7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;filter:drop-shadow(0 2px 4px rgba(99,102,241,0.3));}header h1 {margin:0;font-weight:800;font-size:2.25rem;letter-spacing:-0.02em;color:var(--text-main);}header p {margin:0;color:var(--text-muted);font-size:1rem;font-weight:500;}.alert {padding:1rem 1.25rem;border-radius:14px;margin-bottom:2rem;font-size:0.95rem;font-weight:600;animation:slideDown 0.3s ease-out;}@keyframes slideDown {from { opacity:0; transform:translateY(-10px); }to { opacity:1; transform:translateY(0); }}.alert-msg { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }.alert-error { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }.form-add {display:flex;flex-wrap:wrap;gap:0.75rem;margin-bottom:2.5rem;position:relative;}.form-add input[type="text"] {flex:1 1 100%;padding:1rem 1.25rem;border:2px solid transparent;border-radius:16px;font-size:1.05rem;font-family:inherit;outline:none;background:rgba(255,255,255,0.9);box-shadow:0 4px 6px rgba(0,0,0,0.02);transition:all 0.25s ease;}.form-add input:focus {border-color:#c7d2fe;box-shadow:0 0 0 4px rgba(99, 102, 241, 0.1);background:#fff;}input[type="file"] {flex:1;padding:0.5rem;background:transparent;border:2px dashed #c7d2fe;box-shadow:none;color:var(--text-muted);font-size:0.85rem;cursor:pointer;}input[type="file"]:focus {border-color:var(--primary);background:transparent;box-shadow:none;}input[type="file"]::file-selector-button {background:#e0e7ff;border:none;border-radius:8px;padding:0.4rem 0.8rem;color:var(--primary);font-weight:600;cursor:pointer;margin-right:0.5rem;transition:all 0.2s ease;}input[type="file"]::file-selector-button:hover {background:#c7d2fe;}button {cursor:pointer;border:none;font-family:inherit;border-radius:12px;font-weight:600;font-size:0.95rem;transition:all 0.2s cubic-bezier(0.4, 0, 0.2, 1);}.btn-primary {background:var(--primary);color:white;padding:0 1.5rem;border-radius:16px;box-shadow:0 4px 12px rgba(79, 70, 229, 0.25);}.btn-primary:hover {background:var(--primary-hover);transform:translateY(-2px);box-shadow:0 6px 16px rgba(79, 70, 229, 0.35);}.btn-primary:active {transform:translateY(0);}.todo-list {list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:1rem;}.empty-state {text-align:center;padding:3rem 1rem;color:var(--text-muted);}.empty-icon {font-size:3rem;margin-bottom:1rem;opacity:0.5;}.empty-state p {margin:0;font-weight:500;}.todo-item {display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.5rem;background:rgba(255,255,255,0.9);border-radius:16px;box-shadow:0 4px 6px rgba(0,0,0,0.02), 0 1px 3px rgba(0,0,0,0.02);transition:all 0.3s ease;border:1px solid rgba(0,0,0,0.02);}.todo-item:hover {transform:translateY(-3px);box-shadow:0 8px 15px rgba(0,0,0,0.05);border-color:rgba(99,102,241,0.1);}.todo-item.done {background:rgba(255,255,255,0.5);}.todo-item.done .task-text {text-decoration:line-through;color:#94a3b8;}.task-content {display:flex;flex-direction:column;gap:0.5rem;}.task-text {font-size:1.05rem;font-weight:500;word-break:break-word;padding-right:1rem;}.task-file {font-size:0.85rem;color:var(--primary);text-decoration:none;font-weight:500;display:inline-block;}.task-file:hover {text-decoration:underline;}.task-actions {display:flex;gap:0.5rem;}.task-actions form {margin:0;}.btn-success { background:#e0e7ff; color:var(--primary); padding:0.6rem 1rem;}.btn-success:hover { background:#c7d2fe; }.btn-danger { background:#fee2e2; color:var(--danger); padding:0.6rem 1rem;}.btn-danger:hover { background:#fecaca; }.fst-loading {opacity:0.6;pointer-events:none;transform:scale(0.98);}');

                @mkdir(FST_ROOT_DIR . '/views', 0755, true);
                $html_template = <<<HTML
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Placeholder Title</title><link rel="stylesheet" href="/assets/style.css"><link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet"></head><body>
<div class="app-container" id="app-content"><header><div class="logo-wrapper"><div class="logo-icon">🚀</div><h1>Tasks</h1></div><p>FullStuck.php Framework Showcase</p></header>
<div class="alert alert-msg">Sukses!</div><div class="alert alert-error">Error!</div>
<form class="form-add" action="/add" method="POST" enctype="multipart/form-data" data-fst-history="false"><input type="text" name="task" placeholder="What needs to be done?" required autocomplete="off"><input type="file" name="file" accept=".png,.jpg,.pdf,.txt"><button type="submit" class="btn-primary">Add</button></form>
<ul class="todo-list"><li class="empty-state"><div class="empty-icon">📭</div><p>Belum ada task. Tambahkan sekarang!</p></li>
<li class="todo-item"><div class="task-content"><span class="task-text">Sample Task</span><a class="task-file" href="#" target="_blank">📄 View File</a><img class="task-img" src="" alt="Attachment" style="max-height:80px;border-radius:8px;display:block;"></div>
<div class="task-actions"><form class="form-toggle" action="/toggle/1" method="POST" data-fst-history="false"><button type="submit" class="btn-success">Done</button></form><form class="form-delete" action="/delete/1" method="POST" data-fst-history="false"><button type="submit" class="btn-danger">Del</button></form></div></li></ul></div>
</body></html>
HTML;
                @file_put_contents(FST_ROOT_DIR . '/views/todo.html', $html_template);

                $router_code = <<<PHP
<?php
// 1. Auto-Migrate Database (SQLite)
fst_db('SCALAR', "CREATE TABLE IF NOT EXISTS todos (id INTEGER PRIMARY KEY AUTOINCREMENT, task TEXT NOT NULL, attachment TEXT, is_done INTEGER DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");

// 2. Global View Share & Middleware Demo
fst_view_share('app_version', 'v0.2.0');
function cek_auth(\$next) {
    if (fst_input('token') !== '123' && !fst_session_get('logged_in')) {
        fst_flash_set('error', 'Akses ditolak! Middleware memblokir request (gunakan ?token=123)');
        return fst_redirect('/');
    }
    return \$next();
}

fst_group('/api', function() {
    fst_get('/tasks', fn() => fst_json(['status' => 'success', 'data' => fst_db_select('todos', [])]));
}, 'cek_auth');

// 3. Tampilkan Halaman Utama
fst_get('/', function() {
    \$todos = fst_db_select('todos', [], ['order_by' => 'is_done ASC, created_at DESC']);
    \$app_version = fst_app('shared_view_data')['app_version'] ?? '';
    fst_template(FST_ROOT_DIR . '/views/todo.html', ['todos' => \$todos], [
        "title" => '"Tasks - FullStuck Showcase (" . "' . \$app_version . '" . ")"',
        "div.alert-msg" => ["@if" => 'fst_flash_has("msg")', "@text" => 'fst_flash_get("msg")'],
        "div.alert-error" => ["@if" => 'fst_flash_has("error")', "@text" => 'fst_flash_get("error")'],
        "form.form-add" => ["@append" => 'fst_csrf_field()'],
        "li.todo-item" => [
            "@foreach" => '\$todos as \$todo',
            "[class]" => '\$todo["is_done"] ? "todo-item done" : "todo-item"',
            "span.task-text" => '\$todo["task"]',
            "a.task-file" => ["@if" => '!empty(\$todo["attachment"]) && !preg_match("/\.(png|jpg|jpeg|gif|webp)\$/i", \$todo["attachment"])', "[href]" => '"/" . \$todo["attachment"]', "@text" => '"📄 View " . strtoupper(pathinfo(\$todo["attachment"], PATHINFO_EXTENSION))'],
            "img.task-img" => ["@if" => '!empty(\$todo["attachment"]) && preg_match("/\.(png|jpg|jpeg|gif|webp)\$/i", \$todo["attachment"])', "[src]" => '"/" . \$todo["attachment"]'],
            "form.form-toggle" => ["[action]" => '"/toggle/" . \$todo["id"]', "@append" => 'fst_csrf_field()'],
            "form.form-toggle button" => ["@text" => '\$todo["is_done"] ? "Undo" : "Done"'],
            "form.form-delete" => ["[action]" => '"/delete/" . \$todo["id"]', "@append" => 'fst_csrf_field()']
        ],
        "li.empty-state" => ["@if" => 'empty(\$todos)']
    ], FST_ROOT_DIR . '/build-template', true);
});

// 4. Tambah Task & Upload File
fst_post('/add', function() {
    fst_csrf_check();
    \$val = fst_validate(fst_request(), ['task' => 'required|min:3']);
    if (\$val['valid']) {
        \$upload = !empty(\$_FILES['file']['name']) ? fst_upload('file', 'assets', ['max_size' => 2048, 'allowed_types' => ['png', 'jpg', 'txt', 'pdf']]) : null;
        fst_db_insert('todos', ['task' => \$val['data']['task'], 'attachment' => \$upload['path'] ?? null]);
        fst_flash_set('msg', 'Task berhasil ditambahkan!');
    } else {
        fst_flash_set('error', implode(', ', \$val['errors']['task']));
    }
    fst_redirect('/');
});

// 5. Toggle Status Task
fst_post('/toggle/{id:i}', function(\$id) {
    fst_csrf_check();
    if (\$todo = fst_db_row('todos', ['id' => \$id])) fst_db_update('todos', ['is_done' => !\$todo['is_done']], ['id' => \$id]);
    fst_redirect('/');
});

// 6. Hapus Task (Demonstrasi Database Transaction)
fst_post('/delete/{id:i}', function(\$id) {
    fst_csrf_check();
    try {
        fst_db_begin();
        if ((\$todo = fst_db_row('todos', ['id' => \$id])) && !empty(\$todo['attachment'])) @unlink(FST_ROOT_DIR . '/' . \$todo['attachment']);
        fst_db_delete('todos', ['id' => \$id]);
        fst_db_commit();
        fst_flash_set('msg', 'Task & attachment dihapus!');
    } catch (Exception \$e) {
        fst_db_rollback();
        fst_flash_set('error', 'Gagal menghapus task!');
    }
    fst_redirect('/');
});
PHP;
                @file_put_contents(FST_ROOT_DIR . '/router.php', $router_code);
            }

            if ($is_cli) {
                echo "FullStuck initialized successfully!\n";
                return;
            }

            echo fst_show_install_success($htaccess_content); return;
        } catch (Exception $e) { 
            if ($is_cli) {
                echo "ERROR: " . $e->getMessage() . "\n";
                exit(1);
            }
            $error_message = "ERROR: " . $e->getMessage(); 
        }
    }
    if (!$is_cli) {
        echo fst_show_install_form($error_message);
    }
}
function fst_render_status_row($label, $success, $note = '', $optional = false) { if ($success) $status = '<span style="color:green;">✔ OK</span>'; else if ($optional) $status = '<span style="color:orange;">⚠ Optional</span>'; else $status = '<span style="color:red;">❌ Failed</span>'; return "<tr><td>{$label}</td><td>{$status}</td><td>" . htmlspecialchars($note) . "</td></tr>"; }
function fst_show_install_success($htaccess_content) { $htaccess_html = ''; if ($htaccess_content) { $htaccess_safe = htmlspecialchars($htaccess_content); $htaccess_html = <<<HTML
    <p style="color:red; font-weight:bold;">ACTION REQUIRED:</p>
    <p>Failed to write the <code>.htaccess</code> file automatically (likely a folder permission issue). Please create a <code>.htaccess</code> file in the same folder as <code>fullstuck.php</code> and paste in the following code:</p>
    <pre class="code">{$htaccess_safe}</pre>
HTML;
} else { $htaccess_html = '<p style="color:green;">The <code>.htaccess</code> file (if needed) has also been created automatically.</p>'; }
$html = <<<HTML
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Installation Complete</title>
<style>body{font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; line-height: 1.6;} .code{background: #f4f4f4; padding: 15px; border-radius: 4px; border: 1px solid #ddd; overflow-x: auto;} a {display:inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px;}</style>
</head><body><h1>🚀 Installation Successful!</h1><p>The <code>fullstuck.json</code> file has been successfully created.</p>{$htaccess_html}<p>Your framework is now ready to use.</p><a href="./">Start Using Framework</a></body></html>
HTML;
return $html;
}

function fst_show_install_form($error_message) { $checks = ['php_version' => version_compare(PHP_VERSION, '8.0.0', '>='),'dir_writable' => is_writable(FST_ROOT_DIR),'pdo_loaded' => extension_loaded('pdo'),'pdo_mysql' => extension_loaded('pdo_mysql'),'pdo_sqlite' => extension_loaded('pdo_sqlite'),'pdo_pgsql' => extension_loaded('pdo_pgsql'),'server_soft' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown']; $detected_server = 'other'; if (stripos($checks['server_soft'], 'Apache') !== false || stripos($checks['server_soft'], 'Litespeed') !== false) $detected_server = 'apache_litespeed'; elseif (stripos($checks['server_soft'], 'Development Server') !== false) $detected_server = 'php_s'; elseif (stripos($checks['server_soft'], 'nginx') !== false) $detected_server = 'nginx'; $status_rows = ''; $status_rows .= fst_render_status_row('PHP Version (>= 8.0)', $checks['php_version'], 'Your version: ' . PHP_VERSION); $status_rows .= fst_render_status_row('Directory Writable', $checks['dir_writable'], FST_ROOT_DIR); $status_rows .= fst_render_status_row('PDO Extension', $checks['pdo_loaded'], 'Required for database'); $status_rows .= fst_render_status_row('PDO MySQL Driver', $checks['pdo_mysql'], '', !$checks['pdo_sqlite'] && !$checks['pdo_pgsql']); $status_rows .= fst_render_status_row('PDO SQLite Driver', $checks['pdo_sqlite'], '', !$checks['pdo_mysql'] && !$checks['pdo_pgsql']); $status_rows .= fst_render_status_row('PDO PostgreSQL Driver', $checks['pdo_pgsql'], '', !$checks['pdo_mysql'] && !$checks['pdo_sqlite']); $status_rows .= fst_render_status_row('Web Server Info', true, $checks['server_soft'], true); $error_html = $error_message ? "<div class='error'>" . htmlspecialchars($error_message) . "</div>" : ''; $opt_apache = ($detected_server === 'apache_litespeed') ? 'selected' : ''; $opt_nginx = ($detected_server === 'nginx') ? 'selected' : ''; $opt_php_s = ($detected_server === 'php_s') ? 'selected' : ''; $opt_other = ($detected_server === 'other') ? 'selected' : ''; $opt_sqlite = 'selected'; $opt_mysql = ''; $opt_pgsql = ''; if (!$checks['pdo_sqlite']) { if ($checks['pdo_mysql']) $opt_mysql = 'selected'; elseif ($checks['pdo_pgsql']) $opt_pgsql = 'selected'; $opt_sqlite = ''; } $root_dir_safe = htmlspecialchars(FST_ROOT_DIR);
$html = <<<HTML
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>FullStuck.php Installation</title>
<style>body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; line-height: 1.6; } h1, h2 { border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; } table { width: 100%; border-collapse: collapse; margin-bottom: 20px; } th, td { text-align: left; padding: 8px; border-bottom: 1px solid #f0f0f0; } tr:nth-child(even) { background-color: #f9f9f9; } .form-group { margin-bottom: 15px; } label { display: block; font-weight: bold; margin-bottom: 5px; } input[type="text"], input[type="password"], select { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; } button { background: #007bff; color: white; padding: 12px 20px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; } button:hover { background: #0056b3; } .error { background: #ffe0e0; border: 1px solid #ffb0b0; color: #d00; padding: 15px; border-radius: 4px; margin-bottom: 20px; } .note { font-size: 0.9em; color: #555; } code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }</style>
</head><body><h1>🚀 Welcome to FullStuck.php</h1><p>The <code>fullstuck.json</code> configuration file was not found. Please complete the installation steps below to get started.</p>{$error_html}<h2>🛠️ Server Compatibility Check</h2><table><thead><tr><th>Requirement</th><th>Status</th><th>Notes</th></tr></thead><tbody>{$status_rows}</tbody></table><h2>⚙️ Configuration</h2><form method="POST" id="install-form"><div class="form-group"><label>Web Server Type</label><select name="server_type"><option value="apache_litespeed" {$opt_apache}>Apache / Litespeed (.htaccess will be created automatically)</option><option value="nginx" {$opt_nginx}>Nginx (Instructions will be shown later)</option><option value="php_s" {$opt_php_s}>PHP -S (No .htaccess needed)</option><option value="other" {$opt_other}>Other (Manual configuration)</option></select></div><div class="form-group"><label>Database Driver</label><select name="driver" id="driver-select"><option value="sqlite" {$opt_sqlite}>SQLite</option><option value="mysql" {$opt_mysql}>MySQL</option><option value="pgsql" {$opt_pgsql}>PostgreSQL</option><option value="none">No Database (Setup Later)</option></select></div><div id="mysql-fields"><div class="form-group"><label for="db_host">Database Host</label><input type="text" name="db_host" id="db_host" value="localhost"></div><div id="port-field" class="form-group"><label for="db_port">Database Port</label><input type="text" name="db_port" id="db_port" placeholder="e.g. 3306 or 5432"></div><div class="form-group"><label for="db_name">Database Name</label><input type="text" name="db_name" id="db_name" value="fullstuck_db"></div><div class="form-group"><label for="db_user">Database Username</label><input type="text" name="db_user" id="db_user" value="root"></div><div class="form-group"><label for="db_pass">Database Password</label><input type="password" name="db_pass" id="db_pass"></div></div><div id="sqlite-fields"><div class="form-group"><label for="db_path">SQLite File Path</label><input type="text" name="db_path" id="db_path" value="database.sqlite"><p class="note">Default: <code>database.sqlite</code>. Path is relative to <code>{$root_dir_safe}</code>. The folder will be created if it doesn't exist.</p></div></div><div class="form-group"><label for="admin_url">Admin Dashboard URL</label><input type="text" name="admin_url" id="admin_url" value="/stuck" required><p class="note">The secret URL to access the admin panel in development mode.</p></div><div class="form-group"><label for="admin_pass">Admin Dashboard Password</label><input type="password" name="admin_pass" id="admin_pass" required><p class="note">Will be hashed. Used for the admin API in development mode.</p></div><div class="form-group"><label style="display:flex; align-items:center; cursor:pointer;"><input type="checkbox" name="download_docs" value="1" style="width:auto; margin-right:10px;" checked> Download documentation for AI (<code>fullstuck_v<?= FST_VERSION ?>.md</code>)</label><p class="note">Helps AI agents (like ChatGPT/Claude) understand the framework context better.</p></div><div class="form-group">
    <label style="display:flex; align-items:center; cursor:pointer;">
        <input type="checkbox" name="enable_spa" value="1" style="width:auto; margin-right:10px;" checked> 
        Enable Zero-Config SPA (Single Page Application)
    </label>
    <p class="note">Automatically converts your traditional page loads into instant, seamless transitions.</p>
</div>
<div class="form-group">
    <label style="display:flex; align-items:center; cursor:pointer;">
        <input type="checkbox" name="generate_starter" value="1" style="width:auto; margin-right:10px;" checked> 
        Generate Starter Project Files
    </label>
    <p class="note">Creates a basic project structure (router.php, views, and css) to help you get started instantly.</p>
</div>
<button type="submit">Install FullStuck.php</button></form>
<script>
    const driverSelect = document.getElementById('driver-select');
    const mysqlFields = document.getElementById('mysql-fields');
    const sqliteFields = document.getElementById('sqlite-fields');
    const portField = document.getElementById('port-field');
    const dbUser = document.getElementById('db_user');

    function toggleFields() {
        if (driverSelect.value === 'mysql' || driverSelect.value === 'pgsql') {
            mysqlFields.style.display = 'block';
            sqliteFields.style.display = 'none';
            portField.style.display = (driverSelect.value === 'pgsql') ? 'block' : 'none';
            if (driverSelect.value === 'pgsql' && dbUser.value === 'root') dbUser.value = 'postgres';
            if (driverSelect.value === 'mysql' && dbUser.value === 'postgres') dbUser.value = 'root';
        } else if (driverSelect.value === 'sqlite') {
            mysqlFields.style.display = 'none';
            sqliteFields.style.display = 'block';
        } else {
            mysqlFields.style.display = 'none';
            sqliteFields.style.display = 'none';
        }
    }
    driverSelect.addEventListener('change', toggleFields);
    toggleFields();
</script>
</body></html>
HTML;
return $html;
}

// FILE: admin.php
if (fst_is_dev()) {
    $fst_config = fst_app('config');
    $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';

    fst_get($admin_base . '/login', 'fst_admin_show_login');
    fst_post($admin_base . '/login', 'fst_admin_do_login');
    fst_get($admin_base . '/logout', 'fst_admin_do_logout');

    fst_get($admin_base, 'fst_admin_show_monitor');

    fst_get($admin_base . '/config', 'fst_admin_show_config');
    fst_post($admin_base . '/config/save', 'fst_admin_save_config');
    fst_post($admin_base . '/config/hash', function() use ($admin_base) { fst_admin_check_auth(); fst_flash_set('success_message', 'Hash: ' . password_hash($_POST['new_pass'], PASSWORD_DEFAULT)); fst_redirect($admin_base.'/config'); });

    fst_get($admin_base . '/routes', 'fst_admin_show_routes');
    
    fst_get($admin_base . '/server-info', 'fst_admin_show_server_info');

    fst_get($admin_base . '/scan', 'fst_admin_show_scan_page');
    fst_post($admin_base . '/scan/run', 'fst_admin_run_scan');

    fst_get($admin_base . '/integrity', 'fst_admin_show_integrity');
    fst_get($admin_base . '/plugins', 'fst_admin_show_plugins');
    fst_post($admin_base . '/plugins/install', 'fst_admin_install_plugin');
    fst_post($admin_base . '/plugins/toggle', 'fst_admin_toggle_plugin');
    fst_post($admin_base . '/plugins/uninstall', 'fst_admin_uninstall_plugin');

    
    fst_get($admin_base . '/update', function() use ($admin_base) {
        fst_admin_check_auth();
        $current_version = defined('FST_VERSION') ? FST_VERSION : 'Unknown';
        $json_url = 'https://raw.githubusercontent.com/milio48/fullstuck/refs/heads/main/version.json';
        
        $ctx = stream_context_create(['http' => ['timeout' => 5]]);
        $remote_data = @file_get_contents($json_url, false, $ctx);
        $remote_version = 'Unknown';
        $can_update = false;

        if ($remote_data) {
            $json = json_decode($remote_data, true);
            if (isset($json['version'])) {
                $remote_version = $json['version'];
                
                if ($current_version !== 'Unknown') {
                    $can_update = version_compare($remote_version, $current_version, '>');
                }
            }
        }

        $html = "<h2>System Update</h2>";
        $html .= "<p>Current Version: <strong>{$current_version}</strong></p>";
        $html .= "<p>Latest Version: <strong>{$remote_version}</strong></p>";

        if ($can_update) {
            $html .= '<div style="background: #e8f5e9; padding: 15px; border-left: 4px solid #4caf50; margin-bottom: 20px;">
                        <strong>🚀 Update Tersedia!</strong> Versi baru siap diunduh.
                      </div>';
            $html .= '<form method="POST" action="' . $admin_base . '/update/run">
                        ' . fst_csrf_field() . '
                        <button type="submit" onclick="return confirm(\'Proses ini akan mengunduh core terbaru dan membackup file lama Anda. Lanjutkan?\');" style="background:#007bff; color:white; padding:10px 15px; border:none; cursor:pointer;">Update Core Sekarang</button>
                      </form>';
        } else {
            $html .= "<p style='color: green;'>Sistem Anda sudah up-to-date.</p>";
        }

        fst_admin_render_page('Update System', $html);
    });

    fst_post($admin_base . '/update/run', function() use ($admin_base) {
        fst_admin_check_auth();
        fst_csrf_check();

        $core_url = 'https://raw.githubusercontent.com/milio48/fullstuck/refs/heads/main/fullstuck.php';
        $ctx = stream_context_create(['http' => ['timeout' => 15]]);
        $new_core = @file_get_contents($core_url, false, $ctx);

        
        if (!$new_core || strpos($new_core, '<?php') !== 0) {
            fst_flash_set('error_message', 'Gagal mengunduh update atau file korup.');
            fst_redirect($admin_base . '/update');
        }

        $target_file = FST_ROOT_DIR . '/fullstuck.php';
        $backup_file = FST_ROOT_DIR . '/fullstuck.bak.php';

        
        if (file_exists($target_file)) {
            copy($target_file, $backup_file);
        }

        
        if (file_put_contents($target_file, $new_core) !== false) {
            fst_flash_set('success_message', 'Sistem berhasil diupdate! File lama disimpan sebagai fullstuck.bak.php');
        } else {
            fst_flash_set('error_message', 'Gagal menulis file. Periksa permission server.');
        }

        fst_redirect($admin_base . '/update');
    });

    fst_any($admin_base . '/p/{id}', function($id) use ($admin_base) {
        fst_admin_check_auth();
        $plugins = fst_app('plugins') ?? [];
        
        if (!isset($plugins[$id]) || !is_callable($plugins[$id]['admin_route'] ?? null)) {
            fst_abort(404, "Plugin '{$id}' tidak ditemukan atau tidak memiliki antarmuka admin.");
        }

        
        ob_start();
        call_user_func($plugins[$id]['admin_route']);
        $plugin_content = ob_get_clean();

        $page_title = $plugins[$id]['menu_label'] ?? $plugins[$id]['name'] ?? 'Plugin';
        fst_admin_render_page($page_title, $plugin_content);
    });
}


if (fst_is_dev()) {

    function fst_admin_check_auth() {
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';
        
        
        if (!fst_is_dev() && $admin_base === '/stuck') {
            fst_abort(403, "SECURITY ALERT: You are in 'production' environment. You MUST change the default admin URL in fullstuck.json.");
        }

        
        $allowed_ips = $fst_config['admin']['allowed_ips'] ?? [];
        if (!empty($allowed_ips) && !in_array($_SERVER['REMOTE_ADDR'], $allowed_ips, true)) {
            fst_abort(403, "Forbidden: Your IP (" . htmlspecialchars($_SERVER['REMOTE_ADDR']) . ") is not allowed to access the admin area.");
        }

        
        if (empty($_SESSION['fst_admin_logged_in'])) {
            fst_flash_set('error_message', 'Please login to access the admin area.');
            fst_redirect($admin_base . '/login');
        }
    }

    function fst_admin_show_login() {
        header('Content-Type: text/html; charset=UTF-8');
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';
        $error = fst_flash_get('error_message');
        $error_html = $error ? "<p style='color:red;'>{$error}</p>" : '';
        $csrf = fst_csrf_field();

        $html = <<<HTML
<!DOCTYPE html><html lang="en"><head><title>Admin Login</title><style>/* CSS Sederhana */ body{font-family:sans-serif; max-width:400px; margin:50px auto; padding:20px; border:1px solid #ccc;} input{width:100%; padding:8px; margin-bottom:10px;} button{padding:10px 15px;}</style></head>
<body><h1>Admin Login</h1>{$error_html}
<form method="POST" action="{$admin_base}/login" data-fst-no-spa>{$csrf}
<label for="password">Password:</label><input type="password" name="password" id="password" required><button type="submit">Login</button></form></body></html>
HTML;
        echo $html;
    }

    function fst_admin_do_login() {
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';
        fst_csrf_check();

        $password = $_POST['password'] ?? '';
        $hashed_password = $fst_config['admin']['password'] ?? '';

        if (password_verify($password, $hashed_password)) {
            
            session_regenerate_id(true);
            $_SESSION['fst_admin_logged_in'] = true;
            fst_redirect($admin_base);
        } else {
            fst_flash_set('error_message', 'Invalid password.');
            fst_redirect($admin_base . '/login');
        }
    }

    function fst_admin_do_logout() {
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';
        unset($_SESSION['fst_admin_logged_in']);
        fst_flash_set('success_message', 'You have been logged out.');
        fst_redirect($admin_base . '/login');
    }
    
    function fst_admin_render_page($title, $content) {
         header('Content-Type: text/html; charset=UTF-8');
         $fst_config = fst_app('config');
         $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';
         $success_msg = fst_flash_get('success_message');
         $error_msg = fst_flash_get('error_message');
         $info_html = '';
         if ($success_msg) $info_html .= "<p style='color:green;'>" . htmlspecialchars($success_msg) . "</p>";
         if ($error_msg) $info_html .= "<p style='color:red;'>" . htmlspecialchars($error_msg) . "</p>";
         
         $plugins = fst_app('plugins') ?? [];
         $plugin_links = '';
         foreach ($plugins as $p_id => $p_conf) {
             $p_label = htmlspecialchars($p_conf['menu_label'] ?? $p_conf['name'] ?? $p_id);
             $plugin_links .= "<a href=\"{$admin_base}/p/{$p_id}\" data-fst-no-spa>🔌 {$p_label}</a>\n    ";
         }
         
         $html = <<<HTML
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>{$title} - Admin</title>
<style>
    body { font-family: sans-serif; margin: 0; }
    .container { max-width: 900px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; }
    nav { background: #333; padding: 10px; margin-bottom: 20px; }
    nav a { color: white; margin-right: 15px; text-decoration: none; }
    nav a:hover { text-decoration: underline; }
    h1, h2 { border-bottom: 1px solid #eee; padding-bottom: 5px; }
    pre { background: #f4f4f4; padding: 10px; border: 1px solid #ccc; overflow-x: auto; }
    textarea { width: 100%; min-height: 400px; box-sizing: border-box; font-family: monospace; }
    button { padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px;}
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left;}
    th { background-color: #f2f2f2;}

    /* === GAYA PERINGATAN BARU === */
    .alert-warning {
        background-color: #fffbe6;
        border: 1px solid #ffe58f;
        border-left-width: 5px;
        border-left-color: #ffa940;
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        color: #ad8601;
        font-family: monospace;
        font-size: 1.1em;
    }
    .alert-warning strong {
        color: #d46b08;
    }
</style>
</head><body>
<nav>
    <a href="{$admin_base}" data-fst-no-spa>Monitor</a>
    <a href="{$admin_base}/config" data-fst-no-spa>Config Editor</a>
    <a href="{$admin_base}/routes" data-fst-no-spa>Route List</a>
    <a href="{$admin_base}/server-info" data-fst-no-spa>Server Info</a>
    <a href="{$admin_base}/scan" data-fst-no-spa>Scan Project</a>
    <a href="{$admin_base}/integrity" data-fst-no-spa>Integrity</a>
    <a href="{$admin_base}/plugins" data-fst-no-spa>Plugins</a>
    <a href="{$admin_base}/update" data-fst-no-spa>Update</a>
    {$plugin_links}<a href="{$admin_base}/logout" style="float:right;" data-fst-no-spa>Logout</a>
</nav>
<div class="container">
    <h1>{$title}</h1>
    {$info_html}
    {$content}
</div>
</body></html>
HTML;
         echo $html;
    }

    function fst_admin_get_remote_info() {
        $cache_key = 'fst_remote_version_cache';
        $cache_time = 3600; 

        if (isset($_SESSION[$cache_key]) && (time() - $_SESSION[$cache_key]['time'] < $cache_time)) {
            return $_SESSION[$cache_key]['data'];
        }

        $remote_url = "https://raw.githubusercontent.com/milio48/fullstuck/main/version.json";
        $ctx = stream_context_create(['http' => ['timeout' => 5]]);
        $remote_json = @file_get_contents($remote_url, false, $ctx);
        
        if ($remote_json) {
            $remote_data = json_decode($remote_json, true);
            if ($remote_data) {
                $_SESSION[$cache_key] = [
                    'time' => time(),
                    'data' => $remote_data
                ];
                return $remote_data;
            }
        }
        return false;
    }

    function fst_admin_show_monitor() {
        fst_admin_check_auth();
        $fst_config = fst_app('config');

        $update_banner = '';
        $remote_data = fst_admin_get_remote_info();
        if ($remote_data && isset($remote_data['version'])) {
            if (version_compare(FST_VERSION, $remote_data['version'], '<')) {
                $update_banner = '<div style="background: #e6f7ff; border: 1px solid #91d5ff; padding: 15px; margin-bottom: 20px; border-radius: 4px; color: #0050b3;">';
                $update_banner .= '<strong>🚀 New Update Available!</strong> v' . htmlspecialchars($remote_data['version']) . ' is now available. ';
                $update_banner .= '<a href="https://github.com/milio48/fullstuck/releases" target="_blank" style="color: #1890ff; font-weight: bold;">View Releases</a>';
                if (isset($remote_data['hash']) && fst_check_integrity()['declared'] !== $remote_data['hash']) {
                    $update_banner .= '<br><small style="color: #666;">Note: Your core file hash does not match the latest release.</small>';
                }
                $update_banner .= '</div>';
            }
        }
        
        $dev_warning_html = ''; 
        $warnings = [];
        $errors = [];

        
        $current_env = $fst_config['environment'] ?? 'production';

        if ($current_env === 'development') {
            
            $dev_warning_html = '<div class="alert-warning"><strong>WARNING:</strong> Environment is set to \'development\'. Make sure to change it to \'production\' before going live!</div>';
        } elseif ($current_env !== 'production') {
            
            
            $warnings[] = "Environment is set to '{$current_env}'. This is not a 'production' build.";
        }
        

        $route_files = (array)($fst_config['routing']['routes_file'] ?? ['router.php']);
        foreach ($route_files as $file) {
            if (!file_exists(FST_ROOT_DIR . '/' . $file)) {
                $errors[] = "Static route file not found: <code>{$file}</code>";
            }
        }
        
        $public_folders = $fst_config['routing']['public_folders'] ?? [];
        foreach ($public_folders as $folder) {
            if (!is_dir(FST_ROOT_DIR . '/' . $folder)) {
                $warnings[] = "Public folder not found (will be ignored): <code>{$folder}</code>";
            }
        }

        $error_handlers = $fst_config['routing']['error_handlers'] ?? [];
        foreach ($error_handlers as $code => $handler) {
            if (preg_match('/\.php$|\.html$/', $handler) && !file_exists(FST_ROOT_DIR . '/' . $handler)) {
                $warnings[] = "Error handler file for code {$code} not found: <code>{$handler}</code> (Fallback will be used)";
            }
        }

        
        $db_status = '';
        $default_conn = $fst_config['database']['default'] ?? 'main';
        $db_driver = $fst_config['database']['connections'][$default_conn]['driver'] ?? 'none';
        
        if ($db_driver === 'none') {
            $db_status = '<span style="color:orange;">⚠ Not Configured</span>';
        } else {
            try {
                fst_db('ROW', 'SELECT 1', [], $default_conn);
                $db_status = '<span style="color:green;">✔ OK</span> (Driver: ' . $db_driver . ')';
            } catch (Exception $e) {
                $db_status = '<span style="color:red;">❌ FAILED</span>: ' . (fst_is_safe_to_debug() ? $e->getMessage() : 'Connection error.');
                $errors[] = "Database connection test failed: " . $e->getMessage();
            }
        }

        $content = "<h2>Configuration Status</h2>";
        $content .= $update_banner;
        
        
        $content .= $dev_warning_html; 
        
        
        $content .= "<p><strong>Environment:</strong> " . htmlspecialchars($current_env) . "</p>";
        $content .= "<p><strong>Database Status:</strong> {$db_status}</p>";

        
        $ext_checks = [
            ['name' => 'mbstring', 'level' => 'recommended', 'note' => 'Digunakan untuk penghitungan panjang string multibyte (validasi). Tanpa ini, framework fallback ke strlen().'],
            ['name' => 'fileinfo', 'level' => 'recommended', 'note' => 'Meningkatkan deteksi MIME type saat upload file.'],
            ['name' => 'json', 'level' => 'required', 'note' => 'Diperlukan untuk parsing fullstuck.json dan fst_json().'],
            ['name' => 'pdo', 'level' => 'required', 'note' => 'Diperlukan untuk koneksi database.'],
            ['name' => 'session', 'level' => 'required', 'note' => 'Diperlukan untuk session, flash message, dan CSRF.'],
        ];
        $ext_html = "<h2>PHP Extension Check</h2><table><thead><tr><th>Extension</th><th>Status</th><th>Level</th><th>Keterangan</th></tr></thead><tbody>";
        foreach ($ext_checks as $ext) {
            $loaded = extension_loaded($ext['name']);
            $status_icon = $loaded ? '<span style="color:green;">✔ Loaded</span>' : '<span style="color:orange;">✗ Not Loaded</span>';
            $level_label = $ext['level'] === 'required' ? '<b>Required</b>' : 'Recommended';
            if (!$loaded && $ext['level'] === 'recommended') {
                $warnings[] = "Extension <code>{$ext['name']}</code> tidak aktif. {$ext['note']}";
            } elseif (!$loaded && $ext['level'] === 'required') {
                $errors[] = "Extension <code>{$ext['name']}</code> (REQUIRED) tidak aktif! {$ext['note']}";
            }
            $ext_html .= "<tr><td><code>{$ext['name']}</code></td><td>{$status_icon}</td><td>{$level_label}</td><td>{$ext['note']}</td></tr>";
        }
        $ext_html .= "</tbody></table>";

        if (!empty($errors)) {
            $content .= "<h2><span style='color:red;'>Errors Found!</span></h2><ul>";
            foreach($errors as $err) { $content .= "<li>{$err}</li>"; }
            $content .= "</ul>";
        }
        if (!empty($warnings)) {
            $content .= "<h2><span style='color:orange;'>Warnings</span></h2><ul>";
            foreach($warnings as $warn) { $content .= "<li>{$warn}</li>"; }
            $content .= "</ul>";
        }

        $content .= $ext_html;

        fst_admin_render_page('System Monitor', $content);
    }

    function fst_admin_show_config() {
        fst_admin_check_auth();
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';
        $csrf = fst_csrf_field();
        
        $config_content = htmlspecialchars(file_get_contents(FST_CONFIG_FILE), ENT_QUOTES, 'UTF-8');
        
        $content = <<<HTML
<p>Edit the raw JSON configuration below. Be careful with syntax!</p>
<form action="{$admin_base}/config/hash" method="POST" data-fst-no-spa style="margin-bottom:15px; padding:10px; background:#f4f4f4; border-radius:5px;">{$csrf}<strong>Generate Password Hash:</strong> <input type="text" name="new_pass" placeholder="Type new password" required> <button type="submit">Generate</button></form>
<form action="{$admin_base}/config/save" method="POST" data-fst-no-spa>
    {$csrf}
    <textarea name="config_content" spellcheck="false">{$config_content}</textarea>
    <br><br>
    <button type="submit">Save Configuration</button>
</form>
HTML;
        fst_admin_render_page('Configuration Editor', $content);
    }

    function fst_admin_save_config() {
        fst_admin_check_auth();
        fst_csrf_check();
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';

        $new_content = $_POST['config_content'] ?? '';

        $decoded = json_decode($new_content);
        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            fst_flash_set('error_message', 'Invalid JSON syntax! Changes not saved. Error: ' . json_last_error_msg());
        } else {
            if (file_put_contents(FST_CONFIG_FILE, $new_content) !== false) {
                 fst_flash_set('success_message', 'Configuration saved successfully!');
            } else {
                 fst_flash_set('error_message', 'Failed to write configuration file! Check permissions.');
            }
        }
        fst_redirect($admin_base . '/config');
    }
    
     function fst_admin_show_routes() {
        fst_admin_check_auth();
        $fst_routes = fst_app('routes');
        $fst_config = fst_app('config');
        $fst_route_prefix = fst_app('route_prefix');
        
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $base_path = $fst_config['routing']['base_path'] ?? '/';
        $base_url = rtrim($scheme . "://" . $host . $base_path, '/');
        
        $content = "<p>List of registered routes (from static files or admin routes).</p>";
        $content .= "<table><thead><tr><th>Method</th><th>Original Path</th><th>Pattern (Regex)</th><th>Example URL (GET only)</th></tr></thead><tbody>";
        
        if (empty($fst_routes)) {
             $content .= "<tr><td colspan='4'>No routes registered yet.</td></tr>";
        } else {
            foreach ($fst_routes as $method_group => $routes) {
                foreach ($routes as $route) {
                     list($method, $pattern, $callback, $original_path) = array_pad($route, 4, null);
                     
                     if ($original_path === null) {
                          $original_path = preg_replace(['/#\^|\\\$#/', '/\(\[\^\/]\+\)/', '/\(\[0-9]\+\)/', '/\(\[a-zA-Z0-9\\-]+)/'], ['', '{param}', '{id}', '{slug}'], str_replace('\/', '/', $pattern));
                     }

                     $link = '-';
                     if ($method === 'GET' || $method === 'ANY') {
                          $test_url_path = preg_replace('/\{[^}]+\??\}/', 'test', $original_path);
                          $test_url = $base_url . $test_url_path;
                          $link = "<a href='{$test_url}' target='_blank' title='Click to test (opens in new tab)'>" . htmlspecialchars($original_path) . "</a>";
                     } else {
                          $link = htmlspecialchars($original_path);
                     }

                     $content .= "<tr><td>{$method}</td><td><code>" . htmlspecialchars($original_path) . "</code></td><td><code>" . htmlspecialchars($pattern) . "</code></td><td>{$link}</td></tr>";
                }
            }
        }
        $content .= "</tbody></table>";
        
        fst_admin_render_page('Registered Routes', $content);
    }
     
     function fst_get_server_info() { return [ 'PHP Version' => PHP_VERSION, 'System' => php_uname(), 'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A', 'Document Root' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A', 'FullStuck Root' => FST_ROOT_DIR, 'SAPI' => php_sapi_name(), 'PDO Loaded' => extension_loaded('pdo') ? 'Yes' : 'No', 'PDO MySQL' => extension_loaded('pdo_mysql') ? 'Yes' : 'No', 'PDO SQLite' => extension_loaded('pdo_sqlite') ? 'Yes' : 'No', 'mbstring' => extension_loaded('mbstring') ? 'Yes' : 'No (fallback to strlen)', 'json' => extension_loaded('json') ? 'Yes' : 'No', 'session' => extension_loaded('session') ? 'Yes' : 'No', 'fileinfo' => extension_loaded('fileinfo') ? 'Yes' : 'No (upload mime detection limited)', ]; }
     
     function fst_admin_show_server_info() {
         fst_admin_check_auth();
         $server_info = fst_get_server_info();
         
         $content = "<table><thead><tr><th>Parameter</th><th>Value</th></tr></thead><tbody>";
         foreach ($server_info as $key => $value) {
             $content .= "<tr><td>" . htmlspecialchars($key) . "</td><td>" . htmlspecialchars($value) . "</td></tr>";
         }
         $content .= "</tbody></table>";
         
         $content .= "<h2>PHP Info (Raw)</h2>";
         $content .= "<details><summary>Click to expand/collapse</summary><div style='width:100%; height: 400px; overflow:auto; border:1px solid #ccc;'>";
         ob_start();
         phpinfo();
         $phpinfo = ob_get_clean();
         if (preg_match('/<body.*?>(.*)<\/body>/is', $phpinfo, $matches)) {
             $content .= $matches[1];
         } else {
             $content .= "Could not parse phpinfo().";
         }
         $content .= "</div></details>";
         
         fst_admin_render_page('Server Information', $content);
     }

    function fst_admin_show_scan_page() {
        fst_admin_check_auth();
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';
        $csrf = fst_csrf_field();
        
        $scan_results_html = '';
        $scan_data = fst_flash_get('scan_results');

        if ($scan_data !== null) {
            $file_count = count($scan_data);
            $scan_results_html .= "<h2>Scan Results ({$file_count} PHP files analyzed):</h2>";
            if (empty($scan_data)) {
                 $scan_results_html .= "<p>No PHP files found or scanned.</p>";
            } else {
                 $scan_results_html .= "<table border='1' style='width:100%; border-collapse: collapse;'><thead><tr><th>File Path</th><th>Function Groups & Functions Found</th></tr></thead><tbody>";
                 ksort($scan_data);
                 
                 foreach ($scan_data as $file => $groups) {
                     $scan_results_html .= "<tr><td><code>" . htmlspecialchars($file) . "</code></td><td>";
                     if(empty($groups)){
                         $scan_results_html .= "<i>(No fst_ usage found)</i>";
                     } else {
                         $group_details = [];
                         foreach($groups as $group_name => $functions) {
                             $group_details[] = "<strong>" . htmlspecialchars($group_name) . ":</strong> " . implode(', ', array_map('htmlspecialchars', $functions));
                         }
                         $scan_results_html .= implode('<br>', $group_details);
                     }
                     $scan_results_html .= "</td></tr>";
                 }
                 $scan_results_html .= "</tbody></table>";
            }
        } else {
             $scan_results_html .= "<p>Click 'Start Scan' to analyze project files.</p>";
        }

        $content = <<<HTML
<p>Click the button below to scan your project directory (<code>{$_SERVER['DOCUMENT_ROOT']}</code>) for usage of <code>fst_</code> functions in <code>.php</code> files.</p>
<p><strong>Warning:</strong> This might take a while on large projects. Folders like <code>vendor</code> and <code>node_modules</code> are automatically skipped.</p>

<form action="{$admin_base}/scan/run" method="POST" data-fst-no-spa>
    {$csrf}
    <button type="submit">Start Scan</button>
</form>

{$scan_results_html}
HTML;
        fst_admin_render_page('Scan Project for fst_ Usage', $content);
    }

    function fst_admin_run_scan() {
        fst_admin_check_auth();
        fst_csrf_check();
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';

        $function_groups = [
            'Core' => ['fst_abort', 'fst_run', 'fst_is_dev', 'fst_config', 'fst_extract_html_fragment', 'fst_app'],

            'Database' => ['fst_db', 'fst_db_begin', 'fst_db_commit', 'fst_db_rollback', 'fst_db_select', 'fst_db_row', 'fst_db_exists', 'fst_db_insert', 'fst_db_update', 'fst_db_delete', 'fst_db_quote_ident', '_fst_sanitize_order_by'],
            'Views' => [
                'fst_view',
                'fst_partial',
                'fst_serve_static_file',
                'fst_template'
            ],
            'Request' => ['fst_uri', 'fst_method', 'fst_input', 'fst_request', 'fst_file', 'fst_is_spa', 'fst_spa_target'],
            'Routing' => ['fst_route', 'fst_get', 'fst_post', 'fst_put', 'fst_patch', 'fst_delete', 'fst_any', 'fst_group'],
            'Response' => ['fst_json', 'fst_text', 'fst_redirect', 'fst_status_code'],
            'Session' => ['fst_session_set', 'fst_session_get', 'fst_session_forget', 'fst_flash_set', 'fst_flash_has', 'fst_flash_get'],
            'Security' => ['fst_csrf_token', 'fst_csrf_field', 'fst_csrf_check', 'fst_escape', 'e', 'fst_is_safe_to_debug'],
            'Upload' => ['fst_upload'],
            'Validation' => ['fst_validate'],
            'Debug' => ['fst_dump', 'fst_dd'],
            'Installation' => ['fst_handle_installation', 'fst_render_status_row', 'fst_show_install_success', 'fst_show_install_form'],
            'Admin' => [
                'fst_admin_check_auth', 'fst_admin_show_login', 'fst_admin_do_login',
                'fst_admin_do_logout', 'fst_admin_render_page', 'fst_admin_show_monitor',
                'fst_admin_show_config', 'fst_admin_save_config', 'fst_admin_show_routes',
                'fst_get_server_info', 'fst_admin_show_server_info', 'fst_admin_show_scan_page',
                'fst_admin_run_scan', 'fst_check_integrity', 'fst_admin_show_integrity', 'fst_admin_show_plugins',
                'fst_admin_install_plugin', 'fst_admin_toggle_plugin', 'fst_admin_uninstall_plugin', 'fst_admin_get_remote_info'
            ]
        ];

        $results = [];
        $php_files = [];

        $scan_dir = function ($dir) use (&$scan_dir, &$php_files) {
            $items = @scandir($dir);
            if ($items === false) return;

            foreach ($items as $item) {
                if ($item === '.' || $item === '..') continue;
                $path = $dir . '/' . $item;
                if (is_dir($path)) {
                    if ($item === 'vendor' || $item === 'node_modules' || $item === '.git') continue;
                    $scan_dir($path);
                } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                    $php_files[] = $path;
                }
            }
        };

        $scan_dir(FST_ROOT_DIR);

        foreach ($php_files as $file_path) {
            $content = @file_get_contents($file_path);
            if ($content === false) continue;

            $found_functions = [];
            if (preg_match_all('/\b(fst_\w+)\s*\(/', $content, $matches)) {
                $found_functions = array_unique($matches[1]);
                sort($found_functions);
            }
            
            $relative_path = str_replace(FST_ROOT_DIR . '/', '', $file_path);
            $results[$relative_path] = [];

            foreach($found_functions as $func_name) {
                $group_found = false;
                foreach ($function_groups as $group_name => $group_funcs) {
                    if (in_array($func_name, $group_funcs)) {
                        $results[$relative_path][$group_name][] = $func_name;
                        $group_found = true;
                        break;
                    }
                }
                if (!$group_found) {
                    $results[$relative_path]['Unknown'][] = $func_name;
                }
            }
             if (isset($results[$relative_path])) {
                 ksort($results[$relative_path]);
             }
        }
        
        fst_flash_set('scan_results', $results);
        fst_redirect($admin_base . '/scan');
    }

    function fst_check_integrity() {
        
        $file_path = FST_ROOT_DIR . '/fullstuck.php';
        if (!file_exists($file_path)) {
            
            $script_path = $_SERVER['SCRIPT_FILENAME'] ?? '';
            if (basename($script_path) === 'fullstuck.php' && file_exists($script_path)) {
                $file_path = $script_path;
            } else {
                return false;
            }
        }
        
        $content = file_get_contents($file_path);
        if (!preg_match('/FST_HASH:\s*([a-f0-9]{64})/', $content, $matches)) return false;
        
        $declared_hash = $matches[1];
        
        
        $parts = preg_split('/ \*\/\r?\n/', $content, 2);
        if (count($parts) !== 2) return false;
        
        $actual_hash = hash('sha256', str_replace("\r\n", "\n", $parts[1]));
        return [
            'valid' => hash_equals($declared_hash, $actual_hash),
            'declared' => $declared_hash,
            'actual' => $actual_hash
        ];
    }

    function fst_admin_show_integrity() {
        fst_admin_check_auth();
        $integrity = fst_check_integrity();
        
        $remote_data = fst_admin_get_remote_info();
        $remote_info = "<i>Not checked</i>";
        
        if ($remote_data && isset($remote_data['hash'])) {
            if ($integrity && $integrity['declared'] === $remote_data['hash']) {
                $remote_info = "<span style='color:green;'>✔ Match with official GitHub registry (v{$remote_data['version']})</span>";
            } else {
                $remote_info = "<span style='color:red;'>❌ Mismatch with official GitHub registry!</span> (Latest: v{$remote_data['version']})";
            }
        } elseif ($remote_data === false) {
            $remote_info = "<span style='color:orange;'>Failed to connect to GitHub</span>";
        }
        
        $html = "<h2>File Integrity Monitoring (FIM)</h2>";
        if (!$integrity) {
            $html .= "<div class='alert-warning'>Cannot perform integrity check. <code>fullstuck.php</code> not found or malformed header.</div>";
        } else {
            if ($integrity['valid']) {
                $html .= "<div style='color:green; font-size:1.2em; margin-bottom:10px;'>✔ Local Integrity OK: The core file has not been tampered with.</div>";
            } else {
                $html .= "<div style='color:red; font-size:1.2em; font-weight:bold; margin-bottom:10px;'>❌ Local Integrity FAILED: The core file has been modified!</div>";
            }
            $html .= "<ul>";
            $html .= "<li><strong>Declared Hash (Line 1):</strong> <code>{$integrity['declared']}</code></li>";
            $html .= "<li><strong>Actual Content Hash:</strong> <code>{$integrity['actual']}</code></li>";
            $html .= "<li><strong>Remote Verification:</strong> {$remote_info}</li>";
            $html .= "</ul>";
        }
        
        fst_admin_render_page('Integrity Check', $html);
    }

    function fst_admin_show_plugins() {
        fst_admin_check_auth();
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';
        $csrf = fst_csrf_field();
        
        
        $plugin_dir = FST_ROOT_DIR . '/fst-plugins';
        $local_plugins = [];
        if (is_dir($plugin_dir)) {
            $files = scandir($plugin_dir);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $is_disabled = str_ends_with($file, '.disabled');
                if (str_ends_with($file, '.php') || $is_disabled) {
                    $local_plugins[] = [
                        'filename' => $file,
                        'name' => str_replace(['.php', '.disabled'], '', $file),
                        'active' => !$is_disabled
                    ];
                }
            }
        }

        $html = "<h2>Installed Plugins</h2>";
        if (empty($local_plugins)) {
            $html .= "<p>No plugins installed yet.</p>";
        } else {
            $html .= "<table><thead><tr><th>Plugin Name</th><th>Status</th><th>Actions</th></tr></thead><tbody>";
            foreach ($local_plugins as $p) {
                $status = $p['active'] ? '<span style="color:green;">✔ Active</span>' : '<span style="color:gray;">○ Inactive</span>';
                $toggle_text = $p['active'] ? 'Disable' : 'Enable';
                $toggle_style = $p['active'] ? 'background:#6c757d;' : 'background:#28a745;';
                
                $html .= "<tr>";
                $html .= "<td><strong>" . htmlspecialchars($p['name']) . "</strong><br><small style='color:#666;'>" . htmlspecialchars($p['filename']) . "</small></td>";
                $html .= "<td>{$status}</td>";
                $html .= "<td>
                    <form action='{$admin_base}/plugins/toggle' method='POST' style='display:inline;' data-fst-no-spa>
                        {$csrf}
                        <input type='hidden' name='filename' value='" . htmlspecialchars($p['filename']) . "'>
                        <button type='submit' style='{$toggle_style}'>{$toggle_text}</button>
                    </form>
                    <form action='{$admin_base}/plugins/uninstall' method='POST' style='display:inline;' data-fst-no-spa onsubmit='return confirm(\"Are you sure you want to uninstall this plugin?\")'>
                        {$csrf}
                        <input type='hidden' name='filename' value='" . htmlspecialchars($p['filename']) . "'>
                        <button type='submit' style='background:#dc3545;'>Uninstall</button>
                    </form>
                </td>";
                $html .= "</tr>";
            }
            $html .= "</tbody></table>";
        }

        
        $remote_store_url = "https://raw.githubusercontent.com/milio48/fullstuck/main/store.json";
        $local_store_file = FST_ROOT_DIR . '/store.json';
        $store_plugins = [];
        $is_remote = false;

        $ctx = stream_context_create(['http' => ['timeout' => 5]]);
        $remote_json = @file_get_contents($remote_store_url, false, $ctx);
        if ($remote_json) {
            $store_plugins = json_decode($remote_json, true) ?: [];
            $is_remote = true;
        } elseif (file_exists($local_store_file)) {
            $store_plugins = json_decode(file_get_contents($local_store_file), true) ?: [];
        }
        
        $source_label = $is_remote ? "<span style='color:green;'>GitHub Store</span>" : "<span style='color:orange;'>Local Registry</span>";

        $html .= "<br><hr><h2>Plugin Store <small style='font-size:14px; font-weight:normal;'>({$source_label})</small></h2>";
        
        if (empty($store_plugins)) {
            $html .= "<p>No plugins found in store.</p>";
        } else {
            $html .= "<table><thead><tr><th>Plugin Name</th><th>Description</th><th>Action</th></tr></thead><tbody>";
            foreach ($store_plugins as $plugin) {
                $id = $plugin['id'] ?? '';
                $is_installed = false;
                foreach ($local_plugins as $lp) {
                    if ($lp['name'] === $id) { $is_installed = true; break; }
                }
                
                $btn_text = $is_installed ? 'Re-install' : 'Install';
                $btn_style = $is_installed ? 'background:#6c757d;' : 'background:#28a745;';
                
                $html .= "<tr>";
                $html .= "<td><strong>" . htmlspecialchars($plugin['name'] ?? 'Unknown') . "</strong><br><small style='color:#666;'>ID: " . htmlspecialchars($id) . "</small></td>";
                $html .= "<td>" . htmlspecialchars($plugin['description'] ?? '') . "</td>";
                $html .= "<td>
                    <form action='{$admin_base}/plugins/install' method='POST' style='display:inline;' data-fst-no-spa>
                        {$csrf}
                        <input type='hidden' name='id' value='" . htmlspecialchars($id) . "'>
                        <button type='submit' style='{$btn_style}'>{$btn_text}</button>
                    </form>
                </td>";
                $html .= "</tr>";
            }
            $html .= "</tbody></table>";
        }
        
        fst_admin_render_page('Plugin Manager', $html);
    }

    function fst_admin_toggle_plugin() {
        fst_admin_check_auth();
        fst_csrf_check();
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';

        $filename = basename($_POST['filename'] ?? '');
        $plugin_dir = FST_ROOT_DIR . '/fst-plugins';
        $path = $plugin_dir . '/' . $filename;

        if (!empty($filename) && file_exists($path)) {
            if (str_ends_with($filename, '.disabled')) {
                $new_path = str_replace('.disabled', '', $path);
                rename($path, $new_path);
                fst_flash_set('success_message', 'Plugin enabled.');
            } else {
                $new_path = $path . '.disabled';
                rename($path, $new_path);
                fst_flash_set('success_message', 'Plugin disabled.');
            }
        }
        fst_redirect($admin_base . '/plugins');
    }

    function fst_admin_uninstall_plugin() {
        fst_admin_check_auth();
        fst_csrf_check();
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';

        $filename = basename($_POST['filename'] ?? '');
        $plugin_dir = FST_ROOT_DIR . '/fst-plugins';
        $path = $plugin_dir . '/' . $filename;

        if (!empty($filename) && file_exists($path)) {
            unlink($path);
            fst_flash_set('success_message', 'Plugin uninstalled successfully.');
        }
        fst_redirect($admin_base . '/plugins');
    }

    function fst_admin_install_plugin() {
        fst_admin_check_auth();
        fst_csrf_check();
        $fst_config = fst_app('config');
        $admin_base = $fst_config['admin']['page_url'] ?? '/stuck';

        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            fst_flash_set('error_message', 'Invalid plugin ID.');
            fst_redirect($admin_base . '/plugins');
        }
        
        
        $clean_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $id);
        $url = "https://raw.githubusercontent.com/milio48/fullstuck/refs/heads/main/store/fst-" . $clean_id . ".php";

        
        $plugin_dir = FST_ROOT_DIR . '/fst-plugins';
        if (!is_dir($plugin_dir)) {
            if (!mkdir($plugin_dir, 0755, true)) {
                fst_flash_set('error_message', 'Failed to create fst-plugins directory.');
                fst_redirect($admin_base . '/plugins');
            }
        }

        
        $ctx = stream_context_create(['http' => ['timeout' => 10]]);
        $content = @file_get_contents($url, false, $ctx);
        if ($content === false || strpos(trim($content), '<?php') !== 0) {
            fst_flash_set('error_message', 'Invalid plugin file or failed to download from GitHub.');
        } else {
            $filename = $plugin_dir . '/fst-' . $clean_id . '.php';
            if (file_put_contents($filename, $content) !== false) {
                fst_flash_set('success_message', 'Plugin ' . htmlspecialchars($id) . ' installed successfully!');
            } else {
                fst_flash_set('error_message', 'Failed to save plugin file. Check permissions.');
            }
        }

        fst_redirect($admin_base . '/plugins');
    }

}

// FILE: template.php
function fst_template(string $templatePath, array $data, array $rules, ?string $cacheDir = null, bool $forceRebuild = false): void {
    if ($cacheDir === null) {
        $cacheDir = defined('FST_ROOT_DIR') ? FST_ROOT_DIR . '/view-cache' : sys_get_temp_dir() . '/fst_view_cache';
    }
    
    if (!file_exists($templatePath)) {
        throw new \RuntimeException("Template not found: {$templatePath}");
    }

    if (!file_exists($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }
    
    $base = defined('FST_ROOT_DIR') ? FST_ROOT_DIR : '';
    $relative_path = str_replace([$base, '/', '\\', ':'], ['', '__', '__', ''], $templatePath);
    $relative_path = ltrim($relative_path, '_');
    $cacheFile = $cacheDir . '/' . $relative_path . '.php';

    
    if ($forceRebuild || !file_exists($cacheFile) || filemtime($templatePath) > filemtime($cacheFile)) {
        
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $html = file_get_contents($templatePath);
        if ($html) {
            
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        }
        libxml_clear_errors();
        
        $xpath = new DOMXPath($dom);
        $replacements = [];
        $markerCount = 0;
        
        
        $getMarker = function() use (&$markerCount) {
            $markerCount++;
            return "@@__FST_MARKER_{$markerCount}__@@";
        };

        $css2xpath = function(string $selector): string {
            $selector = trim($selector);
            
            
            if (str_starts_with($selector, '//') || str_starts_with($selector, './/')) {
                return $selector;
            }
            
            
            if (strpos($selector, ':') !== false || strpos($selector, '+') !== false || strpos($selector, '~') !== false) {
                return './/FST_BLACKLISTED_NODE';
            }
            
            $paths = [];
            foreach (explode(',', $selector) as $sel) {
                $sel = trim($sel);
                $sel = preg_replace('/\s*>\s*/', '/', $sel); 
                $sel = preg_replace('/\s+/', '//', $sel); 
                $sel = preg_replace('/#([\w\-]+)/', '[@id="$1"]', $sel); 
                $sel = preg_replace('/\.([\w\-]+)/', '[contains(concat(" ", normalize-space(@class), " "), " $1 ")]', $sel); 
                
                
                $sel = preg_replace('/\[([\w\-]+)=([\'"]?.*?[\'"]?)\]/', '[@$1=$2]', $sel);
                
                $sel = preg_replace('/\[([\w\-]+)\]/', '[@$1]', $sel);
                
                $sel = preg_replace('/(^|\/|\|)(\[)/', '$1*$2', $sel);
                
                
                if (!str_starts_with($sel, '/') && !str_starts_with($sel, '.')) {
                    $sel = './/' . $sel;
                }
                
                $paths[] = $sel;
            }
            return implode(' | ', $paths);
        };

        
        $applyRules = function(array $currentRules, ?DOMNode $context = null) use (&$applyRules, $xpath, &$replacements, $getMarker, $dom, $css2xpath) {
            foreach ($currentRules as $key => $value) {
                
                
                if (str_starts_with($key, '[') && str_ends_with($key, ']')) {
                    if ($context instanceof DOMElement) {
                        $attrName = substr($key, 1, -1);
                        if ($value === '@remove') {
                            $context->removeAttribute($attrName);
                        } else {
                            $marker = $getMarker();
                            $context->setAttribute($attrName, $marker);
                            $replacements[$marker] = "<?= htmlspecialchars({$value} ?? '', ENT_QUOTES, 'UTF-8') ?>";
                        }
                    }
                    continue;
                }

                
                if (str_starts_with($key, '@')) {
                    continue;
                }

                
                $isSingleSelection = false;
                if (str_starts_with($key, '^')) {
                    $isSingleSelection = true;
                    $key = substr($key, 1);
                }

                $xpathSel = $css2xpath($key);
                $nodes = $xpath->query($xpathSel, $context ?? $dom);
                
                if ($nodes === false || $nodes->length === 0) continue;

                $targetNodes = [];
                if ($isSingleSelection) {
                    $targetNodes[] = $nodes->item(0);
                } else {
                    foreach ($nodes as $n) $targetNodes[] = $n;
                }

                
                if (is_string($value)) {
                    if ($value === '@remove') {
                        foreach ($targetNodes as $node) {
                            $node->parentNode->removeChild($node);
                        }
                        continue;
                    }

                    foreach ($targetNodes as $node) {
                        $marker = $getMarker();
                        $node->nodeValue = $marker;
                        $replacements[$marker] = "<?= htmlspecialchars({$value} ?? '', ENT_QUOTES, 'UTF-8') ?>";
                    }
                } 
                
                elseif (is_array($value)) {
                    
                    if (isset($value['@if'])) {
                        foreach ($targetNodes as $node) {
                            $startMarker = $getMarker();
                            $endMarker = $getMarker();
                            
                            $replacements[$startMarker] = "<?php if ({$value['@if']}): ?>";
                            $replacements[$endMarker] = "<?php endif; ?>";
                            
                            $startTextNode = $dom->createTextNode($startMarker);
                            $endTextNode = $dom->createTextNode($endMarker);
                            
                            $node->parentNode->insertBefore($startTextNode, $node);
                            if ($node->nextSibling) {
                                $node->parentNode->insertBefore($endTextNode, $node->nextSibling);
                            } else {
                                $node->parentNode->appendChild($endTextNode);
                            }
                        }
                        unset($value['@if']);
                    }

                    if (isset($value['@text'])) {
                        
                        foreach ($targetNodes as $node) {
                            $marker = $getMarker();
                            $node->nodeValue = $marker;
                            $replacements[$marker] = "<?= htmlspecialchars({$value['@text']} ?? '', ENT_QUOTES, 'UTF-8') ?>";
                        }
                        unset($value['@text']);
                    }

                    if (isset($value['@html'])) {
                        
                        foreach ($targetNodes as $node) {
                            $marker = $getMarker();
                            $node->nodeValue = $marker;
                            $replacements[$marker] = "<?= {$value['@html']} ?? '' ?>";
                        }
                        unset($value['@html']);
                    }

                    if (isset($value['@append'])) {
                        
                        foreach ($targetNodes as $node) {
                            $marker = $getMarker();
                            $replacements[$marker] = "<?= {$value['@append']} ?? '' ?>";
                            $node->appendChild($dom->createTextNode($marker));
                        }
                        unset($value['@append']);
                    }

                    if (isset($value['@prepend'])) {
                        
                        foreach ($targetNodes as $node) {
                            $marker = $getMarker();
                            $replacements[$marker] = "<?= {$value['@prepend']} ?? '' ?>";
                            $node->insertBefore($dom->createTextNode($marker), $node->firstChild);
                        }
                        unset($value['@prepend']);
                    }

                    if (isset($value['@foreach'])) {
                        
                        $templateNode = $nodes->item(0);
                        $container = $templateNode->parentNode;
                        
                        $foreachStr = $value['@foreach'];
                        unset($value['@foreach']); 
                        
                        $startMarker = $getMarker();
                        $endMarker = $getMarker();
                        
                        $replacements[$startMarker] = "<?php foreach ({$foreachStr}): ?>";
                        $replacements[$endMarker] = "<?php endforeach; ?>";
                        
                        
                        $container->insertBefore($dom->createTextNode($startMarker), $templateNode);
                        if ($templateNode->nextSibling) {
                            $container->insertBefore($dom->createTextNode($endMarker), $templateNode->nextSibling);
                        } else {
                            $container->appendChild($dom->createTextNode($endMarker));
                        }
                        
                        
                        for ($i = 1; $i < $nodes->length; $i++) {
                            $nodeToRemove = $nodes->item($i);
                            if ($nodeToRemove->parentNode) {
                                $nodeToRemove->parentNode->removeChild($nodeToRemove);
                            }
                        }
                        
                        
                        if (!empty($value)) {
                            $applyRules($value, $templateNode);
                        }
                        
                    } else {
                        
                        if (!empty($value)) {
                            foreach ($targetNodes as $node) {
                                $applyRules($value, $node);
                            }
                        }
                    }
                }
            }
        };

        
        $applyRules($rules);
        
        $htmlOut = $dom->saveHTML();
        
        $htmlOut = str_replace('<?xml encoding="utf-8" ?>', '', $htmlOut);
        
        
        foreach ($replacements as $marker => $phpCode) {
            $htmlOut = str_replace($marker, $phpCode, $htmlOut);
        }
        
        file_put_contents($cacheFile, $htmlOut);
    }

    
    $shared_data = function_exists('fst_app') ? (fst_app('shared_view_data') ?? []) : [];
    $data = array_merge($shared_data, $data);
    extract($data, EXTR_SKIP);
    require $cacheFile;
}

// FILE: bootstrap.php
$fst_config = fst_app('config');


if (php_sapi_name() !== 'cli' && strpos($_SERVER['REQUEST_URI'], 'fullstuck.php') !== false) {
    http_response_code(500);
    die('
        <div style="font-family: system-ui, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #ff4444; border-radius: 8px; background: #fff1f1; color: #333;">
            <h2 style="color: #d32f2f; margin-top: 0;">🚨 Routing Misconfigured!</h2>
            <p>Framework mendeteksi <code>fullstuck.php</code> di dalam URL. Ini menandakan URL Rewriting di web server Anda belum aktif.</p>
            <p><strong>Solusi:</strong> Pastikan Anda menggunakan web server yang mendukung single-entry routing (Apache dengan .htaccess, Nginx, atau FrankenPHP). Silakan baca dokumentasi FullStuck bagian Deployment.</p>
        </div>
    ');
}


$plugin_dir = FST_ROOT_DIR . '/fst-plugins';
if (is_dir($plugin_dir)) {
    foreach (glob($plugin_dir . '/fst-*.php') as $plugin) {
        require_once $plugin;
    }
}


$require_items = $fst_config['routing']['require'] ?? [];
foreach ($require_items as $item) {
    $raw_path = FST_ROOT_DIR . '/' . ltrim($item, '/');
    
    
    if (is_dir($raw_path)) {
        $raw_path = rtrim($raw_path, '/\\') . DIRECTORY_SEPARATOR . '*.php';
    }
    
    
    $matched_files = glob($raw_path);
    if ($matched_files) {
        foreach ($matched_files as $file) {
            $real_path = realpath($file);
            
            if ($real_path && str_starts_with($real_path, realpath(FST_ROOT_DIR)) && is_file($real_path) && str_ends_with($real_path, '.php')) {
                require_once $real_path;
            }
        }
    }
}


$routes_files = (array) ($fst_config['routing']['routes_file'] ?? ['router.php']);
foreach ($routes_files as $file) {
    if (file_exists(FST_ROOT_DIR . '/' . $file)) {
        require FST_ROOT_DIR . '/' . $file;
    } elseif (!fst_is_dev()) {
        fst_abort(500, "Configuration Error: Routes file not found at '{$file}'");
    }
}


if (php_sapi_name() !== 'cli') {
    fst_run();
}
