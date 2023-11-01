<?php

namespace App\Service;

use PharIo\Manifest\ElementCollectionException;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Component\DependencyInjection\Exception\EnvParameterException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function PHPUnit\Framework\fileExists;
use function PHPUnit\Framework\throwException;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @throws \Exception
     */
    public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        // On donne un nouveau nom à l'image
        $fichier = md5(uniqid(rand(), true)) . '.webp';

        // On récupère les infos de l'image
        $pictureInfos = getimagesize($picture);

        if ($picture === false) {
            throw new \Exception('Format d\'image incorrect');
        }

        // On vérifie le format de l'image
        switch ($pictureInfos['mime']) {
            case 'image/png':
                $pictureSource = imagecreatefrompng($picture);
            case 'image/jpeg':
                $pictureSource = imagecreatefromjpeg($picture);
            case 'image/webp':
                $pictureSource = imagecreatefromwebp($picture);
            default:
                throw new \Exception('Format d\'image incorrect');
        }

        // On recadre l'image
        // On récupère les dimensions
        $imageWidth = $pictureInfos[0];
        $imageHeight = $pictureInfos[1];

        // On vérifie l'orientation de l'image
        switch ($imageWidth <=> $imageHeight) {
            case -1: // portrait
                $squareSize = $imageWidth;
                $src_X = 0;
                $src_Y = ($imageHeight - $squareSize) / 2;
                break;
            case 0: // carré
                $squareSize = $imageWidth;
                $src_X = 0;
                $src_Y = 0;
                break;
            case 1: // paysage
                $squareSize = $imageHeight;
                $src_X = ($imageWidth - $squareSize) / 2;
                $src_Y = 0;
                break;
        }

        // On crée une nouvelle image 'vierge'
        $resizePicture = imagecreatetruecolor($width, $height);

        imagecopyresampled($resizePicture, $pictureSource, 0, 0, $src_X, $src_Y, $width, $height, $squareSize);

        $path = $this->params->get('images_directory') . $folder;

        // On crée le dossier de destination s'il n'existe pas
        if (!file_exists($path . '/mini/')) {
            mkdir('/mini/', 0755, true);
        }

        // On stocke l'image recadrée
        imagewebp($resizePicture, $path . '/mini/' . $width . 'x' . $height . '-' . $fichier);

        $picture->move($path . '/', $fichier);

        return $fichier;
    }

    public function delete(string $fichier, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        if ($fichier !== 'default.webp') {
            $success = false;
            $path = $this->params->get('images_directory') . $folder;

            $mini = $path . '/mini/' . $width . 'x' . $height . '-' . $fichier;

            if (file_exists($mini)) {
                unlink($mini);
                $success = true;
            }

            $original = $path . '/' . $fichier;

            if (file_exists($original)) {
                unlink($mini);
                $success = true;
            }
            return $success;
       }
        return false;
    }
}