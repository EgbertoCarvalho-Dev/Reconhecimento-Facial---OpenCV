<?php

namespace App\Controllers;

use App\Models\Face;
use Slim\Psr7\Request;
use Slim\Psr7\Response;


class Recognize
{


    public function register(Request $request, Response $response)
    {
        $auth = new Auth();

        if ($auth->checkToken($_POST['token']) != false) {
            $status = 201;

            if ($_FILES['image']['name'] != '') {

                $uniqid = uniqid();

                $imageData = file_get_contents($_FILES['image']['tmp_name']);

                $base64Image = base64_encode($imageData);

                $dataInsert = [
                    'uniqid' => $uniqid,
                    'face' => $base64Image
                ];

                $face = new Face();

                $face::create($dataInsert);


                $data = [
                    'status' => 'success',
                    'msg' => 'Done!',
                    'uniqueToken' => $uniqid
                ];
            } else {
                $status = 400;

                $data = [
                    'status' => 'failed',
                    'msg' => 'Failed to create Recognize Face on DB, needs send image with image post'
                ];
            }
        } else {
            $status = 401;

            $data = [
                'status' => 'failed',
                'msg' => 'Failed to check token, contact administrator to create your token'
            ];
        }


        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }


    public function registerToken(Request $request, Response $response)
    {
        $auth = new Auth();

        $token = $auth->generateToken();

        $response->getBody()->write(json_encode(['token' => $token]));

        $status = 201;

        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }

    public function compareFaces(Request $request, Response $response)
    {
        $auth = new Auth();
        if ($auth->checkToken($_POST['token']) != false) {
            $status = 200;


            $data = [
                'status' => 'success',
                'msg' => 'Done!',
                'uniqueToken' => ''
            ];
        } else {
            $status = 401;

            $data = [
                'status' => 'failed',
                'msg' => 'Failed to check token, contact administrator to create your token'
            ];
        }

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
