<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class LimitImageUploadSize
{
    private const MAX_IMAGE_BYTES = 5 * 1024 * 1024; // 5 Mo

    public function handle(Request $request, Closure $next): Response
    {
        $oversized = [];

        $files = $request->allFiles();
        if (!empty($files)) {
            foreach ($this->flattenFiles($files) as $file) {
                if (!$file instanceof UploadedFile) {
                    continue;
                }

                // If PHP already marked it invalid (e.g. upload_max_filesize), let controllers handle.
                if (!$file->isValid()) {
                    continue;
                }

                $mime = $file->getMimeType() ?? '';
                $clientMime = $file->getClientMimeType() ?? '';
                $ext = strtolower((string) ($file->getClientOriginalExtension() ?? ''));

                $isImage = (
                    ($mime !== '' && str_starts_with($mime, 'image/'))
                    || ($clientMime !== '' && str_starts_with($clientMime, 'image/'))
                    || in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'heic', 'heif', 'avif'], true)
                );

                if ($isImage && ($file->getSize() ?? 0) > self::MAX_IMAGE_BYTES) {
                    $oversized[] = [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                    ];
                }
            }
        }

        if (!empty($oversized)) {
            $message = 'Chaque image doit faire au maximum 5 Mo.';

            if ((method_exists($request, 'expectsJson') && $request->expectsJson()) || (method_exists($request, 'ajax') && $request->ajax())) {
                return response()->json([
                    'success' => false,
                    'error' => 'image_too_large',
                    'message' => $message,
                    'max_bytes' => self::MAX_IMAGE_BYTES,
                    'files' => $oversized,
                ], 422);
            }

            return redirect()->back()->withErrors(['image' => $message])->withInput();
        }

        return $next($request);
    }

    /**
     * @param array<string, mixed> $files
     * @return array<int, mixed>
     */
    private function flattenFiles(array $files): array
    {
        $flat = [];
        array_walk_recursive($files, function ($value) use (&$flat): void {
            $flat[] = $value;
        });
        return $flat;
    }
}
