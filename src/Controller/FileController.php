<?php

namespace Persona\Hris\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class FileController extends Controller
{
    /**
     * @ApiDoc(
     *     section="File Uploaded",
     *     description="Get uploaded file"
     * )
     *
     * @Route(name="get_file", path="/files/{path}", requirements={"path"=".+"})
     *
     * @Method({"GET"})
     *
     * @param string $path
     *
     * @return Response
     */
    public function getFileAction($path)
    {
        $fullPath = sprintf('%s/%s', $this->container->getParameter('persona.upload_dir'), $path);
        $file = file_get_contents($fullPath);
        if ($file) {
            $response = new Response();

            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-type', mime_content_type($fullPath));
            $response->headers->set('Content-length', filesize($fullPath));

            $response->sendHeaders();
            $response->setContent($file);

            return $response;
        } else {
            throw new NotFoundHttpException();
        }
    }
}
