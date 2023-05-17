<?php
namespace App\Controllers\Api;

use App\Services\DbService;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class ExampleController
{
    public function show(Request $request, int $task_id): JsonResponse
    {
        $response = new JsonResponse();
        $data = DbService::findOne($task_id);

        if (!$data) {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);

            return $response->setData([
                'status' => 'not_found',
                'result' => null,
            ]);
        }

        return $response->setData($data);
    }

    /**
     * @throws
     */
    public function store(Request $request): JsonResponse
    {
        $response = new JsonResponse();

        $uploadedFile = $request->files->get('photo');
        $path = '../public/uploads';
        $fileName = $uploadedFile->getClientOriginalName();
        if (file_exists($path .'/'. $fileName)) {
            return $response->setData(['status' => 'ready']);
        }
        $res = $uploadedFile->move($path, $fileName);
        $curl_file = curl_file_create($res->getPathname(), 'image/jpeg');

        $fields = array(
            'name' => $request->get('name'),
            'photo' => DataPart::fromPath($curl_file->name),

        );

        $resultResponse = $this->makeClientResponse($fields);

        if ($resultResponse['status'] === 'wait') {
            sleep(3);

            $fields = array(
                'retry_id' => $resultResponse['retry_id'],
            );

            $resultResponse = $this->makeClientResponse($fields);
            return $response->setData($resultResponse);
        }

        DbService::create($resultResponse);

        return $response->setData($resultResponse);
    }

    private function makeClientResponse(array $fields): array
    {
        $formData = new FormDataPart($fields);
        $client = HttpClient::create();

        $result = $client->request(
            'POST',
            'http://merlinface.com:12345/api/', [
                'headers' => $formData->getPreparedHeaders()->toArray(),
                'body' => $formData->bodyToIterable(),
            ]

        );
        return $result->toArray();
    }
}