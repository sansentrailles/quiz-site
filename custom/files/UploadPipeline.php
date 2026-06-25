<?php

declare(strict_types=1);

namespace app\custom\files;

use Yii;
use yii\web\UploadedFile;
use Imagine\Image\ImagineInterface;
use Imagine\Gd\Imagine as GdImagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

class UploadPipeline
{
    private UploadedFile $file;
    private string $tempPath;
    private array $transforms = [];
    private ?ImagineInterface $imagine = null;

    private function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->tempPath = $file->tempName;
    }

    public static function make(UploadedFile $file): self
    {
        return new self($file);
    }

    public function resize(int $width, int $height = 0): self
    {
        $this->transforms[] = function (string $path) use ($width, $height): string {
            $img = $this->imagine()->open($path);
            $size = $img->getSize();
            $origW = $size->getWidth();
            $origH = $size->getHeight();

            if ($height === 0) {
                $ratio = $origH / $origW;
                $height = (int) round($width * $ratio);
            }

            $img->resize(new Box($width, $height))->save($path);

            return $path;
        };

        return $this;
    }

    public function quality(int $quality): self
    {
        $this->transforms[] = function (string $path) use ($quality): string {
            $img = $this->imagine()->open($path);
            $img->save($path, ['quality' => $quality]);

            return $path;
        };

        return $this;
    }

    public function thumbnail(int $width, int $height, string $mode = ImageInterface::THUMBNAIL_OUTBOUND): self
    {
        $this->transforms[] = function (string $path) use ($width, $height, $mode): string {
            $img = $this->imagine()->open($path);
            $img->thumbnail(new Box($width, $height), $mode)->save($path);

            return $path;
        };

        return $this;
    }

    public function callable(callable $fn): self
    {
        $this->transforms[] = $fn;

        return $this;
    }

    public function save(string $bucket): string
    {
        $fileName = $this->generateName();
        $tempDir = Yii::getAlias('@runtime') . '/tempUploads';

        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $tempFile = $tempDir . '/' . $fileName;
        copy($this->file->tempName, $tempFile);

        foreach ($this->transforms as $transform) {
            $result = $transform($tempFile);
            if (is_string($result)) {
                $tempFile = $result;
            }
        }

        Storage::save($bucket, $tempFile, $fileName);

        if (file_exists($tempFile) && $tempFile !== $this->file->tempName) {
            unlink($tempFile);
        }

        return $fileName;
    }

    private function generateName(): string
    {
        $ext = pathinfo($this->file->name, PATHINFO_EXTENSION);
        $hash = random_int(100000, 999999) . md5(microtime() . $this->file->name);

        return $hash . '.' . $ext;
    }

    private function imagine(): ImagineInterface
    {
        if ($this->imagine === null) {
            $this->imagine = new GdImagine();
        }

        return $this->imagine;
    }
}
