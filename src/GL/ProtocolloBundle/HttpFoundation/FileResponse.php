<?php

namespace GL\ProtocolloBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Response FILE.
 *
 */
class FileResponse extends Response {

    const INLINE = 'inline';
    const ATTACHMENT = 'attachment';

    /**
     * @return FileResponse
     */
    public static function createFromFile($filePath = '', $contentDisposition = FileResponse::INLINE) {
        $response = new static();
        $response->setFile($filePath, $contentDisposition);

        return $response;
    }

    /**
     * @return FileResponse
     */
    public static function createFromContent($content, $filename, $contentType, $contentDisposition = FileResponse::INLINE) {
        $response = new static();
        $response->setFileRaw($content, $filename, $contentType, $contentDisposition);

        return $response;
    }

    public function setFileRaw($content, $filename, $contentType, $contentDisposition = FileResponse::INLINE) {
        $this->setContentType($contentType);
        $this->setContentDisposition($contentDisposition, $filename);
        $this->setContent($content);

        return $this;
    }

    public function setFile($filePath, $contentDisposition = FileResponse::INLINE) {
        $file = new File($filePath);
        $this->setContentType($file->getMimeType());
        $this->setContentDisposition($contentDisposition, $file->getFilename());
        $this->setContent(file_get_contents($filePath));

        return $this;
    }

    public function setContentType($contentType) {
        $this->headers->set('Content-Type', $contentType);

        return $this;
    }

    public function setContentDisposition($contentDisposition, $fileName) {
        if (!in_array($contentDisposition, array(FileResponse::INLINE, FileResponse::ATTACHMENT))) {
            throw new \Exception('Errore');
        }

        $this->headers->set('Content-Disposition', $contentDisposition . "; filename*=UTF-8''" . rawurlencode($fileName));

        return $this;
    }
}
