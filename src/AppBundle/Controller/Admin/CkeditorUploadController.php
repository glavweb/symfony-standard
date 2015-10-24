<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Validator\SimpleFileUpload;
use FileUpload\FileUpload;
use FileUpload\PathResolver\Simple as PathResolverSimple;
use FileUpload\FileSystem\Simple as FileSystemSimple;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CkeditorUploadController
 * @package AppBundle\Controller\Admin
 */
class CkeditorUploadController extends Controller
{
    /**
     * @Route("/ckupload", name="file_upload")
     */
    public function ckuploadAction(Request $request)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->createAccessDeniedException();
        }

        if (!isset($_FILES['upload'])) {
            $this->createNotFoundException();
        }

        $funcNum    = $request->get('CKEditorFuncNum');
        $uploadType = $request->get('type',  'file');

        if ($uploadType == 'image') {
            $allowedMimeTypes = array(
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/png'
            );
        } else {
            $allowedMimeTypes = array(
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/pdf',
                'application/x-tar',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/zip, application/x-compressed-zip'
            );
        }

        $validator = new SimpleFileUpload(1024 * 1024 * 4, $allowedMimeTypes);
        $validator->setMessages(
            array(
                SimpleFileUpload::UPLOAD_ERR_BAD_TYPE  => 'Тип файла не поддерживается',
                SimpleFileUpload::UPLOAD_ERR_TOO_LARGE => 'Размер файла слишком велик',
            )
        );

        $fileUpload = new FileUpload($_FILES['upload'], $_SERVER);
        $fileUpload->setPathResolver(new PathResolverSimple('uploads/content'));
        $fileUpload->setFileSystem(new FileSystemSimple());
        $fileUpload->addValidator($validator);
//        $fileUpload->setFileNameGenerator(new \FileUpload\FileNameGenerator\Simple());

        list($files, $headers) = $fileUpload->processAll();
        $url = null;
        $errorMessage = "Ошибка при загрузке файла на сервер. Файл слишком велик или слишком мал.";
        if (isset($files[0])) {
            $errorMessage = $files[0]->error !== 0 ? $files[0]->error : null;

            if (!$errorMessage) {
                $url = '/' . $files[0]->path;
            }
        }

        return new Response("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$errorMessage');</script>");
    }
}