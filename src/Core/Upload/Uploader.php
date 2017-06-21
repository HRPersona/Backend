<?php

namespace Persona\Hris\Core\Upload;

use Persona\Hris\Core\Util\StringUtil;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class Uploader
{
    /**
     * @var string
     */
    private $uploadDir;

    /**
     * @param string $uploadDir
     */
    public function __construct(string $uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    /**
     * @param UploadableInterface $uploadable
     */
    public function upload(UploadableInterface $uploadable)
    {
        $file = base64_decode($uploadable->getImageString());
        if ($file) {
            $uploadDir = sprintf('%s/%s', $this->uploadDir, $uploadable->getDirectoryPrefix());
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = sprintf('%s.%s', StringUtil::randomize(date('YmdHis')), $uploadable->getImageExtension());
            file_put_contents(sprintf('%s/%s', $uploadDir, $fileName), $file);

            $setterMethod = StringUtil::camelcase(sprintf('set_%s', StringUtil::underscore($uploadable->getTargetField())));
            try {
                call_user_func_array([$uploadable, $setterMethod], [$fileName]);
            } catch (\Exception $e) {
                throw new UploadException(sprintf('Field %s is not defined on %s', $uploadable->getTargetField(), get_class($uploadable)));
            }
        }
    }

    /**
     * @param UploadableInterface $uploadable
     *
     * @return string
     */
    public function getUploadedFile(UploadableInterface $uploadable): string
    {
        $getterMethod = StringUtil::camelcase(sprintf('get_%s', StringUtil::underscore($uploadable->getTargetField())));

        return file_get_contents(sprintf('%s/%s/%s', $this->uploadDir, $uploadable->getDirectoryPrefix(), call_user_func_array([$uploadable, $getterMethod], [])));
    }
}
