<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MinifyAssets extends Command
{
    protected $signature = 'assets:minify {--source= : Source directory containing built assets (default: public\\build\\assets)} {--dest= : Destination directory for minified files (default: same as source)} {--force : Overwrite existing .min files}';

    protected $description = 'Minify already-built CSS and JS files (e.g., from Vite) and generate .min.css and .min.js without rebuilding.';

    public function handle(): int
    {
        $defaultSource = public_path('build'.DIRECTORY_SEPARATOR.'assets');
        $source = $this->option('source') ?: $defaultSource;
        $dest = $this->option('dest') ?: $source;
        $force = (bool) $this->option('force');

        if (!is_dir($source)) {
            $this->error("Source directory not found: {$source}");
            $this->line('Make sure you have run the production build (e.g., npm run build) and that assets are located under public\\build\\assets.');
            return self::FAILURE;
        }
        if (!is_dir($dest)) {
            if (!@mkdir($dest, 0775, true) && !is_dir($dest)) {
                $this->error("Failed to create destination directory: {$dest}");
                return self::FAILURE;
            }
        }

        $cssFiles = glob($source.DIRECTORY_SEPARATOR.'*.css');
        $jsFiles = glob($source.DIRECTORY_SEPARATOR.'*.js');

        if (empty($cssFiles) && empty($jsFiles)) {
            $this->warn('No CSS or JS files found to minify in: '.$source);
            return self::SUCCESS;
        }

        $total = 0; $minified = 0; $skipped = 0; $errors = 0;

        // Ensure minifier classes are available
        $hasPhpMinify = class_exists('MatthiasMullie\\Minify\\JS');
        if (!$hasPhpMinify) {
            $this->warn('MatthiasMullie/minify is not installed. Attempting basic inline minification as fallback.');
        }

        $processFile = function (string $file, string $type) use ($dest, $force, $hasPhpMinify, &$minified, &$skipped, &$errors) {
            $basename = basename($file);
            // Skip already minified outputs and sourcemaps
            if (Str::endsWith($basename, ['.min.css', '.min.js', '.map'])) {
                return;
            }

            $target = $dest.DIRECTORY_SEPARATOR.preg_replace('/\\.(css|js)$/i', '.min.$1', $basename);

            if (!$force && file_exists($target)) {
                $skipped++;
                return;
            }

            $content = @file_get_contents($file);
            if ($content === false) {
                $errors++;
                return;
            }

            try {
                if ($hasPhpMinify) {
                    if ($type === 'css') {
                        $minifier = new \MatthiasMullie\Minify\CSS();
                    } else {
                        $minifier = new \MatthiasMullie\Minify\JS();
                    }
                    $minifier->add($content);
                    $minifiedContent = $minifier->minify();
                } else {
                    // Very basic fallback: remove comments and extra whitespace
                    $minifiedContent = self::basicMinify($content, $type);
                }

                if (@file_put_contents($target, $minifiedContent) === false) {
                    $errors++;
                } else {
                    $minified++;
                }
            } catch (\Throwable $e) {
                $errors++;
            }
        };

        foreach ($cssFiles as $file) { $total++; $processFile($file, 'css'); }
        foreach ($jsFiles as $file) { $total++; $processFile($file, 'js'); }

        $this->info("Processed: {$total}, Minified: {$minified}, Skipped: {$skipped}, Errors: {$errors}");
        $this->line('Source: '.$source);
        $this->line('Destination: '.$dest);

        return $errors === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected static function basicMinify(string $content, string $type): string
    {
        // Remove /* */ comments
        $content = preg_replace('#/\*.*?\*/#s', '', $content) ?? $content;
        if ($type === 'js') {
            // Remove // comments (not inside strings - naive)
            $content = preg_replace('#(^|\s)//.*$#m', '$1', $content) ?? $content;
        }
        // Collapse whitespace
        $content = preg_replace('/\s+/', ' ', $content) ?? $content;
        // Remove space around certain symbols
        $content = preg_replace('/\s*([{};:,=\(\)\[\]\+\-\*\/<>&\|])\s*/', '$1', $content) ?? $content;
        // Trim
        return trim($content);
    }
}
