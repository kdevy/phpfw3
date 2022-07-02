<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

use LFW\Request\Request;
use RuntimeException;

/**
 * ファイルサイズ上限を超えていないか
 */
class FileSizeValidator extends Validator
{
    /**
     * @param int $max_byte
     * @param string $unit
     * @param string $name
     * @param Request $request
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $max_byte,
        protected string $unit,
        protected string $name,
        protected Request $request,
        protected string $message = "%{placeholder}のファイルサイズは{max_byte}が上限です。",
        protected array $contexts = []
    ) {
        $post_max_size = $this->parse_size(ini_get('post_max_size'));
        $upload_max_filesize = $this->parse_size(ini_get('upload_max_filesize'));

        if ($max_byte > $post_max_size) {
            throw new RuntimeException("ファイルサイズ上限({$max_byte})は'post_max_size'({$post_max_size})以下の値を設定してください。");
        }
        if ($max_byte > $upload_max_filesize) {
            throw new RuntimeException("ファイルサイズ上限({$max_byte})は'upload_max_filesize'({$upload_max_filesize})以下の値を設定してください。");
        }

        $this->contexts["max_byte"] = roundByte($this->max_byte, $this->unit);
    }

    public function parse_size($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = (float)preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        $files = $this->request->getFiles();
        $file = $files[$this->name] ?? null;
        if (!$file) {
            return true;
        }
        return $file["size"] <= $this->max_byte;
    }
}
