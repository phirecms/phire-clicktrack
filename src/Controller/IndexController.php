<?php
/**
 * Phire ClickTrack Module
 *
 * @link       https://github.com/phirecms/phire-clicktrack
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Phire\ClickTrack\Controller;

use Phire\ClickTrack\Model;
use Phire\Controller\AbstractController;

/**
 * Clicks Index Controller class
 *
 * @category   Phire\ClickTrack
 * @package    Phire\ClickTrack
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 * @version    1.0.0
 */
class IndexController extends AbstractController
{

    /**
     * Mime types
     * @var array
     */
    protected $mimes = [
        'aif'    => 'audio/x-aiff',
        'aiff'   => 'audio/x-aiff',
        'avi'    => 'video/x-msvideo',
        'bmp'    => 'image/x-ms-bmp',
        'bz2'    => 'application/bzip2',
        'css'    => 'text/css',
        'csv'    => 'text/csv',
        'doc'    => 'application/msword',
        'docx'   => 'application/msword',
        'eps'    => 'application/octet-stream',
        'fla'    => 'application/octet-stream',
        'flv'    => 'application/octet-stream',
        'gif'    => 'image/gif',
        'gz'     => 'application/x-gzip',
        'jpe'    => 'image/jpeg',
        'jpg'    => 'image/jpeg',
        'jpeg'   => 'image/jpeg',
        'js'     => 'text/plain',
        'json'   => 'text/plain',
        'log'    => 'text/plain',
        'md'     => 'text/plain',
        'mov'    => 'video/quicktime',
        'mp2'    => 'audio/mpeg',
        'mp3'    => 'audio/mpeg',
        'mp4'    => 'video/mp4',
        'mpg'    => 'video/mpeg',
        'mpeg'   => 'video/mpeg',
        'pdf'    => 'application/pdf',
        'pgsql'  => 'text/plain',
        'png'    => 'image/png',
        'ppt'    => 'application/msword',
        'pptx'   => 'application/msword',
        'psd'    => 'image/x-photoshop',
        'sql'    => 'text/plain',
        'svg'    => 'image/svg+xml',
        'swf'    => 'application/x-shockwave-flash',
        'tar'    => 'application/x-tar',
        'tbz'    => 'application/bzip2',
        'tbz2'   => 'application/bzip2',
        'tgz'    => 'application/x-gzip',
        'tif'    => 'image/tiff',
        'tiff'   => 'image/tiff',
        'tsv'    => 'text/tsv',
        'txt'    => 'text/plain',
        'wav'    => 'audio/x-wav',
        'wma'    => 'audio/x-ms-wma',
        'wmv'    => 'audio/x-ms-wmv',
        'xls'    => 'application/msword',
        'xlsx'   => 'application/msword',
        'xml'    => 'application/xml',
        'yaml'   => 'text/plain',
        'yml'    => 'text/plain',
        'zip'    => 'application/x-zip'
    ];

    /**
     * Download action method
     *
     * @param  int $id
     * @return void
     */
    public function download($id)
    {
        if ($this->application->isRegistered('phire-media')) {
            $media = new \Phire\Media\Model\Media();
            $media->getById($id);

            if (isset($media->id)) {
                $click = new Model\Click();
                $click->saveMedia($media->file);
                $ext  = strtolower(substr($media->file, (strrpos($media->file, '.') + 1)));
                $mime = (isset($this->mimes[$ext])) ? $this->mimes[$ext] : 'application/octet-stream';
                $size = null;

                if (null !== $this->request->getQuery('size')) {
                    $size = strip_tags($this->request->getQuery('size'));
                }

                if ((null !== $size) && file_exists($_SERVER['DOCUMENT_ROOT'] . BASE_PATH . CONTENT_PATH . '/' . $media->library_folder . '/' . $size . '/'. $media->file)) {
                    $file = $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . CONTENT_PATH . '/' . $media->library_folder . '/' . $size . '/'. $media->file;
                } else {
                    $file = $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . CONTENT_PATH . '/' . $media->library_folder . '/' . $media->file;
                }

                header('Content-Type: ' . $mime);
                if ($this->request->getQuery('download') == 1) {
                    header('Content-Disposition: attachment; filename="' . $media->file . '"');
                }
                echo file_get_contents($file);
            } else {
                if ($this->application->isRegistered('phire-content')) {
                    $controller = new \Phire\Content\Controller\IndexController(
                        $this->application,
                        $this->request,
                        $this->response
                    );
                    $controller->error();
                } else {
                    $this->error();
                }
            }
        }
    }
}
